<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RapportController extends Controller
{
    /**
     * Affiche la liste des rapports avec recherche et pagination
     */
    public function index(Request $request)
    {
        $query = Rapport::with('auteur');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('titre', 'like', "%{$search}%")
                  ->orWhere('contenu', 'like', "%{$search}%");
        }

        $rapports = $query->orderBy('date_rapport', 'desc')->paginate(10);

        return view('rapports.index', compact('rapports'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        session()->forget(['rapport_brouillon', 'draft_data', 'auto_save', 'rapport_draft']);
        return view('rapports.create')->with('clear_localStorage', true);
    }

    /**
     * Affiche un rapport spécifique
     */
    public function show($id)
    {
        try {
            $rapport = Rapport::with('auteur')->findOrFail($id);
            return view('rapports.show', compact('rapport'));
        } catch (\Exception $e) {
            Log::error('Erreur affichage rapport:', [
                'rapport_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            return redirect()->route('rapports.index')
                           ->with('error', 'Rapport introuvable.');
        }
    }

    /**
     * Enregistre un nouveau rapport
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string|min:10',
            'date_rapport' => 'required|date|after_or_equal:today',
            'envoyer_notification' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $rapport = new Rapport();
            $rapport->titre = $validated['titre'];
            $rapport->contenu = $validated['contenu'];
            $rapport->date_rapport = $validated['date_rapport'];
            $rapport->auteur_id = Auth::id();
            $rapport->envoyer_notification = $request->has('envoyer_notification');
            $rapport->save();

            session()->forget(['rapport_brouillon', 'draft_data', 'auto_save', 'rapport_draft']);
            DB::commit();

            return redirect()->route('rapports.index')
                           ->with('success', 'Rapport "' . $validated['titre'] . '" créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création rapport:', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            return back()->withInput()
                        ->with('error', 'Erreur lors de la création du rapport.');
        }
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Rapport $rapport)
    {
        return view('rapports.edit', compact('rapport'));
    }

    /**
     * Met à jour un rapport
     */
    public function update(Request $request, Rapport $rapport)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string|min:10',
            'date_rapport' => 'required|date|after_or_equal:today',
            'envoyer_notification' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $rapport->titre = $validated['titre'];
            $rapport->contenu = $validated['contenu'];
            $rapport->date_rapport = $validated['date_rapport'];

            if (!$rapport->auteur_id) {
                $rapport->auteur_id = Auth::id();
            }

            $rapport->envoyer_notification = $request->has('envoyer_notification');
            $rapport->save();
            DB::commit();

            return redirect()->route('rapports.index')
                           ->with('success', 'Rapport "' . $validated['titre'] . '" mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur mise à jour rapport:', [
                'rapport_id' => $rapport->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()
                        ->with('error', 'Erreur lors de la mise à jour du rapport.');
        }
    }

    /**
     * Supprime un rapport
     */
    public function destroy(Rapport $rapport)
    {
        DB::beginTransaction();
        try {
            $titreRapport = $rapport->titre;
            $rapport->delete();
            DB::commit();

            return redirect()->route('rapports.index')
                           ->with('success', 'Rapport "' . $titreRapport . '" supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur suppression rapport:', [
                'rapport_id' => $rapport->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('rapports.index')
                           ->with('error', 'Erreur lors de la suppression du rapport.');
        }
    }

    /**
     * Télécharge un rapport en PDF
     */
    public function downloadPDF($id)
    {
        try {
            $rapport = Rapport::with('auteur')->findOrFail($id);

            $pdf = Pdf::loadView('rapports.pdf-single', compact('rapport'))
                      ->setPaper('a4', 'portrait');

            return $pdf->download('rapport_' . $rapport->id . '_' . date('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            Log::error('Erreur génération PDF rapport:', [
                'rapport_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                           ->with('error', 'Erreur lors de la génération du PDF: ' . $e->getMessage());
        }
    }

    /**
     * Export Excel de tous les rapports
     */
    public function exportExcel()
    {
        try {
            $rapports = Rapport::with('auteur')->orderBy('date_rapport', 'desc')->get();

            $fileName = 'rapports_export_' . now()->format('Y_m_d_H_i_s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($rapports) {
                $file = fopen('php://output', 'w');
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                fputcsv($file, ['ID', 'Titre', 'Auteur', 'Date Rapport', 'Notification', 'Créé le'], ';');

                foreach ($rapports as $rapport) {
                    fputcsv($file, [
                        $rapport->id,
                        $rapport->titre,
                        $rapport->auteur->name ?? 'Non défini',
                        $rapport->date_rapport ? $rapport->date_rapport->format('d/m/Y') : '-',
                        $rapport->envoyer_notification ? 'Oui' : 'Non',
                        $rapport->created_at?->format('d/m/Y H:i') ?? '',
                    ], ';');
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Erreur export Excel rapports:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erreur lors de l\'export Excel.');
        }
    }

    /**
     * Génère un rapport personnalisé
     */
    public function generateCustomReport(Request $request)
    {
        try {
            $validated = $request->validate([
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after:date_debut',
                'auteur_id' => 'nullable|exists:users,id',
            ]);

            $query = Rapport::query()
                           ->whereBetween('date_rapport', [$validated['date_debut'], $validated['date_fin']]);

            if ($validated['auteur_id']) {
                $query->where('auteur_id', $validated['auteur_id']);
            }

            $rapports = $query->with('auteur')->orderBy('date_rapport', 'desc')->get();

            return view('rapports.custom_report', compact('rapports', 'validated'));

        } catch (\Exception $e) {
            Log::error('Erreur rapport personnalisé:', ['error' => $e->getMessage()]);
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la génération du rapport personnalisé.');
        }
    }

    /**
     * Sauvegarde automatique (AJAX)
     */
    public function autoSave(Request $request)
    {
        try {
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'contenu' => 'required|string',
                'date_rapport' => 'required|date',
            ]);

            session(['rapport_draft' => $validated]);

            return response()->json([
                'success' => true,
                'message' => 'Brouillon sauvegardé',
                'timestamp' => now()->format('H:i:s')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde'
            ], 500);
        }
    }
}

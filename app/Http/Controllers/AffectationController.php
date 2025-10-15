<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Materiel;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AffectationController extends Controller
{
    public function index(Request $request)
    {
        $query = Affectation::with(['materiel', 'user', 'service']);

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('materiel', function($subQuery) use ($search) {
                    $subQuery->where('nom', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('numero_serie', 'like', "%{$search}%");
                })->orWhereHas('user', function($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('service', function($subQuery) use ($search) {
                    $subQuery->where('nom', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                })->orWhere('numero_affectation', 'like', "%{$search}%");
            });
        }

        $affectations = $query->latest()->paginate(15);

        return view('affectations.index', compact('affectations'));
    }

    public function create()
    {
        $materiels = Materiel::where('statut', 'disponible')->get();
        $users = User::all();
        $services = Service::all();

        return view('affectations.create', compact('materiels', 'users', 'services'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'envoyer_notification' => $request->has('envoyer_notification')
        ]);

        $validatedData = $request->validate([
            'materiel_id' => 'required|exists:materiels,id',
            'user_id' => 'nullable|exists:users,id',
            'service_id' => 'nullable|exists:services,id',
            'numero_affectation' => 'nullable|string|unique:affectations',
            'date_affectation' => 'required|date',
            'date_retour_prevue' => 'nullable|date|after_or_equal:date_affectation',
            'date_retour' => 'nullable|date|after_or_equal:date_affectation',
            'statut' => 'nullable|in:en cours,en attente,terminé,annulé',
            'priorite' => 'nullable|in:faible,normale,urgente',
            'lieu_utilisation' => 'nullable|string|max:255',
            'responsable_validation' => 'nullable|string|max:255',
            'commentaire' => 'nullable|string',
            'envoyer_notification' => 'boolean',
        ]);

        $validatedData['responsable_validation'] = $validatedData['responsable_validation'] ?? Auth::user()->name;
        $validatedData['statut'] = $validatedData['statut'] ?? 'en cours';
        $validatedData['priorite'] = $validatedData['priorite'] ?? 'normale';

        if (empty($validatedData['numero_affectation'])) {
            $validatedData['numero_affectation'] = $this->generateNumeroAffectation();
        }

        try {
            $affectation = Affectation::create($validatedData);

            $materiel = Materiel::find($validatedData['materiel_id']);
            if ($materiel) {
                $materiel->update(['statut' => 'affecté']);
            }

            if ($request->boolean('envoyer_notification') && $affectation->user && $affectation->user->email) {
                $this->sendNotification($affectation, 'creation');
            }

            return redirect()->route('affectations.index')
                             ->with('success', 'Affectation créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création affectation: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Erreur lors de la création de l\'affectation.');
        }
    }

    public function show(Affectation $affectation)
    {
        $affectation->load(['materiel', 'user', 'service']);
        return view('affectations.show', compact('affectation'));
    }

    public function edit(Affectation $affectation)
    {
        $materiels = Materiel::all();
        $users = User::all();
        $services = Service::all();

        return view('affectations.edit', compact('affectation', 'materiels', 'users', 'services'));
    }

    public function update(Request $request, Affectation $affectation)
    {
        $request->merge([
            'envoyer_notification' => $request->has('envoyer_notification')
        ]);

        $validatedData = $request->validate([
            'materiel_id' => 'required|exists:materiels,id',
            'user_id' => 'nullable|exists:users,id',
            'service_id' => 'nullable|exists:services,id',
            'numero_affectation' => 'nullable|string|unique:affectations,numero_affectation,' . $affectation->id,
            'date_affectation' => 'required|date',
            'date_retour_prevue' => 'nullable|date|after_or_equal:date_affectation',
            'date_retour' => 'nullable|date|after_or_equal:date_affectation',
            'statut' => 'nullable|in:en cours,en attente,terminé,annulé',
            'priorite' => 'nullable|in:faible,normale,urgente',
            'lieu_utilisation' => 'nullable|string|max:255',
            'responsable_validation' => 'nullable|string|max:255',
            'commentaire' => 'nullable|string',
            'envoyer_notification' => 'boolean',
        ]);

        try {
            if ($validatedData['materiel_id'] != $affectation->materiel_id) {
                if ($affectation->materiel) {
                    $affectation->materiel->update(['statut' => 'disponible']);
                }
                $nouveauMateriel = Materiel::find($validatedData['materiel_id']);
                if ($nouveauMateriel) {
                    $nouveauMateriel->update(['statut' => 'affecté']);
                }
            }

            if (isset($validatedData['statut']) && $validatedData['statut'] === 'terminé' && $affectation->statut !== 'terminé') {
                if ($affectation->materiel) {
                    $affectation->materiel->update(['statut' => 'disponible']);
                }
                $validatedData['date_retour'] = $validatedData['date_retour'] ?? now()->toDateString();
            }

            $affectation->update($validatedData);

            if ($request->boolean('envoyer_notification') && $affectation->user && $affectation->user->email) {
                $this->sendNotification($affectation, 'modification');
            }

            return redirect()->route('affectations.index')
                             ->with('success', 'Affectation mise à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour affectation: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Erreur lors de la mise à jour de l\'affectation.');
        }
    }

    public function destroy(Affectation $affectation)
    {
        try {
            if ($affectation->materiel) {
                $affectation->materiel->update(['statut' => 'disponible']);
            }

            $affectation->delete();

            return redirect()->route('affectations.index')
                             ->with('success', 'Affectation supprimée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression affectation: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Erreur lors de la suppression de l\'affectation.');
        }
    }

    // NOUVELLES MÉTHODES POUR EXPORT

    /**
     * Export Excel (CSV)
     */
    public function exportExcel(Request $request)
    {
        try {
            $query = Affectation::with(['materiel', 'user', 'service']);

            if ($request->filled('statut')) {
                $query->where('statut', $request->statut);
            }

            $affectations = $query->get();

            $filename = 'affectations_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($affectations) {
                $file = fopen('php://output', 'w');

                // BOM UTF-8 pour Excel
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // En-têtes
                fputcsv($file, [
                    'ID',
                    'Numéro Affectation',
                    'Matériel',
                    'Utilisateur',
                    'Service',
                    'Date Affectation',
                    'Date Retour Prévue',
                    'Date Retour',
                    'Statut',
                    'Priorité',
                    'Lieu',
                    'Responsable',
                    'Commentaire'
                ], ';');

                foreach ($affectations as $affectation) {
                    fputcsv($file, [
                        $affectation->id,
                        $affectation->numero_affectation,
                        $affectation->materiel->nom ?? $affectation->materiel->name ?? '-',
                        $affectation->user->name ?? '-',
                        $affectation->service->nom ?? $affectation->service->name ?? '-',
                        $affectation->date_affectation ? Carbon::parse($affectation->date_affectation)->format('d/m/Y') : '-',
                        $affectation->date_retour_prevue ? Carbon::parse($affectation->date_retour_prevue)->format('d/m/Y') : '-',
                        $affectation->date_retour ? Carbon::parse($affectation->date_retour)->format('d/m/Y') : '-',
                        ucfirst($affectation->statut),
                        ucfirst($affectation->priorite),
                        $affectation->lieu_utilisation ?? '-',
                        $affectation->responsable_validation ?? '-',
                        $affectation->commentaire ?? '-'
                    ], ';');
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Erreur export Excel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'export Excel.');
        }
    }

    /**
     * Export PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $query = Affectation::with(['materiel', 'user', 'service']);

            if ($request->filled('statut')) {
                $query->where('statut', $request->statut);
            }

            $affectations = $query->get();

            $pdf = Pdf::loadView('affectations.pdf', compact('affectations'))
                      ->setPaper('a4', 'landscape');

            return $pdf->download('affectations_' . date('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            Log::error('Erreur export PDF: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'export PDF. Vérifiez que dompdf est installé.');
        }
    }

    /**
     * Actions groupées
     */
    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids', []);
        $action = $request->input('action');

        if (empty($ids)) {
            return response()->json(['error' => 'Aucune affectation sélectionnée.'], 400);
        }

        try {
            $count = 0;
            $affectations = Affectation::whereIn('id', $ids)->get();

            foreach ($affectations as $affectation) {
                switch ($action) {
                    case 'terminer':
                        $affectation->update([
                            'statut' => 'terminé',
                            'date_retour' => now()->toDateString()
                        ]);
                        if ($affectation->materiel) {
                            $affectation->materiel->update(['statut' => 'disponible']);
                        }
                        $count++;
                        break;

                    case 'supprimer':
                        if ($affectation->materiel) {
                            $affectation->materiel->update(['statut' => 'disponible']);
                        }
                        $affectation->delete();
                        $count++;
                        break;

                    default:
                        return response()->json(['error' => 'Action non reconnue.'], 400);
                }
            }

            $messages = [
                'terminer' => "$count affectation(s) terminée(s) avec succès.",
                'supprimer' => "$count affectation(s) supprimée(s) avec succès."
            ];

            return response()->json([
                'success' => true,
                'message' => $messages[$action] ?? 'Action effectuée avec succès.'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur action groupée: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de l\'action groupée.'], 500);
        }
    }

    // Méthodes auxiliaires
    private function sendNotification(Affectation $affectation, string $type)
    {
        try {
            // Mail::to($affectation->user->email)->send(new AffectationNotification($affectation, $type));

            $affectation->update(['notification_envoyee' => true]);
            Log::info("Notification {$type} envoyée pour l'affectation {$affectation->id}");
        } catch (\Exception $e) {
            Log::error('Erreur envoi notification: ' . $e->getMessage());
        }
    }

    private function generateNumeroAffectation(): string
    {
        $prefix = 'AFF';
        $year = date('Y');
        $lastAffectation = Affectation::where('numero_affectation', 'like', $prefix . $year . '%')
                                    ->orderBy('numero_affectation', 'desc')
                                    ->first();

        if ($lastAffectation) {
            $lastNumber = intval(substr($lastAffectation->numero_affectation, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}

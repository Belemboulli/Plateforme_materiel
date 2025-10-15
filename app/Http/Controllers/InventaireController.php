<?php

namespace App\Http\Controllers;

use App\Models\Inventaire;
use App\Models\Materiel;
use Illuminate\Http\Request;

class InventaireController extends Controller
{
    /**
     * Affiche la liste des inventaires
     */
    public function index()
    {
        $inventaires = Inventaire::with('materiel')->latest()->paginate(15);
        return view('inventaires.index', compact('inventaires'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $materiels = Materiel::all();
        return view('inventaires.create', compact('materiels'));
    }

    /**
     * Enregistre un nouvel inventaire
     */
    public function store(Request $request)
    {
        $request->validate([
            'materiel_id' => 'required|exists:materiels,id',
            'quantite_disponible' => 'required|integer|min:0',
            'quantite_utilisee' => 'required|integer|min:0',
            'quantite_defaillante' => 'nullable|integer|min:0',
            'quantite_perdue' => 'nullable|integer|min:0',
            'date_inventaire' => 'required|date|before_or_equal:today',
            'responsable_id' => 'nullable|integer',
            'observations' => 'nullable|string|max:1000',
        ], [
            'materiel_id.required' => 'Veuillez sélectionner un matériel.',
            'materiel_id.exists' => 'Le matériel sélectionné n\'existe pas.',
            'quantite_disponible.required' => 'La quantité disponible est obligatoire.',
            'quantite_disponible.min' => 'La quantité disponible ne peut pas être négative.',
            'quantite_utilisee.required' => 'La quantité utilisée est obligatoire.',
            'quantite_utilisee.min' => 'La quantité utilisée ne peut pas être négative.',
            'quantite_defaillante.min' => 'La quantité défaillante ne peut pas être négative.',
            'quantite_perdue.min' => 'La quantité perdue ne peut pas être négative.',
            'date_inventaire.required' => 'La date d\'inventaire est obligatoire.',
            'date_inventaire.before_or_equal' => 'La date d\'inventaire ne peut pas être dans le futur.',
            'observations.max' => 'Les observations ne peuvent pas dépasser 1000 caractères.',
        ]);

        // Préparer les données avec valeurs par défaut
        $data = $request->all();
        $data['quantite_defaillante'] = $request->quantite_defaillante ?? 0;
        $data['quantite_perdue'] = $request->quantite_perdue ?? 0;

        // Calculer le total pour logging
        $total = $data['quantite_disponible'] + $data['quantite_utilisee'] +
                $data['quantite_defaillante'] + $data['quantite_perdue'];

        // Créer l'inventaire
        $inventaire = Inventaire::create($data);

        return redirect()->route('inventaires.index')
                        ->with('success', "Inventaire créé avec succès. Total inventorié: {$total} unités.");
    }

    /**
     * Affiche un inventaire spécifique
     */
    public function show(Inventaire $inventaire)
    {
        $inventaire->load('materiel');

        // Calculer les totaux et écarts
        $totalInventorie = $inventaire->quantite_disponible + $inventaire->quantite_utilisee +
                          ($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0);

        $stockSysteme = $inventaire->materiel->quantite ?? 0;
        $ecart = $totalInventorie - $stockSysteme;

        return view('inventaires.show', compact('inventaire', 'totalInventorie', 'stockSysteme', 'ecart'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Inventaire $inventaire)
    {
        $materiels = Materiel::all();
        $inventaire->load('materiel');
        return view('inventaires.edit', compact('inventaire', 'materiels'));
    }

    /**
     * Met à jour un inventaire
     */
    public function update(Request $request, Inventaire $inventaire)
    {
        $request->validate([
            'materiel_id' => 'required|exists:materiels,id',
            'quantite_disponible' => 'required|integer|min:0',
            'quantite_utilisee' => 'required|integer|min:0',
            'quantite_defaillante' => 'nullable|integer|min:0',
            'quantite_perdue' => 'nullable|integer|min:0',
            'date_inventaire' => 'required|date|before_or_equal:today',
            'responsable_id' => 'nullable|integer',
            'observations' => 'nullable|string|max:1000',
        ], [
            'materiel_id.required' => 'Veuillez sélectionner un matériel.',
            'materiel_id.exists' => 'Le matériel sélectionné n\'existe pas.',
            'quantite_disponible.required' => 'La quantité disponible est obligatoire.',
            'quantite_disponible.min' => 'La quantité disponible ne peut pas être négative.',
            'quantite_utilisee.required' => 'La quantité utilisée est obligatoire.',
            'quantite_utilisee.min' => 'La quantité utilisée ne peut pas être négative.',
            'quantite_defaillante.min' => 'La quantité défaillante ne peut pas être négative.',
            'quantite_perdue.min' => 'La quantité perdue ne peut pas être négative.',
            'date_inventaire.required' => 'La date d\'inventaire est obligatoire.',
            'date_inventaire.before_or_equal' => 'La date d\'inventaire ne peut pas être dans le futur.',
            'observations.max' => 'Les observations ne peuvent pas dépasser 1000 caractères.',
        ]);

        // Sauvegarder les anciennes valeurs pour comparaison
        $ancienTotal = $inventaire->quantite_disponible + $inventaire->quantite_utilisee +
                      ($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0);

        // Préparer les données avec valeurs par défaut
        $data = $request->all();
        $data['quantite_defaillante'] = $request->quantite_defaillante ?? 0;
        $data['quantite_perdue'] = $request->quantite_perdue ?? 0;

        // Calculer le nouveau total
        $nouveauTotal = $data['quantite_disponible'] + $data['quantite_utilisee'] +
                       $data['quantite_defaillante'] + $data['quantite_perdue'];

        // Mettre à jour l'inventaire
        $inventaire->update($data);

        $ecart = $nouveauTotal - $ancienTotal;
        $message = "Inventaire mis à jour avec succès.";

        if ($ecart != 0) {
            $message .= " Écart détecté: " . ($ecart > 0 ? "+{$ecart}" : $ecart) . " unités.";
        }

        return redirect()->route('inventaires.index')->with('success', $message);
    }

    /**
     * Supprime un inventaire
     */
    public function destroy(Inventaire $inventaire)
    {
        $materielNom = $inventaire->materiel->nom ?? 'Matériel inconnu';
        $inventaire->delete();

        return redirect()->route('inventaires.index')
                        ->with('success', "Inventaire du matériel '{$materielNom}' supprimé avec succès.");
    }

    /**
     * Recherche et filtrage des inventaires
     */
    public function search(Request $request)
    {
        $query = Inventaire::with('materiel');

        // Filtre par matériel
        if ($request->filled('materiel_id')) {
            $query->where('materiel_id', $request->materiel_id);
        }

        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->whereDate('date_inventaire', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date_inventaire', '<=', $request->date_fin);
        }

        // Filtre par quantités
        if ($request->filled('quantite_min')) {
            $query->whereRaw('(quantite_disponible + quantite_utilisee + COALESCE(quantite_defaillante, 0) + COALESCE(quantite_perdue, 0)) >= ?',
                            [$request->quantite_min]);
        }

        $inventaires = $query->latest()->paginate(15);
        $materiels = Materiel::all();

        return view('inventaires.index', compact('inventaires', 'materiels'));
    }

    /**
     * Export des données d'inventaire
     */
    public function export()
    {
        $inventaires = Inventaire::with('materiel')->latest()->get();

        $filename = 'inventaires_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($inventaires) {
            $file = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Matériel', 'Référence', 'Disponible', 'Utilisée',
                'Défaillante', 'Perdue', 'Total', 'Date Inventaire',
                'Observations', 'Créé le', 'Modifié le'
            ]);

            foreach ($inventaires as $inventaire) {
                $total = $inventaire->quantite_disponible + $inventaire->quantite_utilisee +
                        ($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0);

                fputcsv($file, [
                    $inventaire->id,
                    $inventaire->materiel->nom ?? 'N/A',
                    $inventaire->materiel->reference ?? 'N/A',
                    $inventaire->quantite_disponible,
                    $inventaire->quantite_utilisee,
                    $inventaire->quantite_defaillante ?? 0,
                    $inventaire->quantite_perdue ?? 0,
                    $total,
                    $inventaire->date_inventaire,
                    $inventaire->observations ?? '',
                    $inventaire->created_at->format('d/m/Y H:i'),
                    $inventaire->updated_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

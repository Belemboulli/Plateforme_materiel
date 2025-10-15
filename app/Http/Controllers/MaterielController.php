<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Categorie;
use Illuminate\Http\Request;

class MaterielController extends Controller
{
    /**
     * Affiche la liste de tous les matériels.
     */
    public function index()
    {
        $materiels = Materiel::with('categorie')->latest()->paginate(10);
        return view('materiels.index', compact('materiels'));
    }

    /**
     * Affiche le formulaire de création d’un matériel.
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('materiels.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau matériel en base.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'quantite' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        Materiel::create([
            'nom' => $request->nom,
            'categorie_id' => $request->categorie_id,
            'quantite' => $request->quantite,
            'description' => $request->description,
        ]);

        return redirect()->route('materiels.index')
                         ->with('success', 'Matériel ajouté avec succès ✅');
    }

    /**
     * Affiche un matériel spécifique.
     */
    public function show(Materiel $materiel)
    {
        return view('materiels.show', compact('materiel'));
    }

    /**
     * Affiche le formulaire d’édition d’un matériel.
     */
    public function edit(Materiel $materiel)
    {
        $categories = Categorie::all();
        return view('materiels.edit', compact('materiel', 'categories'));
    }

    /**
     * Met à jour un matériel.
     */
    public function update(Request $request, Materiel $materiel)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'quantite' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        $materiel->update([
            'nom' => $request->nom,
            'categorie_id' => $request->categorie_id,
            'quantite' => $request->quantite,
            'description' => $request->description,
        ]);

        return redirect()->route('materiels.index')
                         ->with('success', 'Matériel mis à jour avec succès ✏️');
    }

    /**
     * Supprime un matériel.
     */
    public function destroy(Materiel $materiel)
    {
        $materiel->delete();

        return redirect()->route('materiels.index')
                         ->with('success', 'Matériel supprimé avec succès 🗑️');
    }
}

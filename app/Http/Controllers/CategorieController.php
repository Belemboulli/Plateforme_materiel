<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Affiche la liste de toutes les catégories
     */
    public function index()
    {
        $categories = Categorie::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle catégorie
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Sauvegarde une nouvelle catégorie en base de données
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
        ]);

        Categorie::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')
                         ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Affiche une catégorie spécifique
     * Utilise le Route Model Binding pour éviter les erreurs de paramètre
     */
    public function show(Categorie $category)
    {
        return view('categories.show', ['categorie' => $category]);
    }

    /**
     * Affiche le formulaire d’édition d’une catégorie
     */
    public function edit(Categorie $category)
    {
        return view('categories.edit', ['categorie' => $category]);
    }

    /**
     * Met à jour une catégorie existante
     */
    public function update(Request $request, Categorie $category)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')
                         ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Supprime une catégorie
     */
    public function destroy(Categorie $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Catégorie supprimée avec succès.');
    }
}

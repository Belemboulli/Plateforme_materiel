<?php

namespace App\Http\Controllers;

use App\Models\Localisation;
use Illuminate\Http\Request;

class LocalisationController extends Controller
{
    /**
     * Affiche la liste des localisations.
     */
    public function index()
    {
        $localisations = Localisation::paginate(10);
        return view('localisations.index', compact('localisations'));
    }

    /**
     * Formulaire de création d'une localisation.
     */
    public function create()
    {
        return view('localisations.create');
    }

    /**
     * Enregistre une nouvelle localisation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:localisations,code',
            'batiment' => 'nullable|string|max:255',
            'etage' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        Localisation::create($request->all());

        return redirect()->route('localisations.index')
                         ->with('success', 'Localisation créée avec succès.');
    }

    /**
     * Affiche une localisation précise.
     */
    public function show(Localisation $localisation)
    {
        return view('localisations.show', compact('localisation'));
    }

    /**
     * Formulaire d'édition d'une localisation.
     */
    public function edit(Localisation $localisation)
    {
        return view('localisations.edit', compact('localisation'));
    }

    /**
     * Met à jour une localisation existante.
     */
    public function update(Request $request, Localisation $localisation)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:localisations,code,' . $localisation->id,
            'batiment' => 'nullable|string|max:255',
            'etage' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $localisation->update($request->all());

        return redirect()->route('localisations.index')
                         ->with('success', 'Localisation mise à jour avec succès.');
    }

    /**
     * Supprime une localisation.
     */
    public function destroy(Localisation $localisation)
    {
        $localisation->delete();

        return redirect()->route('localisations.index')
                         ->with('success', 'Localisation supprimée avec succès.');
    }
}

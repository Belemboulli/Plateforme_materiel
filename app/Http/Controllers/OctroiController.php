<?php

namespace App\Http\Controllers;

use App\Models\Octroi;
use App\Models\Materiel;
use App\Models\Structure;
use Illuminate\Http\Request;

class OctroiController extends Controller
{
    /**
     * Affiche tous les octrois avec pagination.
     */
    public function index()
    {
        $octrois = Octroi::with(['materiel', 'structure'])
                         ->latest()
                         ->paginate(10);

        return view('octrois.index', compact('octrois'));
    }

    /**
     * Affiche le formulaire de création d'un octroi.
     */
    public function create()
    {
        $materiels = Materiel::all();
        $structures = Structure::all();

        return view('octrois.create', compact('materiels', 'structures'));
    }

    /**
     * Enregistre un nouvel octroi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'materiel_id'  => 'required|exists:materiels,id',
            'structure_id' => 'required|exists:structures,id',
            'quantite'     => 'required|integer|min:1',
        ]);

        Octroi::create([
            'materiel_id'  => $request->materiel_id,
            'structure_id' => $request->structure_id,
            'quantite'     => $request->quantite,
        ]);

        return redirect()->route('octrois.index')
                         ->with('success', 'Octroi créé avec succès');
    }

    /**
     * Affiche un octroi spécifique.
     */
    public function show(Octroi $octroi)
    {
        $octroi->load(['materiel', 'structure']);
        return view('octrois.show', compact('octroi'));
    }

    /**
     * Affiche le formulaire d'édition d'un octroi existant.
     */
    public function edit(Octroi $octroi)
    {
        $materiels = Materiel::all();
        $structures = Structure::all();

        return view('octrois.edit', compact('octroi', 'materiels', 'structures'));
    }

    /**
     * Met à jour un octroi existant.
     */
    public function update(Request $request, Octroi $octroi)
    {
        $request->validate([
            'materiel_id'  => 'required|exists:materiels,id',
            'structure_id' => 'required|exists:structures,id',
            'quantite'     => 'required|integer|min:1',
        ]);

        $octroi->update([
            'materiel_id'  => $request->materiel_id,
            'structure_id' => $request->structure_id,
            'quantite'     => $request->quantite,
        ]);

        return redirect()->route('octrois.index')
                         ->with('success', 'Octroi mis à jour avec succès');
    }

    /**
     * Supprime un octroi.
     */
    public function destroy(Octroi $octroi)
    {
        $octroi->delete();

        return redirect()->route('octrois.index')
                         ->with('success', 'Octroi supprimé avec succès');
    }
}

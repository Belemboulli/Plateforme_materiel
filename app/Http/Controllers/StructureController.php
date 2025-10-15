<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use Illuminate\Http\Request;

class StructureController extends Controller
{
    public function index()
    {
        $structures = Structure::all();
        return view('structures.index', compact('structures'));
    }

    public function create()
    {
        return view('structures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'contact' => 'nullable|digits:8',
            'description' => 'nullable|string',
        ]);

        Structure::create($request->only(['nom','type','responsable','contact','description']));

        return redirect()->route('structures.index')->with('success', 'Structure ajoutée avec succès.');
    }

    public function show(Structure $structure)
    {
        return view('structures.show', compact('structure'));
    }

    public function edit(Structure $structure)
    {
        return view('structures.edit', compact('structure'));
    }

    public function update(Request $request, Structure $structure)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'contact' => 'nullable|digits:8',
            'description' => 'nullable|string',
        ]);

        $structure->update($request->only(['nom','type','responsable','contact','description']));

        return redirect()->route('structures.index')->with('success', 'Structure mise à jour avec succès.');
    }

    public function destroy(Structure $structure)
    {
        $structure->delete();
        return redirect()->route('structures.index')->with('success', 'Structure supprimée avec succès.');
    }
}

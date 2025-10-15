<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // Afficher la liste des permissions
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('permissions.create');
    }

    // Enregistrer une nouvelle permission
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'description' => 'nullable|string',
        ]);

        Permission::create($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission créée avec succès.');
    }

    // Afficher une permission spécifique
    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }

    // Formulaire pour éditer une permission
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    // Mettre à jour une permission
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string',
        ]);

        $permission->update($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission mise à jour avec succès.');
    }

    // Supprimer une permission
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission supprimée avec succès.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Liste des rôles avec statistiques.
     */
    public function index()
    {
        $roles = Role::withCount('users')
            ->orderBy('priority_level', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Formulaire de création d'un rôle.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Enregistrer un nouveau rôle.
     */
    public function store(Request $request)
    {
        // ✅ VALIDATION CORRIGÉE
        $validated = $request->validate([
            'name'           => 'required|string|max:50|unique:roles,name',
            'description'    => 'nullable|string|max:500',
            'priority_level' => 'required|integer|between:1,5', // ✅ required au lieu de nullable
            'is_active'      => 'nullable', // ✅ nullable au lieu de boolean
            'color'          => 'nullable|string|regex:/^#([0-9A-Fa-f]{3}){1,2}$/',
        ]);

        // ✅ GESTION CORRECTE DU CHECKBOX is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // ✅ GESTION CORRECTE DE LA COULEUR
        if (empty($validated['color']) || $validated['color'] === null) {
            $validated['color'] = '#2E7D32'; // Couleur par défaut UTS
        }

        // ✅ DEBUGGING - à supprimer après test
        \Log::info('Données validées pour création rôle:', $validated);

        DB::beginTransaction();
        try {
            $role = Role::create($validated);
            DB::commit();

            return redirect()->route('roles.index')
                ->with('success', 'Le rôle "' . $validated['name'] . '" a été créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();

            // ✅ DEBUGGING - Log l'erreur pour diagnostic
            \Log::error('Erreur création rôle:', [
                'message' => $e->getMessage(),
                'data' => $validated
            ]);

            return back()->withInput()
                ->with('error', 'Erreur lors de la création du rôle : ' . $e->getMessage());
        }
    }

    /**
     * Afficher les détails d'un rôle.
     */
    public function show(Role $role)
    {
        // ✅ CHARGEMENT SÉCURISÉ DES RELATIONS
        try {
            $role->load(['users'])->loadCount('users');

            // Charger permissions seulement si la relation existe
            if (method_exists($role, 'permissions')) {
                $role->load(['permissions'])->loadCount(['permissions']);
            }
        } catch (\Exception $e) {
            $role->loadCount('users');
        }

        return view('roles.show', compact('role'));
    }

    /**
     * Formulaire d'édition d'un rôle.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Mettre à jour un rôle.
     */
    public function update(Request $request, Role $role)
    {
        // ✅ VALIDATION COHÉRENTE AVEC STORE
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:50', Rule::unique('roles', 'name')->ignore($role->id)],
            'description'    => 'nullable|string|max:500',
            'priority_level' => 'required|integer|between:1,5', // ✅ required
            'is_active'      => 'nullable', // ✅ nullable
            'color'          => 'nullable|string|regex:/^#([0-9A-Fa-f]{3}){1,2}$/',
        ]);

        // ✅ GESTION CORRECTE DU CHECKBOX
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        DB::beginTransaction();
        try {
            $role->update($validated);
            DB::commit();

            return redirect()->route('roles.index')
                ->with('success', 'Le rôle "' . $validated['name'] . '" a été mis à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erreur mise à jour rôle:', [
                'message' => $e->getMessage(),
                'role_id' => $role->id,
                'data' => $validated
            ]);

            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour du rôle : ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un rôle.
     */
    public function destroy(Role $role)
    {
        $usersCount = $role->users()->count();

        if ($usersCount > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Impossible de supprimer ce rôle car il est assigné à ' . $usersCount . ' utilisateur(s).');
        }

        DB::beginTransaction();
        try {
            $roleName = $role->name;
            $role->delete();
            DB::commit();

            return redirect()->route('roles.index')
                ->with('success', 'Le rôle "' . $roleName . '" a été supprimé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')
                ->with('error', 'Erreur lors de la suppression du rôle. Veuillez réessayer.');
        }
    }

    /**
     * Activer/Désactiver un rôle via AJAX.
     */
    public function toggleStatus(Role $role)
    {
        try {
            $role->update(['is_active' => !$role->is_active]);

            return response()->json([
                'success'   => true,
                'is_active' => $role->is_active,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut.'
            ], 500);
        }
    }

    /**
     * Dupliquer un rôle.
     */
    public function duplicate(Role $role)
    {
        DB::beginTransaction();
        try {
            $newRole = $role->replicate();
            $newRole->name .= ' (Copie)';
            $newRole->is_active = false;
            $newRole->save();

            DB::commit();

            return redirect()->route('roles.edit', $newRole)
                ->with('success', 'Rôle dupliqué avec succès. Vous pouvez maintenant le modifier.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')
                ->with('error', 'Erreur lors de la duplication du rôle.');
        }
    }

    /**
     * Exporter les rôles en CSV.
     */
    public function export()
    {
        $roles = Role::withCount('users')->get();
        $fileName = 'roles_export_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($roles) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID','Nom','Description','Priorité','Statut','Couleur','Nb Utilisateurs','Créé','Modifié']);

            foreach ($roles as $role) {
                fputcsv($file, [
                    $role->id,
                    $role->name,
                    $role->description ?? '',
                    $role->priority_level ?? '',
                    $role->is_active ? 'Actif' : 'Inactif',
                    $role->color ?? '',
                    $role->users_count ?? 0,
                    $role->created_at?->format('d/m/Y H:i') ?? '',
                    $role->updated_at?->format('d/m/Y H:i') ?? '',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

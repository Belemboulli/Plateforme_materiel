<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    /**
     * Vérifie si l'utilisateur peut voir la liste des rôles.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur peut voir un rôle spécifique.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur peut créer un rôle.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur peut mettre à jour un rôle.
     */
    public function update(User $user, Role $role): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur peut supprimer un rôle.
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->role === 'admin';
    }
}

<?php

namespace App\Policies;

use App\Models\Affectation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AffectationPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des affectations.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    /**
     * Détermine si l'utilisateur peut voir une affectation spécifique.
     */
    public function view(User $user, Affectation $affectation): bool
    {
        return $user->role === 'admin'
            || $user->role === 'manager'
            || $user->id === $affectation->user_id; // Ex. il peut voir ses propres affectations
    }

    /**
     * Détermine si l'utilisateur peut créer une affectation.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour une affectation.
     */
    public function update(User $user, Affectation $affectation): bool
    {
        return $user->role === 'admin'
            || ($user->role === 'manager' && $user->id === $affectation->user_id);
    }

    /**
     * Détermine si l'utilisateur peut supprimer une affectation.
     */
    public function delete(User $user, Affectation $affectation): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut restaurer une affectation supprimée.
     */
    public function restore(User $user, Affectation $affectation): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut supprimer définitivement une affectation.
     */
    public function forceDelete(User $user, Affectation $affectation): bool
    {
        return $user->role === 'admin';
    }
}

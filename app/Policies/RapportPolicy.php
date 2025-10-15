<?php

namespace App\Policies;

use App\Models\Rapport;
use App\Models\User;

class RapportPolicy
{
    /**
     * Déterminer si l'utilisateur peut voir la liste des rapports.
     */
    public function viewAny(User $user): bool
    {
        return true; // tous les utilisateurs connectés peuvent voir
    }

    /**
     * Déterminer si l'utilisateur peut voir un rapport spécifique.
     */
    public function view(User $user, Rapport $rapport): bool
    {
        return true; // tous les utilisateurs peuvent consulter
    }

    /**
     * Déterminer si l'utilisateur peut créer un rapport.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'responsable';
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour un rapport.
     */
    public function update(User $user, Rapport $rapport): bool
    {
        return $user->id === $rapport->auteur_id || $user->role === 'admin';
    }

    /**
     * Déterminer si l'utilisateur peut supprimer un rapport.
     */
    public function delete(User $user, Rapport $rapport): bool
    {
        return $user->id === $rapport->auteur_id || $user->role === 'admin';
    }

    /**
     * Déterminer si l'utilisateur peut restaurer un rapport supprimé.
     */
    public function restore(User $user, Rapport $rapport): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Déterminer si l'utilisateur peut supprimer définitivement un rapport.
     */
    public function forceDelete(User $user, Rapport $rapport): bool
    {
        return $user->role === 'admin';
    }
}

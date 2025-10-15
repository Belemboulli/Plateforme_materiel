<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notification;

class NotificationPolicy
{
    /**
     * Déterminer si l'utilisateur peut voir la liste des notifications.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('manager');
    }

    /**
     * Déterminer si l'utilisateur peut voir une notification.
     */
    public function view(User $user, Notification $notification): bool
    {
        return $user->id === $notification->user_id || $user->hasRole('admin');
    }

    /**
     * Déterminer si l'utilisateur peut créer une notification.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour une notification.
     */
    public function update(User $user, Notification $notification): bool
    {
        return $user->id === $notification->user_id || $user->hasRole('admin');
    }

    /**
     * Déterminer si l'utilisateur peut supprimer une notification.
     */
    public function delete(User $user, Notification $notification): bool
    {
        return $user->id === $notification->user_id || $user->hasRole('admin');
    }
}

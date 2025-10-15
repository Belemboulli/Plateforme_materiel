<?php

namespace App\Policies;

use App\Models\HistoriqueConnexion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class HistoriqueConnexionPolicy
{
    use HandlesAuthorization;

    /**
     * Déterminer si l'utilisateur peut voir la liste des historiques.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Déterminer si l'utilisateur peut voir un historique précis.
     */
    public function view(User $user, HistoriqueConnexion $historiqueConnexion): bool
    {
        // Admin et super_admin peuvent voir tous les historiques
        if (in_array($user->role, ['admin', 'super_admin'])) {
            return true;
        }

        // Un utilisateur peut voir ses propres historiques
        return $user->id === $historiqueConnexion->user_id;
    }

    /**
     * Déterminer si l'utilisateur peut créer un historique.
     * Note: Les historiques sont générés automatiquement, pas de création manuelle
     */
    public function create(User $user): bool
    {
        // Seuls les admins peuvent créer manuellement des historiques (si nécessaire)
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour un historique.
     * Note: Les historiques ne doivent généralement pas être modifiés pour l'intégrité
     */
    public function update(User $user, ?HistoriqueConnexion $historiqueConnexion = null): bool
    {
        // Seuls les super_admin peuvent modifier les historiques en cas de besoin urgent
        return $user->role === 'super_admin';
    }

    /**
     * Déterminer si l'utilisateur peut supprimer un historique.
     * Cette méthode doit accepter un paramètre optionnel pour éviter l'erreur
     */
    public function delete(User $user, ?HistoriqueConnexion $historiqueConnexion = null): bool
    {
        // Vérification générale des permissions de suppression
        if (!in_array($user->role, ['admin', 'super_admin'])) {
            return false;
        }

        // Si aucun historique spécifique n'est fourni, on vérifie juste le rôle
        if ($historiqueConnexion === null) {
            return $user->role === 'super_admin';
        }

        // Règles spécifiques selon le rôle
        switch ($user->role) {
            case 'super_admin':
                // Super admin peut tout supprimer
                return true;

            case 'admin':
                // Admin peut supprimer ses propres historiques ou ceux de moins de 30 jours
                if ($user->id === $historiqueConnexion->user_id) {
                    return true;
                }

                // Ou les historiques récents (moins de 30 jours) pour maintenance
                return $historiqueConnexion->connecte_le->diffInDays(now()) <= 30;

            default:
                return false;
        }
    }

    /**
     * Déterminer si l'utilisateur peut restaurer un historique supprimé.
     */
    public function restore(User $user, ?HistoriqueConnexion $historiqueConnexion = null): bool
    {
        return $user->role === 'super_admin';
    }

    /**
     * Déterminer si l'utilisateur peut supprimer définitivement un historique.
     */
    public function forceDelete(User $user, ?HistoriqueConnexion $historiqueConnexion = null): bool
    {
        return $user->role === 'super_admin';
    }

    /**
     * Déterminer si l'utilisateur peut exporter les historiques.
     */
    public function export(User $user): bool
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Déterminer si l'utilisateur peut faire le nettoyage des historiques.
     */
    public function clean(User $user): bool
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Déterminer si l'utilisateur peut accéder au dashboard des historiques.
     */
    public function dashboard(User $user): bool
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Déterminer si l'utilisateur peut supprimer plusieurs historiques en masse.
     */
    public function deleteMultiple(User $user): bool
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Déterminer si l'utilisateur peut voir les statistiques avancées.
     */
    public function viewStats(User $user): bool
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Avant toute vérification, cette méthode est appelée.
     * Elle permet de court-circuiter les vérifications pour certains utilisateurs.
     */
    public function before(User $user, string $ability)
    {
        // Super admin a tous les droits
        if ($user->role === 'super_admin') {
            return true;
        }

        // Si l'utilisateur n'a pas le rôle minimum requis
        if (!in_array($user->role, ['user', 'admin', 'super_admin'])) {
            return false;
        }

        // Pour les autres cas, on laisse les méthodes spécifiques décider
        return null;
    }
}

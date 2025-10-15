<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

// Import des Models et Policies
use App\Models\User;
use App\Models\Role;
use App\Models\Notification;
use App\Models\Rapport;

use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\NotificationPolicy;
use App\Policies\RapportPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services de l’application.
     */
    public function register(): void
    {
        // Tu peux ajouter ici les bindings de services si besoin
    }

    /**
     * Démarre les services de l’application.
     */
    public function boot(): void
    {
        /**
         * Fix MySQL (erreur "La clé est trop longue")
         * Définit une longueur par défaut de 191 caractères
         */
        Schema::defaultStringLength(191);

        /**
         * Utiliser Bootstrap 5 pour la pagination
         */
        Paginator::useBootstrapFive();

        /**
         * Définition des policies (contrôle d’accès)
         */
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Notification::class, NotificationPolicy::class);
        Gate::policy(Rapport::class, RapportPolicy::class);
    }
}

<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Le chemin par défaut après connexion
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Définir les routes de l’application.
     */
    public function boot(): void
    {
        $this->routes(function () {
            // Routes web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // Routes API
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }
}

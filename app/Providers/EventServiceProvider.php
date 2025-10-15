<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Supprimé - on utilise seulement le contrôleur
    ];

    public function boot(): void
    {
        parent::boot();
    }
}

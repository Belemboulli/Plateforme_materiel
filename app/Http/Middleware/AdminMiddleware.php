<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Vérifie si l'utilisateur est connecté ET a le rôle admin
        if (Auth::check() && Auth::user()->role && Auth::user()->role->nom === 'admin') {
            return $next($request);
        }

        // Sinon redirige vers dashboard utilisateur ou page d'accueil
        return redirect()->route('user.dashboard')->with('error', 'Accès interdit !');
    }
}

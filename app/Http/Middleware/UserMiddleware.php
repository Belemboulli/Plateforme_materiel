<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->nom === 'user') {
            return $next($request);
        }

        // Sinon redirige vers admin dashboard ou page d'accueil
        return redirect()->route('admin.dashboard')->with('error', 'Accès interdit !');
    }
}

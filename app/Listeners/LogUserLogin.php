<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class LogUserLogin
{
    public function handle(Login $event): void
    {
        $user = $event->user;

        DB::table('historique_connexions')->insert([
            'user_id'    => $user->id,
            'ip_address' => request()->ip(),
            'navigateur' => request()->header('User-Agent') ?? 'N/A',
            'os'         => php_uname('s') . ' ' . php_uname('r'),
            'etat'       => 'succès',
            'connecte_le'=> now(),
        ]);
    }
}

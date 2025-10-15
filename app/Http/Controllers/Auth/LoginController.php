<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Constructeur : configure les middlewares correctement
     */
    public function __construct()
    {
        // Les visiteurs non connectés peuvent accéder au formulaire de login et au login
        $this->middleware('guest')->only(['showLoginForm', 'login']);

        // Seul un utilisateur connecté peut se déconnecter
        $this->middleware('auth')->only('logout');
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traite la soumission du formulaire de connexion
     */
    public function login(Request $request)
    {
        // Validation des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Rechercher l'utilisateur pour obtenir son ID même si la connexion échoue
        $user = DB::table('users')->where('email', $credentials['email'])->first();
        $userId = $user ? $user->id : 0; // 0 pour les tentatives avec email inexistant

        // Tentative de connexion
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate(); // Sécurité : régénère le token de session

            // ✅ SUPPRIMÉ : L'enregistrement de connexion réussie est géré par le Listener LogUserLogin
            // Le Listener Laravel s'occupe automatiquement des connexions réussies

            // Redirection directe vers le tableau de bord général
            return redirect()->route('dashboard');
        }

        // ✅ CONSERVÉ : Enregistrer seulement les tentatives échouées
        DB::table('historique_connexions')->insert([
            'user_id'     => $userId, // ID utilisateur ou 0 si email inexistant
            'ip_address'  => $request->ip(),
            'navigateur'  => $request->header('User-Agent') ?? 'N/A',
            'os'          => $this->getOperatingSystem($request),
            'etat'        => 'échec',
            'connecte_le' => now(),
        ]);

        // Si échec, retourne avec une erreur
        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->withInput($request->only('email'));
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        // ✅ CONSERVÉ : Enregistrer la déconnexion manuellement
        if (Auth::check()) {
            DB::table('historique_connexions')->insert([
                'user_id'     => Auth::id(),
                'ip_address'  => $request->ip(),
                'navigateur'  => $request->header('User-Agent') ?? 'N/A',
                'os'          => $this->getOperatingSystem($request),
                'etat'        => 'déconnexion',
                'connecte_le' => now(),
            ]);
        }

        Auth::logout();

        // Sécurité : invalider la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Vous avez été déconnecté.');
    }

    /**
     * Méthode utilitaire pour obtenir l'OS de manière plus précise
     */
    private function getOperatingSystem(Request $request)
    {
        $userAgent = $request->header('User-Agent', '');

        if (strpos($userAgent, 'Windows NT 10.0') !== false) {
            return 'Windows 10';
        } elseif (strpos($userAgent, 'Windows NT') !== false) {
            return 'Windows NT';
        } elseif (strpos($userAgent, 'Mac OS X') !== false) {
            return 'Mac OS X';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            return 'Linux';
        } else {
            return php_uname('s') . ' ' . php_uname('r');
        }
    }
}

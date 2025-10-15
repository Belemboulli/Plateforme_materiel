<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import des contrôleurs
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\LocalisationController;
use App\Http\Controllers\OctroiController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HistoriqueConnexionController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Page d'accueil dynamique
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentification (routes publiques)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Connexion
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Inscription
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Mot de passe oublié
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Tableaux de bord
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard général
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    Route::post('/dashboard/refresh', [DashboardController::class, 'refreshCache'])->name('dashboard.refresh');
    Route::get('/dashboard/export', [DashboardController::class, 'exportStats'])->name('dashboard.export');

    // Dashboard utilisateur
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
        Route::post('/dashboard/refresh', [DashboardController::class, 'refreshCache'])->name('dashboard.refresh');
        Route::get('/dashboard/export', [DashboardController::class, 'exportStats'])->name('dashboard.export');
    });

    // Dashboard admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
        Route::post('/dashboard/refresh', [DashboardController::class, 'refreshCache'])->name('dashboard.refresh');
        Route::get('/dashboard/export', [DashboardController::class, 'exportStats'])->name('dashboard.export');
    });
});

/*
|--------------------------------------------------------------------------
| Routes spéciales AVANT les resources (pour éviter les conflits)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // ===== AFFECTATIONS - Routes spéciales =====
    Route::get('/affectations/export/excel', [AffectationController::class, 'exportExcel'])->name('affectations.export.excel');
    Route::get('/affectations/export/pdf', [AffectationController::class, 'exportPdf'])->name('affectations.export.pdf');
    Route::post('/affectations/bulk-action', [AffectationController::class, 'bulkAction'])->name('affectations.bulk');

    // ===== ROLES - Routes spéciales =====
    Route::get('/roles/export', [RoleController::class, 'export'])->name('roles.export');
    Route::post('/roles/{role}/toggle-status', [RoleController::class, 'toggleStatus'])->name('roles.toggle-status');
    Route::post('/roles/{role}/duplicate', [RoleController::class, 'duplicate'])->name('roles.duplicate');

    // ===== RAPPORTS - Routes spéciales =====
    Route::get('/rapports/{rapport}/pdf', [RapportController::class, 'downloadPDF'])->name('rapports.pdf');
    Route::get('/rapports/export/excel', [RapportController::class, 'exportExcel'])->name('rapports.export.excel');
    Route::post('/rapports/generate', [RapportController::class, 'generateCustomReport'])->name('rapports.generate');

    // ===== NOTIFICATIONS - Routes spéciales =====
    Route::patch('/notifications/{notification}/toggle-read', [NotificationController::class, 'toggleRead'])->name('notifications.toggleRead');
});

/*
|--------------------------------------------------------------------------
| Routes CRUD - Modules principaux
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::resources([
        'materiels' => MaterielController::class,
        'categories' => CategorieController::class,
        'services' => ServiceController::class,
        'localisations' => LocalisationController::class,
        'structures' => StructureController::class,
        'octrois' => OctroiController::class,
        'inventaires' => InventaireController::class,
        'permissions' => PermissionController::class,
        'rapports' => RapportController::class,
        'roles' => RoleController::class,
        'notifications' => NotificationController::class,
        'historiques_connexion' => HistoriqueConnexionController::class,
        'affectations' => AffectationController::class,
    ]);
});

/*
|--------------------------------------------------------------------------
| Routes API
|--------------------------------------------------------------------------
*/
Route::prefix('api')->middleware(['auth'])->name('api.')->group(function () {
    // Statistiques générales
    Route::get('/octrois/count', function() {
        return response()->json(['count' => \App\Models\Octroi::count()]);
    })->name('octrois.count');

    Route::get('/notifications/unread', function() {
        return response()->json([
            'count' => \App\Models\Notification::where('is_read', false)->count()
        ]);
    })->name('notifications.unread');

    // Rapports
    Route::get('/rapports/stats', [RapportController::class, 'getStats'])->name('rapports.stats');
    Route::get('/rapports/data/{type}', [RapportController::class, 'getData'])->name('rapports.data');

    // Roles
    Route::get('/roles/stats', [RoleController::class, 'getStats'])->name('roles.stats');
    Route::get('/roles/{role}/permissions', [RoleController::class, 'getPermissions'])->name('roles.permissions');

    // Affectations
    Route::get('/affectations/stats', [AffectationController::class, 'getStats'])->name('affectations.stats');
});

/*
|--------------------------------------------------------------------------
| Redirections
|--------------------------------------------------------------------------
*/
Route::redirect('/home', '/dashboard')->name('home.redirect');
Route::redirect('/admin', '/admin/dashboard')->name('admin.redirect');

/*
|--------------------------------------------------------------------------
| Page 404 personnalisée
|--------------------------------------------------------------------------
*/
Route::fallback(function() {
    return response()->view('errors.404', [], 404);
});

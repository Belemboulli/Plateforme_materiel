<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

// Importation des modèles (peuvent ne pas exister, safeCount gère ça)
use App\Models\Materiel;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;
use App\Models\Octroi;
use App\Models\Inventaire;
use App\Models\Permission;
use App\Models\Rapport;
use App\Models\Role;
use App\Models\Notification;
use App\Models\HistoriqueConnexion;
use App\Models\Affectation; // ✅ ajouté

class DashboardController extends Controller
{
    /**
     * Dashboard général
     */
    public function index()
    {
        $dashboardData = Cache::remember('dashboard_data', 300, function () {
            return $this->getDashboardData();
        });

        return view('dashboard', $dashboardData);
    }

    /**
     * Dashboard utilisateur
     */
    public function userDashboard()
    {
        $dashboardData = Cache::remember('dashboard_user_data', 300, function () {
            return $this->getDashboardData();
        });

        return view('dashboard.user', $dashboardData);
    }

    /**
     * Dashboard admin
     */
    public function adminDashboard()
    {
        $dashboardData = Cache::remember('dashboard_admin_data', 300, function () {
            return $this->getDashboardData();
        });

        return view('dashboard.admin', $dashboardData);
    }

    /**
     * Statistiques JSON pour le dashboard
     */
    public function getStats()
    {
        $data = $this->getDashboardData();
        return response()->json($data);
    }

    /**
     * Rafraîchit le cache du dashboard
     */
    public function refreshCache()
    {
        Cache::forget('dashboard_data');
        Cache::forget('dashboard_user_data');
        Cache::forget('dashboard_admin_data');

        return response()->json([
            'message' => 'Cache du dashboard rafraîchi avec succès.'
        ]);
    }

    /**
     * Export des statistiques (CSV simple)
     */
    public function exportStats()
    {
        $data = $this->getDashboardData();

        $csvHeader = [
            'Total Materiels', 'Total Categories', 'Total Services', 'Total Users',
            'Total Octrois', 'Total Inventaires', 'Total Permissions',
            'Total Rapports', 'Total Roles', 'Total Notifications', 'Total Historiques',
            'Total Affectations' // ✅ ajouté
        ];

        $csvData = [
            [
                $data['totalMateriels'],
                $data['totalCategories'],
                $data['totalServices'],
                $data['totalUsers'],
                $data['totalOctrois'],
                $data['totalInventaires'],
                $data['totalPermissions'],
                $data['totalRapports'],
                $data['totalRoles'],
                $data['totalNotifications'],
                $data['totalHistoriques'],
                $data['totalAffectations'] // ✅ ajouté
            ]
        ];

        $filename = 'dashboard_stats_' . date('Y-m-d_H-i-s') . '.csv';

        $handle = fopen('php://memory', 'r+');
        fputcsv($handle, $csvHeader);
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);

        return Response::streamDownload(function () use ($handle) {
            fpassthru($handle);
        }, $filename);
    }

    /**
     * Récupération des données du dashboard (robuste)
     */
    private function getDashboardData()
    {
        try {
            // appel safe pour chaque compteur (évite les erreurs si table/manque de modèle)
            $totalMateriels     = $this->safeCount('materiels', Materiel::class);
            $totalCategories    = $this->safeCount('categories', Categorie::class);
            $totalServices      = $this->safeCount('services', Service::class);
            $totalUsers         = $this->safeCount('users', User::class);
            $totalOctrois       = $this->safeCount('octrois', Octroi::class);
            $totalInventaires   = $this->safeCount('inventaires', Inventaire::class);
            $totalPermissions   = $this->safeCount('permissions', Permission::class);
            $totalRapports      = $this->safeCount('rapports', Rapport::class);
            $totalRoles         = $this->safeCount('roles', Role::class);
            $totalNotifications = $this->safeCount('notifications', Notification::class);
            $totalHistoriques   = $this->safeCount('historique_connexions', HistoriqueConnexion::class);
            $totalAffectations  = $this->safeCount('affectations', Affectation::class); // ✅ ajouté

            // récupérer catégories+counts une seule fois
            $materielsParCategorie = $this->getMaterielsParCategorie();

            return [
                'totalMateriels'     => $totalMateriels,
                'totalCategories'    => $totalCategories,
                'totalServices'      => $totalServices,
                'totalUsers'         => $totalUsers,
                'totalOctrois'       => $totalOctrois,
                'totalInventaires'   => $totalInventaires,
                'totalPermissions'   => $totalPermissions,
                'totalRapports'      => $totalRapports,
                'totalRoles'         => $totalRoles,
                'totalNotifications' => $totalNotifications,
                'totalHistoriques'   => $totalHistoriques,
                'totalAffectations'  => $totalAffectations, // ✅ ajouté
                'categoriesLabels'   => $materielsParCategorie['labels'],
                'materielsCounts'    => $materielsParCategorie['counts'],
            ];
        } catch (\Exception $e) {
            // log et retomber proprement sur des valeurs par défaut
            \Log::error('Erreur dashboard (getDashboardData): ' . $e->getMessage());
            return $this->getDefaultDashboardData();
        }
    }

    /**
     * Récupération des matériels par catégorie (pour graphique)
     * Méthode robuste : vérifie les tables/colonnes avant d'interroger.
     */
    private function getMaterielsParCategorie()
    {
        try {
            $schema = DB::getSchemaBuilder();

            if (!$schema->hasTable('materiels') || !$schema->hasTable('categories')) {
                return ['labels' => ['Aucune catégorie'], 'counts' => [0]];
            }

            // choisir le nom de colonne de relation s'il existe
            $relationCol = $schema->hasColumn('materiels', 'categorie_id') ? 'categorie_id' : 'category_id';

            $data = DB::table('materiels')
                ->join('categories', "materiels.$relationCol", '=', 'categories.id')
                ->select('categories.nom as category_name', DB::raw('count(*) as total'))
                ->groupBy('categories.id', 'categories.nom')
                ->orderByDesc('total')
                ->get();

            if ($data->isEmpty()) {
                return ['labels' => ['Aucune catégorie'], 'counts' => [0]];
            }

            return [
                'labels' => $data->pluck('category_name')->toArray(),
                'counts' => $data->pluck('total')->toArray(),
            ];
        } catch (\Throwable $e) {
            \Log::error('Erreur dashboard (getMaterielsParCategorie): ' . $e->getMessage());
            return ['labels' => ['Erreur'], 'counts' => [0]];
        }
    }

    /**
     * Compteur sûr : vérifie l'existence de la table, tente d'utiliser le modèle si disponible,
     * puis fallback sur DB::table(...)->count(). En cas d'erreur retourne 0.
     *
     * @param string $table      Nom de la table dans la base
     * @param string|null $modelClass Nom complet du modèle (ex: Materiel::class)
     * @return int
     */
    private function safeCount(string $table, ?string $modelClass = null): int
    {
        try {
            $schema = DB::getSchemaBuilder();
        } catch (\Throwable $e) {
            \Log::warning("safeCount: impossible d'obtenir SchemaBuilder pour table {$table}: " . $e->getMessage());
            return 0;
        }

        try {
            if (!$schema->hasTable($table)) {
                return 0;
            }

            // si le modèle existe, essayer d'utiliser le modèle (peut lancer exception si table manquante)
            if ($modelClass && class_exists($modelClass)) {
                try {
                    return $modelClass::count();
                } catch (\Throwable $e) {
                    // log et fallback sur DB
                    \Log::warning("safeCount: count via modèle {$modelClass} a échoué, fallback DB pour table {$table}: " . $e->getMessage());
                }
            }

            // fallback : interroger directement la table
            try {
                return (int) DB::table($table)->count();
            } catch (\Throwable $e) {
                \Log::error("safeCount: count via DB::table({$table}) a échoué: " . $e->getMessage());
                return 0;
            }
        } catch (\Throwable $e) {
            \Log::error("safeCount: erreur inattendue pour table {$table}: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Valeurs par défaut si la récupération échoue
     */
    private function getDefaultDashboardData()
    {
        return [
            'totalMateriels' => 0,
            'totalCategories' => 0,
            'totalServices' => 0,
            'totalUsers' => 0,
            'totalOctrois' => 0,
            'totalInventaires' => 0,
            'totalPermissions' => 0,
            'totalRapports' => 0,
            'totalRoles' => 0,
            'totalNotifications' => 0,
            'totalHistoriques' => 0,
            'totalAffectations' => 0, // ✅ ajouté
            'categoriesLabels' => ['Aucune donnée'],
            'materielsCounts' => [0],
        ];
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->timestamps();

            // Index pour optimiser les performances
            $table->index(['role_id', 'permission_id']);

            // Contrainte d'unicité pour éviter les doublons
            $table->unique(['role_id', 'permission_id']);
        });

        // Attribution des permissions par défaut SEULEMENT si les données existent
        try {
            $this->assignDefaultPermissions();
        } catch (\Exception $e) {
            // Si erreur, continuer sans assigner les permissions
            // Elles pourront être assignées manuellement plus tard
            \Log::info('Attribution automatique des permissions ignorée : ' . $e->getMessage());
        }
    }

    /**
     * Assigne les permissions par défaut de manière sécurisée
     */
    private function assignDefaultPermissions(): void
    {
        // Vérifier d'abord que les tables ont du contenu
        $rolesCount = DB::table('roles')->count();
        $permissionsCount = DB::table('permissions')->count();

        if ($rolesCount === 0 || $permissionsCount === 0) {
            return; // Pas de données à traiter
        }

        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        $managerRole = DB::table('roles')->where('name', 'manager')->first();
        $userRole = DB::table('roles')->where('name', 'user')->first();

        $allPermissions = DB::table('permissions')->pluck('id')->toArray();
        $viewPermissions = DB::table('permissions')->where('name', 'like', 'view_%')->pluck('id')->toArray();
        $materialPermissions = DB::table('permissions')->where('category', 'materials')->pluck('id')->toArray();

        // Attribution pour Admin
        if ($adminRole && !empty($allPermissions)) {
            foreach ($allPermissions as $permissionId) {
                // Vérifier si la relation existe déjà
                $exists = DB::table('role_permission')
                    ->where('role_id', $adminRole->id)
                    ->where('permission_id', $permissionId)
                    ->exists();

                if (!$exists) {
                    DB::table('role_permission')->insert([
                        'role_id' => $adminRole->id,
                        'permission_id' => $permissionId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Attribution pour Manager
        if ($managerRole) {
            $managerPermissions = array_unique(array_merge($viewPermissions, $materialPermissions));
            foreach ($managerPermissions as $permissionId) {
                $exists = DB::table('role_permission')
                    ->where('role_id', $managerRole->id)
                    ->where('permission_id', $permissionId)
                    ->exists();

                if (!$exists) {
                    DB::table('role_permission')->insert([
                        'role_id' => $managerRole->id,
                        'permission_id' => $permissionId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Attribution pour User
        if ($userRole && !empty($viewPermissions)) {
            foreach ($viewPermissions as $permissionId) {
                $exists = DB::table('role_permission')
                    ->where('role_id', $userRole->id)
                    ->where('permission_id', $permissionId)
                    ->exists();

                if (!$exists) {
                    DB::table('role_permission')->insert([
                        'role_id' => $userRole->id,
                        'permission_id' => $permissionId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};

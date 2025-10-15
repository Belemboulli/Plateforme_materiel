<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Définition des rôles par défaut
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrateur',
                'priority_level' => 1,
            ],
            [
                'name' => 'manager',
                'description' => 'Gestionnaire',
                'priority_level' => 2,
            ],
            [
                'name' => 'user',
                'description' => 'Utilisateur standard',
                'priority_level' => 3,
            ],
        ];

        // Création ou mise à jour des rôles pour éviter les doublons
        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['name' => $roleData['name']], // condition d’unicité
                $roleData
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // -------------------------------
        // 1️⃣ Créer les rôles par défaut
        // -------------------------------
        $roles = [
            ['name' => 'admin', 'description' => 'Administrateur', 'priority_level' => 1],
            ['name' => 'manager', 'description' => 'Gestionnaire', 'priority_level' => 2],
            ['name' => 'user', 'description' => 'Utilisateur standard', 'priority_level' => 3],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(['name' => $roleData['name']], $roleData);
        }

        // -------------------------------
        // 2️⃣ Créer un utilisateur Admin
        // -------------------------------
        $adminRole = Role::where('name', 'admin')->first();

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role_id' => $adminRole?->id,
                'is_active' => true,
            ]
        );

        // -------------------------------
        // 3️⃣ Créer un utilisateur standard
        // -------------------------------
        $userRole = Role::where('name', 'user')->first();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role_id' => $userRole?->id,
                'is_active' => true,
            ]
        );
    }
}

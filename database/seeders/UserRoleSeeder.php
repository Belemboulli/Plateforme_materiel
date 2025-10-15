<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Créer les rôles si inexistants
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrateur', 'priority_level' => 1]
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['description' => 'Utilisateur standard', 'priority_level' => 3]
        );

        // ✅ Créer l'utilisateur admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // condition d’unicité
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        // ✅ Créer 5 utilisateurs normaux
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "user{$i}@example.com"],
                [
                    'name' => "User {$i}",
                    'password' => Hash::make('user123'),
                    'role_id' => $userRole->id,
                    'is_active' => true,
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'Maintenance Informatique',
                'code_service' => 'MAINIT',
                'description' => 'Service de maintenance et réparation du matériel informatique',
                'quantite' => 15,
                'statut' => 'actif',
                'priorite' => 'haute',
                'responsable' => 'Jean Dupont',
                'email_contact' => 'maintenance@entreprise.com',
                'telephone' => '+226 70 12 34 56',
                'localisation' => 'Bâtiment A, 2ème étage'
            ],
            [
                'name' => 'Support Technique',
                'code_service' => 'SUPTECH',
                'description' => 'Assistance technique pour les utilisateurs',
                'quantite' => 8,
                'statut' => 'actif',
                'priorite' => 'moyenne',
                'responsable' => 'Marie Martin',
                'email_contact' => 'support@entreprise.com',
                'telephone' => '+226 70 98 76 54',
                'localisation' => 'Bâtiment B, RDC'
            ],
            [
                'name' => 'Formation Utilisateurs',
                'code_service' => 'FORMUT',
                'description' => 'Formation et accompagnement des utilisateurs',
                'quantite' => 3,
                'statut' => 'maintenance',
                'priorite' => 'basse',
                'responsable' => 'Paul Ouédraogo',
                'email_contact' => 'formation@entreprise.com',
                'telephone' => '+226 70 11 22 33',
                'localisation' => 'Salle de formation'
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

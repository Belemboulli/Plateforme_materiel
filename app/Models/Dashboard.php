<?php

namespace App\Models;

use App\Models\Materiel;
use App\Models\Categorie;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dashboard
 *
 * Ce modèle centralise les statistiques pour le tableau de bord.
 * Il ne correspond pas forcément à une table dans la base de données,
 * mais sert à organiser et récupérer les données nécessaires à l'affichage.
 */
class Dashboard extends Model
{
    // Pas de table associée car ce modèle est "virtuel"
    public $table = null;

    /**
     * Récupère le nombre total de matériels.
     *
     * @return int
     */
    public static function totalMateriels(): int
    {
        return Materiel::count();
    }

    /**
     * Récupère le nombre total de catégories.
     *
     * @return int
     */
    public static function totalCategories(): int
    {
        return Categorie::count();
    }

    /**
     * Récupère le nombre total de services.
     *
     * @return int
     */
    public static function totalServices(): int
    {
        return Service::count();
    }

    /**
     * Récupère toutes les statistiques principales pour le dashboard.
     *
     * @return array
     */
    public static function stats(): array
    {
        return [
            'materiels'  => self::totalMateriels(),
            'categories' => self::totalCategories(),
            'services'   => self::totalServices(),
        ];
    }
}

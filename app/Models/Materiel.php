<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    use HasFactory;

    protected $table = 'materiels'; // nom de la table

    protected $fillable = [
        'nom',
        'description',
        'quantite',
        'categorie_id',
        'etat',
    ];

    /**
     * Relation : un matériel appartient à une catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // Relation mouvements supprimée car le module a été retiré
}

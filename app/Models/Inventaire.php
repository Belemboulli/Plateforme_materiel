<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    use HasFactory;

    protected $fillable = [
    'materiel_id',
    'quantite_disponible',
    'quantite_utilisee',
    'quantite_defaillante',
    'quantite_perdue',
    'date_inventaire',
    'observations'
];

    /**
     * Relation : un inventaire appartient à un matériel.
     */
    public function materiel()
    {
        return $this->belongsTo(Materiel::class);
    }
}

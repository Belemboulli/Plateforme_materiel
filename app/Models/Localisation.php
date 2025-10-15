<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    use HasFactory;

    protected $table = 'localisations';

    protected $fillable = [
        'nom',
        'code',
        'batiment',
        'etage',
        'description',
    ];

    /**
     * Exemple de relation : une localisation peut contenir plusieurs matériels
     */
    public function materiels()
    {
        return $this->hasMany(Materiel::class);
    }
}

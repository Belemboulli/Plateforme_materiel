<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Octroi extends Model
{
    use HasFactory;

    protected $fillable = [
        'materiel_id',
        'structure_id',
        'quantite',
    ];

    // Relation avec Materiel
    public function materiel()
    {
        return $this->belongsTo(Materiel::class);
    }

    // Relation avec structure
    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }
}

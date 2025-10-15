<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'date_rapport',
        'auteur_id',
    ];

     protected $casts = [
        'date_rapport' => 'datetime',
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }
}

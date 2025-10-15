<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueConnexion extends Model
{
    protected $table = 'historique_connexions';

    protected $casts = [
        'connecte_le' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'ip_address',
        'navigateur',
        'os',
        'etat',
        'connecte_le',
    ];

    public $timestamps = false; // Si tu n'utilises pas created_at/updated_at

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

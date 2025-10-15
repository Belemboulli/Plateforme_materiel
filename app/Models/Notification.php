<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'is_read',
    ];

    // ✅ Accessor pour afficher une date formatée
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at
            ? $this->created_at->format('d/m/Y H:i')
            : 'Non défini';
    }
}

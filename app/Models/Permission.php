<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Si tu veux plus tard relier avec des rôles :
    // public function roles() {
    //     return $this->belongsToMany(Role::class);
    // }
}

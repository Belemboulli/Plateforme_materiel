<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * ✅ Relation avec Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * ✅ Relation avec Sessions
     */
    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id');
    }

    /**
     * ✅ Vérifie si l’utilisateur a un rôle spécifique
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * ✅ Vérifie si l’utilisateur est administrateur
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * ✅ Vérifie si l’utilisateur est gestionnaire
     */
    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }
}

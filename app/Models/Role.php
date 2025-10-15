<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'priority_level',
        'is_active',
        'color',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * ✅ Relation : un rôle peut avoir plusieurs utilisateurs
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    /**
     * ✅ NOUVELLE RELATION : un rôle peut avoir plusieurs permissions
     * Relation Many-to-Many avec la table pivot role_permission
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')
                    ->withTimestamps(); // Si votre table pivot a created_at/updated_at
    }

    /**
     * ✅ Vérifie si le rôle a une permission spécifique
     */
    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            return $this->permissions()->where('name', $permission)->exists();
        }

        if (is_object($permission)) {
            return $this->permissions()->where('id', $permission->id)->exists();
        }

        return false;
    }

    /**
     * ✅ Attribuer une permission au rôle
     */
    public function givePermission($permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }

        if ($permission && !$this->hasPermission($permission)) {
            $this->permissions()->attach($permission->id);
        }

        return $this;
    }

    /**
     * ✅ Retirer une permission du rôle
     */
    public function revokePermission($permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }

        if ($permission) {
            $this->permissions()->detach($permission->id);
        }

        return $this;
    }

    /**
     * ✅ Synchroniser les permissions du rôle
     */
    public function syncPermissions(array $permissions): self
    {
        $permissionIds = [];

        foreach ($permissions as $permission) {
            if (is_string($permission)) {
                $perm = Permission::where('name', $permission)->first();
                if ($perm) $permissionIds[] = $perm->id;
            } elseif (is_numeric($permission)) {
                $permissionIds[] = $permission;
            } elseif (is_object($permission) && isset($permission->id)) {
                $permissionIds[] = $permission->id;
            }
        }

        $this->permissions()->sync($permissionIds);
        return $this;
    }

    /**
     * ✅ Vérifie si le rôle est Admin
     */
    public function isAdmin(): bool
    {
        return strtolower($this->name) === 'admin' || strtolower($this->name) === 'administrateur';
    }

    /**
     * ✅ Vérifie si le rôle est Manager
     */
    public function isManager(): bool
    {
        return strtolower($this->name) === 'manager' || strtolower($this->name) === 'gestionnaire';
    }

    /**
     * ✅ Vérifie si le rôle est User
     */
    public function isUser(): bool
    {
        return strtolower($this->name) === 'user' || strtolower($this->name) === 'utilisateur';
    }

    /**
     * ✅ Vérifie si le rôle est actif
     */
    public function isActive(): bool
    {
        return $this->is_active ?? true;
    }

    /**
     * ✅ Scope pour les rôles actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * ✅ Scope pour trier par priorité
     */
    public function scopeByPriority($query)
    {
        return $query->orderBy('priority_level', 'asc')->orderBy('name', 'asc');
    }

    /**
     * ✅ CORRIGÉ : Accesseur pour la couleur par défaut UTS
     */
    public function getColorAttribute($value)
    {
        return $value ?: '#2E7D32'; // ✅ Vert UTS au lieu de bleu
    }

    /**
     * ✅ Accesseur pour le badge HTML du rôle
     */
    public function getBadgeHtmlAttribute(): string
    {
        $status = $this->isActive() ? 'active' : 'inactive';
        $color = $this->color;

        return '<span class="badge" style="background-color: ' . $color . '">' .
               $this->name .
               '</span>';
    }
}

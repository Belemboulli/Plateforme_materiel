<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code_service',
        'description',
        'quantite',
        'statut',
        'priorite',
        'responsable',
        'email_contact',
        'telephone',
        'localisation',
    ];

    protected $casts = [
        'quantite' => 'integer',
        'statut' => 'string',
        'priorite' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Valeurs par défaut
    protected $attributes = [
        'statut' => 'actif',
        'priorite' => 'moyenne',
        'quantite' => 1,
    ];

    // Accesseurs pour les badges HTML
    public function getStatutBadgeAttribute()
    {
        return match($this->statut) {
            'actif' => '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Actif</span>',
            'inactif' => '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Inactif</span>',
            'maintenance' => '<span class="badge bg-warning text-dark"><i class="bi bi-tools me-1"></i>Maintenance</span>',
            default => '<span class="badge bg-secondary"><i class="bi bi-question-circle me-1"></i>Inconnu</span>'
        };
    }

    public function getPrioriteBadgeAttribute()
    {
        return match($this->priorite) {
            'haute' => '<span class="badge bg-danger"><i class="bi bi-flag-fill me-1"></i>Haute</span>',
            'moyenne' => '<span class="badge bg-warning text-dark"><i class="bi bi-flag me-1"></i>Moyenne</span>',
            'basse' => '<span class="badge bg-success"><i class="bi bi-flag me-1"></i>Basse</span>',
            default => '<span class="badge bg-secondary"><i class="bi bi-question-circle me-1"></i>Non définie</span>'
        };
    }

    // Accesseur pour le badge de quantité
    public function getQuantiteBadgeAttribute()
    {
        if ($this->quantite > 10) {
            return '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>' . $this->quantite . '</span>';
        } elseif ($this->quantite > 5) {
            return '<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>' . $this->quantite . '</span>';
        } else {
            return '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>' . $this->quantite . '</span>';
        }
    }

    // Accesseur pour le code service formaté
    public function getCodeServiceFormatteAttribute()
    {
        return $this->code_service ? strtoupper($this->code_service) : 'N/A';
    }

    // Accesseur pour l'état du stock
    public function getStockStatusAttribute()
    {
        if ($this->quantite > 10) {
            return 'high';
        } elseif ($this->quantite > 5) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    // Scopes pour les requêtes
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeInactifs($query)
    {
        return $query->where('statut', 'inactif');
    }

    public function scopeEnMaintenance($query)
    {
        return $query->where('statut', 'maintenance');
    }

    public function scopeParPriorite($query, $priorite)
    {
        return $query->where('priorite', $priorite);
    }

    public function scopePrioriteHaute($query)
    {
        return $query->where('priorite', 'haute');
    }

    public function scopeStockFaible($query)
    {
        return $query->where('quantite', '<=', 5);
    }

    public function scopeStockEleve($query)
    {
        return $query->where('quantite', '>', 10);
    }

    public function scopeAvecResponsable($query)
    {
        return $query->whereNotNull('responsable');
    }

    public function scopeAvecContact($query)
    {
        return $query->where(function ($query) {
            $query->whereNotNull('email_contact')
                  ->orWhereNotNull('telephone');
        });
    }

    // Mutateurs
    public function setCodeServiceAttribute($value)
    {
        $this->attributes['code_service'] = $value ? strtoupper(trim($value)) : null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setEmailContactAttribute($value)
    {
        $this->attributes['email_contact'] = $value ? strtolower(trim($value)) : null;
    }

    public function setTelephoneAttribute($value)
    {
        // Nettoyer le numéro de téléphone
        $this->attributes['telephone'] = $value ? preg_replace('/[^\d\+\-\(\)\s]/', '', $value) : null;
    }

    // Méthodes utilitaires
    public function estActif()
    {
        return $this->statut === 'actif';
    }

    public function estInactif()
    {
        return $this->statut === 'inactif';
    }

    public function estEnMaintenance()
    {
        return $this->statut === 'maintenance';
    }

    public function aPrioriteHaute()
    {
        return $this->priorite === 'haute';
    }

    public function aStockFaible()
    {
        return $this->quantite <= 5;
    }

    public function aResponsable()
    {
        return !empty($this->responsable);
    }

    public function aContact()
    {
        return !empty($this->email_contact) || !empty($this->telephone);
    }

    // Méthode pour générer un code service automatique
    public function genererCodeService()
    {
        if (empty($this->code_service)) {
            $code = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $this->name), 0, 6));
            $compteur = 1;
            $codeOriginal = $code;

            while (self::where('code_service', $code)->where('id', '!=', $this->id)->exists()) {
                $code = $codeOriginal . $compteur;
                $compteur++;
            }

            $this->code_service = $code;
        }
    }

    // Boot method pour les événements
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            // Générer automatiquement le code service si non fourni
            if (empty($service->code_service)) {
                $service->genererCodeService();
            }
        });

        static::updating(function ($service) {
            // Régénérer le code service si le nom change et pas de code personnalisé
            if ($service->isDirty('name') && empty($service->getOriginal('code_service'))) {
                $service->genererCodeService();
            }
        });
    }
}

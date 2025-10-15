<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Affectation extends Model
{
    use HasFactory;

    protected $fillable = [
        'materiel_id',
        'user_id',
        'service_id',
        'numero_affectation',
        'date_affectation',
        'date_retour_prevue',
        'date_retour',
        'statut',
        'priorite',
        'lieu_utilisation',
        'responsable_validation',
        'commentaire',
        'notification_envoyee',
        'metadata',
    ];

    protected $casts = [
        'date_affectation' => 'date',
        'date_retour_prevue' => 'date',
        'date_retour' => 'date',
        'notification_envoyee' => 'boolean',
        'metadata' => 'array',
    ];

    protected $dates = [
        'date_affectation',
        'date_retour_prevue',
        'date_retour',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'statut_badge',
        'duree',
        'est_en_retard',
    ];

    // =============================================
    // RELATIONS
    // =============================================

    /**
     * Relation avec le matériel
     */
    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id');
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation avec le service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // =============================================
    // SCOPES (Filtres de requête)
    // =============================================

    /**
     * Affectations en cours
     */
    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en cours');
    }

    /**
     * Affectations terminées
     */
    public function scopeTerminees($query)
    {
        return $query->where('statut', 'terminé');
    }

    /**
     * Affectations en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en attente');
    }

    /**
     * Affectations annulées
     */
    public function scopeAnnulees($query)
    {
        return $query->where('statut', 'annulé');
    }

    /**
     * Affectations urgentes
     */
    public function scopeUrgentes($query)
    {
        return $query->where('priorite', 'urgente');
    }

    /**
     * Affectations en retard
     */
    public function scopeRetardees($query)
    {
        return $query->where('date_retour_prevue', '<', now())
                    ->whereNull('date_retour')
                    ->where('statut', 'en cours');
    }

    /**
     * Affectations pour un utilisateur spécifique
     */
    public function scopeParUtilisateur($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Affectations pour un service spécifique
     */
    public function scopeParService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    /**
     * Affectations récentes (dans les 30 derniers jours)
     */
    public function scopeRecentes($query)
    {
        return $query->where('date_affectation', '>=', now()->subDays(30));
    }

    // =============================================
    // ACCESSEURS (Getters)
    // =============================================

    /**
     * Badge de couleur selon le statut
     */
    public function getStatutBadgeAttribute()
    {
        $badges = [
            'en cours' => 'success',
            'en attente' => 'warning',
            'terminé' => 'primary',
            'annulé' => 'danger',
        ];
        return $badges[$this->statut] ?? 'secondary';
    }

    /**
     * Durée de l'affectation en jours
     */
    public function getDureeAttribute()
    {
        if (!$this->date_affectation) {
            return 0;
        }

        if ($this->date_retour) {
            return Carbon::parse($this->date_affectation)->diffInDays(Carbon::parse($this->date_retour));
        }

        return Carbon::parse($this->date_affectation)->diffInDays(now());
    }

    /**
     * Vérifie si l'affectation est en retard
     */
    public function getEstEnRetardAttribute()
    {
        if (!$this->date_retour_prevue) {
            return false;
        }

        return Carbon::parse($this->date_retour_prevue)->isPast()
               && !$this->date_retour
               && $this->statut === 'en cours';
    }

    /**
     * Nombre de jours de retard
     */
    public function getJoursRetardAttribute()
    {
        if (!$this->est_en_retard) {
            return 0;
        }

        return Carbon::parse($this->date_retour_prevue)->diffInDays(now());
    }

    /**
     * Date d'affectation formatée
     */
    public function getDateAffectationFormatteeAttribute()
    {
        return $this->date_affectation
            ? Carbon::parse($this->date_affectation)->format('d/m/Y')
            : '-';
    }

    /**
     * Date de retour prévue formatée
     */
    public function getDateRetourPrevueFormatteeAttribute()
    {
        return $this->date_retour_prevue
            ? Carbon::parse($this->date_retour_prevue)->format('d/m/Y')
            : '-';
    }

    /**
     * Date de retour formatée
     */
    public function getDateRetourFormatteeAttribute()
    {
        return $this->date_retour
            ? Carbon::parse($this->date_retour)->format('d/m/Y')
            : '-';
    }

    /**
     * Icône selon la priorité
     */
    public function getPrioriteIconeAttribute()
    {
        $icones = [
            'faible' => 'arrow-down',
            'normale' => 'minus',
            'urgente' => 'exclamation-triangle',
        ];
        return $icones[$this->priorite] ?? 'question';
    }

    /**
     * Couleur selon la priorité
     */
    public function getPrioriteCouleurAttribute()
    {
        $couleurs = [
            'faible' => 'info',
            'normale' => 'secondary',
            'urgente' => 'danger',
        ];
        return $couleurs[$this->priorite] ?? 'secondary';
    }

    // =============================================
    // MUTATEURS (Setters)
    // =============================================

    /**
     * Génère automatiquement un numéro d'affectation
     */
    public function setNumeroAffectationAttribute($value)
    {
        $this->attributes['numero_affectation'] = $value ?: $this->generateNumeroAffectation();
    }

    // =============================================
    // MÉTHODES MÉTIER
    // =============================================

    /**
     * Génère un numéro d'affectation unique
     */
    public function generateNumeroAffectation()
    {
        $year = date('Y');
        $lastNumber = self::where('numero_affectation', 'like', "AFF-{$year}-%")
                         ->max('numero_affectation');

        if ($lastNumber) {
            $number = (int) substr($lastNumber, -4) + 1;
        } else {
            $number = 1;
        }

        return "AFF-{$year}-" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Termine l'affectation
     */
    public function terminer($dateRetour = null)
    {
        $this->update([
            'statut' => 'terminé',
            'date_retour' => $dateRetour ?: now()->toDateString(),
        ]);

        // Libérer le matériel
        if ($this->materiel) {
            $this->materiel->update(['statut' => 'disponible']);
        }

        return $this;
    }

    /**
     * Annule l'affectation
     */
    public function annuler($commentaire = null)
    {
        $commentaireComplet = $this->commentaire;

        if ($commentaire) {
            $commentaireComplet .= "\n[Annulation le " . now()->format('d/m/Y H:i') . "] " . $commentaire;
        }

        $this->update([
            'statut' => 'annulé',
            'commentaire' => $commentaireComplet,
        ]);

        // Libérer le matériel
        if ($this->materiel) {
            $this->materiel->update(['statut' => 'disponible']);
        }

        return $this;
    }

    /**
     * Prolonge la date de retour prévue
     */
    public function prolonger($nouvelleDateRetour, $raison = null)
    {
        $commentaireComplet = $this->commentaire;

        if ($raison) {
            $commentaireComplet .= "\n[Prolongation le " . now()->format('d/m/Y H:i') . "] " . $raison;
        }

        $this->update([
            'date_retour_prevue' => $nouvelleDateRetour,
            'commentaire' => $commentaireComplet,
        ]);

        return $this;
    }

    /**
     * Vérifie si l'affectation peut être modifiée
     */
    public function peutEtreModifiee()
    {
        return in_array($this->statut, ['en cours', 'en attente']);
    }

    /**
     * Vérifie si l'affectation peut être supprimée
     */
    public function peutEtreSupprimee()
    {
        return in_array($this->statut, ['en attente', 'annulé']);
    }

    // =============================================
    // ÉVÉNEMENTS DU MODÈLE
    // =============================================

    protected static function boot()
    {
        parent::boot();

        // Avant création
        static::creating(function ($affectation) {
            // Générer un numéro si absent
            if (empty($affectation->numero_affectation)) {
                $affectation->numero_affectation = $affectation->generateNumeroAffectation();
            }

            // Valeurs par défaut
            $affectation->statut = $affectation->statut ?? 'en cours';
            $affectation->priorite = $affectation->priorite ?? 'normale';
        });

        // Après création
        static::created(function ($affectation) {
            // Mettre à jour le statut du matériel
            if ($affectation->materiel && $affectation->statut === 'en cours') {
                $affectation->materiel->update(['statut' => 'affecté']);
            }
        });

        // Avant suppression
        static::deleting(function ($affectation) {
            // Libérer le matériel
            if ($affectation->materiel) {
                $affectation->materiel->update(['statut' => 'disponible']);
            }
        });
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'parent_id',
        'is_super_admin',
        'abonnement_type',
        'date_debut_abonnement',
        'date_fin_abonnement',
        'statut_abonnement',
    ];

    /**
     * Relation avec le parent (admin qui a créé cet utilisateur)
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Utilisateurs créés par cet admin
     */
    public function enfants()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * Paiements d'abonnements
     */
    public function paiementsAbonnements()
    {
        return $this->hasMany(\App\Models\PaiementAbonnement::class);
    }

    /**
     * Configuration de l'utilisateur
     */
    public function configuration()
    {
        return $this->hasOne(Configuration::class);
    }

    /**
     * Vérifie si l'utilisateur est admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est vendeur
     */
    public function isVendeur(): bool
    {
        return $this->role === 'vendeur';
    }

    /**
     * Vérifie si l'utilisateur est gestionnaire
     */
    public function isGestionnaire(): bool
    {
        return $this->role === 'gestionnaire';
    }

    /**
     * Retourne l'ID du propriétaire des données
     * - Si l'utilisateur est admin (sans parent), retourne son propre ID
     * - Si l'utilisateur a un parent (vendeur/gestionnaire), retourne l'ID du parent
     */
   public function getOwnerId()
{
    return $this->owner_id ?? $this->id;
}


    /**
     * Vérifie si l'utilisateur peut accéder à une section
     */
    public function canAccess(string $section): bool
    {
        $permissions = [
            'admin' => ['ventes', 'produits', 'achats', 'comptabilite', 'rapports', 'fournisseurs', 'clients', 'parametres'],
            'gestionnaire' => ['ventes', 'produits', 'achats', 'clients', 'rapports'],
            'vendeur' => ['ventes', 'clients'],
        ];

        return in_array($section, $permissions[$this->role] ?? []);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
            'date_debut_abonnement' => 'date',
            'date_fin_abonnement' => 'date',
        ];
    }

    /**
     * Vérifie si l'utilisateur est super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true;
    }

    /**
     * Vérifie si l'abonnement est actif
     * Vérifie aussi le statut du parent admin si l'utilisateur a un parent
     */
    public function isAbonnementActif(): bool
    {
        if ($this->is_super_admin) {
            return true; // Le super admin est toujours actif
        }

        // Si l'utilisateur a un parent (vendeur/gestionnaire créé par un admin)
        if ($this->parent_id) {
            // Charger le parent si pas déjà chargé
            if (!$this->relationLoaded('parent')) {
                $this->load('parent');
            }
            
            $parent = $this->parent;
            if ($parent) {
                // Vérifier directement le statut du parent sans récursion
                if ($parent->statut_abonnement === 'suspendu' || $parent->statut_abonnement === 'expire') {
                    return false; // Le parent est suspendu/expiré
                }
                if ($parent->date_fin_abonnement && \Carbon\Carbon::parse($parent->date_fin_abonnement)->isPast()) {
                    return false; // Le parent a un abonnement expiré
                }
                if ($parent->statut_abonnement !== 'actif') {
                    return false;
                }
            }
        }

        // Vérifier le statut de l'utilisateur lui-même
        if ($this->statut_abonnement === 'suspendu') {
            return false;
        }

        if ($this->statut_abonnement === 'expire') {
            return false;
        }

        if ($this->date_fin_abonnement && \Carbon\Carbon::parse($this->date_fin_abonnement)->isPast()) {
            $this->update(['statut_abonnement' => 'expire']);
            return false;
        }

        return $this->statut_abonnement === 'actif';
    }

    /**
     * Obtenir le parent admin (pour les vendeurs/gestionnaires)
     */
    public function getParentAdmin()
    {
        if ($this->is_super_admin || !$this->parent_id) {
            return $this;
        }
        
        $parent = $this->parent;
        while ($parent && $parent->parent_id && !$parent->is_super_admin) {
            $parent = $parent->parent;
        }
        
        return $parent;
    }

    /**
     * Calcule la date de fin d'abonnement selon le type
     */
    public function calculerDateFinAbonnement(string $type): \Carbon\Carbon
    {
        $dateDebut = now();
        
        switch ($type) {
            case 'mensuel':
                return $dateDebut->copy()->addMonth();
            case 'trimestriel':
                return $dateDebut->copy()->addMonths(3);
            case 'annuel':
                return $dateDebut->copy()->addYear();
            default:
                return $dateDebut;
        }
    }
}

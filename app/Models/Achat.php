<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    protected $fillable = [
        'user_id',
        'fournisseur_id',
        'date_achat',
        'numero_facture',
        'total',
        'montant_paye',
        'statut',
        'statut_paiement',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'date_achat' => 'datetime',
        'total' => 'decimal:2',
        'montant_paye' => 'decimal:2',
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function details()
    {
        return $this->hasMany(AchatDetail::class);
    }

    public function paiements()
    {
        return $this->hasMany(PaiementAchat::class);
    }

    /**
     * Calculer le reste à payer
     */
    public function getResteAPayerAttribute()
    {
        return $this->total - $this->montant_paye;
    }

    /**
     * Mettre à jour le statut de paiement
     */
    public function updateStatutPaiement()
    {
        $totalPaye = $this->paiements()->sum('montant_paye');
        $this->montant_paye = $totalPaye;

        if ($totalPaye >= $this->total) {
            $this->statut_paiement = 'paye';
        } elseif ($totalPaye > 0) {
            $this->statut_paiement = 'partiel';
        } else {
            $this->statut_paiement = 'non_paye';
        }

        $this->save();
    }
}

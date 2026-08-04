<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaiementAbonnement extends Model
{
    protected $fillable = [
        'user_id',
        'montant',
        'date_paiement',
        'mode',
        'abonnement_type',
        'date_debut',
        'date_fin',
        'note',
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'montant' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

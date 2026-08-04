<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaiementAchat extends Model
{
    protected $fillable = [
        'achat_id',
        'caisse_id',
        'montant_paye',
        'date_paiement',
        'mode',
        'note',
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant_paye' => 'decimal:2',
    ];

    public function achat()
    {
        return $this->belongsTo(Achat::class);
    }

    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }
}

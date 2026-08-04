<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchatDetail extends Model
{
    protected $table = 'achat_details';

    protected $fillable = [
        'achat_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'date_peremption', // IMPORTANT : ajouté pour le suivi du stock
    ];

    protected $casts = [
        'quantite'      => 'integer',
        'prix_unitaire' => 'decimal:2',
        'date_peremption' => 'date', // Pour être sûr que c’est traité comme date
    ];

    /**
     * L’achat auquel ce détail appartient
     */
    public function achat()
    {
        return $this->belongsTo(Achat::class);
    }

    /**
     * Le produit associé à ce détail
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    protected $fillable = [
        'produit_id',
        'type_mouvement',
        'quantite',
        'date_mouvement',
        'raison',
    ];

    protected $casts = [
        'date_mouvement' => 'datetime',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}

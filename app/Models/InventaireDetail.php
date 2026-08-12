<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventaireDetail extends Model
{
    protected $fillable = [
        'inventaire_id',
        'produit_id',
        'stock_theorique',
        'stock_compte',
        'ecart',
        'prix_unitaire',
        'valeur_ecart',
        'type_ecart',
    ];

    protected $casts = [
        'stock_theorique' => 'decimal:2',
        'stock_compte' => 'decimal:2',
        'ecart' => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
        'valeur_ecart' => 'decimal:2',
    ];

    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
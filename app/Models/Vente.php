<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    protected $fillable = [
        'user_id',
        'date_vente',
        'client_id',
        'montant_total',
        'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'date_vente' => 'datetime',
        'montant_total' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function details()
    {
       return $this->hasMany(DetailVente::class, 'vente_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'solde',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recettes()
    {
        return $this->hasMany(Recette::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function crediter($montant)
    {
        $this->solde += $montant;
        $this->save();
    }

    public function debiter($montant)
    {
        $this->solde -= $montant;
        $this->save();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $fillable = [
        'libelle',
        'montant',
        'date_recette',
        'caisse_id',
        'user_id',
    ];

    protected $casts = [
        'date_vente' => 'datetime',
    ];

    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

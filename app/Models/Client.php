<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'nom_client',
        'adresse_client',
        'contact_client',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }
}

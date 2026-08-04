<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $fillable = [
        'user_id',
        'nom_fournisseur',
        'email',
        'contact_fournisseur',
        'adresse_fournisseur',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

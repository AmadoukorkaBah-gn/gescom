<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    /**
     * Fillable attributes
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nom_categorie',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the produits for the categorie.
     */
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}

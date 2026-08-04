<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retour extends Model
{
    // Champs remplissables
    protected $fillable = [
        'vente_id',
        'produit_id',
        'quantite',
        'date_retour',
        'raison'
    ];


    // Relations
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }
}

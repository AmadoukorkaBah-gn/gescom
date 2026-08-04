<?php
 namespace App\Models;
 use Illuminate\Database\Eloquent\Model;
class Stock extends Model
{
    protected $fillable = [
        'produit_id',
        'quantite',
        'date_peremption',
        'date_entree'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}

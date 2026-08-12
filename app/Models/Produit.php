<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'user_id',
        'nom_produit',
        'prix_vente',
        'prix_produit',
        'statut',
        'stock_minimum',
        'categorie_id',
        'fournisseur_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relations
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function mouvements()
{
    return $this->hasMany(MouvementStock::class);
}


    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    // Stock réel actuel
    public function stockActuel()
    {
        return $this->stocks()
                    ->where('quantite', '>', 0)
                    ->where(function($q) {
                        $q->whereNull('date_peremption')
                          ->orWhere('date_peremption', '>=', now());
                    })
                    ->sum('quantite');
    }

    // Ajouter du stock
public function incrementStock($quantite, $raison = null, $datePeremption = null)
{
    $this->stocks()->create([
        'quantite' => $quantite,
        'date_entree' => now(),
        'date_peremption' => $datePeremption,
    ]);

    MouvementStock::create([
        'produit_id' => $this->id,
        'type_mouvement' => 'entree',
        'quantite' => $quantite,
        'date_mouvement' => now(),
        'raison' => $raison,
    ]);
}

    // Retirer du stock
    public function decrementStock($quantite, $raison = null)
    {
        $stocks = $this->stocks()->where('quantite', '>', 0)->orderBy('date_entree')->get();
        $reste = $quantite;

        foreach ($stocks as $stock) {
            if ($reste <= 0) break;

            if ($stock->quantite >= $reste) {
                $stock->quantite -= $reste;
                $stock->save();
                $reste = 0;
            } else {
                $reste -= $stock->quantite;
                $stock->quantite = 0;
                $stock->save();
            }
        }

        MouvementStock::create([
            'produit_id' => $this->id,
            'type_mouvement' => 'sortie',
            'quantite' => $quantite,
            'date_mouvement' => now(),
            'raison' => $raison,
        ]);
    }
}

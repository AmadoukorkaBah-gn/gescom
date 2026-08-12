<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Inventaire;
use App\Models\InventaireDetail;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventaireController extends Controller
{
    /**
     * Afficher l'inventaire en cours.
     */
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();

        $produits = Produit::with(['categorie', 'fournisseur'])
            ->where('user_id', $ownerId)
            ->orderBy('nom_produit')
            ->paginate(20);

        $categories = Categorie::where('user_id', $ownerId)
            ->orderBy('nom_categorie')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Chercher l'inventaire brouillon actuel
        |--------------------------------------------------------------------------
        */

        $inventaire = Inventaire::where('user_id', $ownerId)
            ->where('statut', 'brouillon')
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Si aucun inventaire n'existe, on en crée un
        |--------------------------------------------------------------------------
        */

        if (!$inventaire) {

            $inventaire = Inventaire::create([
                'user_id' => $ownerId,
                'reference' => 'INV-' . now()->format('YmdHis'),
                'date_inventaire' => now(),
                'statut' => 'brouillon',
                'total_gain' => 0,
                'total_perte' => 0,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Charger les détails existants
        |--------------------------------------------------------------------------
        */

        $details = InventaireDetail::where('inventaire_id', $inventaire->id)
            ->get()
            ->keyBy('produit_id');

        /*
        |--------------------------------------------------------------------------
        | Préparer les produits avec leur stock théorique
        |--------------------------------------------------------------------------
        */

        foreach ($produits as $produit) {

            $stockTheorique = $produit->stockActuel();

            $detail = $details->get($produit->id);

            if (!$detail) {

                $detail = InventaireDetail::create([
                    'inventaire_id' => $inventaire->id,
                    'produit_id' => $produit->id,
                    'stock_theorique' => $stockTheorique,
                    'stock_compte' => $stockTheorique,
                    'ecart' => 0,
                    'prix_unitaire' => $produit->prix_produit ?? 0,
                    'valeur_ecart' => 0,
                    'type_ecart' => 'aucun',
                ]);

                $details->put($produit->id, $detail);

            } else {

                /*
                |--------------------------------------------------------------------------
                | On met à jour le stock théorique uniquement.
                | Le stock compté reste celui saisi par l'utilisateur.
                |--------------------------------------------------------------------------
                */

                if (!$inventaire->estCloture()) {

                    $detail->update([
                        'stock_theorique' => $stockTheorique,
                        'prix_unitaire' => $produit->prix_produit ?? 0,
                    ]);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Recharger les détails
        |--------------------------------------------------------------------------
        */

        $details = InventaireDetail::with('produit')
            ->where('inventaire_id', $inventaire->id)
            ->get();

        return view(
            'inventaire.index',
            compact(
                'produits',
                'categories',
                'inventaire',
                'details'
            )
        );
    }


    /**
     * Enregistrer les quantités réellement comptées.
     */
    public function enregistrer(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();

        $request->validate([
            'quantites' => ['required', 'array'],
            'quantites.*' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($request, $ownerId) {

            /*
            |--------------------------------------------------------------------------
            | Récupérer l'inventaire brouillon
            |--------------------------------------------------------------------------
            */

            $inventaire = Inventaire::where('user_id', $ownerId)
                ->where('statut', 'brouillon')
                ->latest('id')
                ->first();

            if (!$inventaire) {

                $inventaire = Inventaire::create([
                    'user_id' => $ownerId,
                    'reference' => 'INV-' . now()->format('YmdHis'),
                    'date_inventaire' => now(),
                    'statut' => 'brouillon',
                    'total_gain' => 0,
                    'total_perte' => 0,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Enregistrer chaque produit
            |--------------------------------------------------------------------------
            */

            foreach ($request->quantites as $produitId => $quantiteReelle) {

                $produit = Produit::where('id', $produitId)
                    ->where('user_id', $ownerId)
                    ->first();

                if (!$produit) {
                    continue;
                }

                $stockTheorique = $produit->stockActuel();

                $quantiteReelle = (float) $quantiteReelle;

                /*
                | Écart :
                | réel - théorique
                |
                | positif = gain
                | négatif = perte
                */

                $ecart = $quantiteReelle - $stockTheorique;

                $prixUnitaire = (float) ($produit->prix_produit ?? 0);

                $valeurEcart = abs($ecart) * $prixUnitaire;

                if ($ecart > 0) {
                    $typeEcart = 'gain';
                } elseif ($ecart < 0) {
                    $typeEcart = 'perte';
                } else {
                    $typeEcart = 'aucun';
                }

                /*
                |--------------------------------------------------------------------------
                | Enregistrer dans inventaire_details
                |--------------------------------------------------------------------------
                */

                InventaireDetail::updateOrCreate(
                    [
                        'inventaire_id' => $inventaire->id,
                        'produit_id' => $produit->id,
                    ],
                    [
                        'stock_theorique' => $stockTheorique,
                        'stock_compte' => $quantiteReelle,
                        'ecart' => $ecart,
                        'prix_unitaire' => $prixUnitaire,
                        'valeur_ecart' => $valeurEcart,
                        'type_ecart' => $typeEcart,
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Calcul des totaux
            |--------------------------------------------------------------------------
            */

            $totalGain = InventaireDetail::where(
                'inventaire_id',
                $inventaire->id
            )
                ->where('type_ecart', 'gain')
                ->sum('valeur_ecart');

            $totalPerte = InventaireDetail::where(
                'inventaire_id',
                $inventaire->id
            )
                ->where('type_ecart', 'perte')
                ->sum('valeur_ecart');

            /*
            |--------------------------------------------------------------------------
            | Mise à jour de l'inventaire
            |--------------------------------------------------------------------------
            */

            $inventaire->update([
                'total_gain' => $totalGain,
                'total_perte' => $totalPerte,
            ]);
        });

        return redirect()
            ->route('inventaire.index')
            ->with('success', 'Inventaire enregistré avec succès.');
    }


    /**
     * Clôturer l'inventaire.
     */
    public function cloturer()
    {
        $ownerId = Auth::user()->getOwnerId();

        DB::transaction(function () use ($ownerId) {

            $inventaire = Inventaire::where('user_id', $ownerId)
                ->where('statut', 'brouillon')
                ->latest('id')
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Recalculer les totaux avant clôture
            |--------------------------------------------------------------------------
            */

            $totalGain = InventaireDetail::where(
                'inventaire_id',
                $inventaire->id
            )
                ->where('type_ecart', 'gain')
                ->sum('valeur_ecart');

            $totalPerte = InventaireDetail::where(
                'inventaire_id',
                $inventaire->id
            )
                ->where('type_ecart', 'perte')
                ->sum('valeur_ecart');

            /*
            |--------------------------------------------------------------------------
            | Résultat final
            |--------------------------------------------------------------------------
            */

            $inventaire->update([
                'statut' => 'cloture',
                'total_gain' => $totalGain,
                'total_perte' => $totalPerte,
                'date_cloture' => now(),
            ]);
        });

        return redirect()
            ->route('inventaire.index')
            ->with('success', 'Inventaire clôturé avec succès.');
    }


    /**
     * Historique des inventaires.
     */
    public function historique()
    {
        $ownerId = Auth::user()->getOwnerId();

        $inventaires = Inventaire::where('user_id', $ownerId)
            ->withCount('details')
            ->latest('date_inventaire')
            ->paginate(20);

        return view(
            'inventaire.historique',
            compact('inventaires')
        );
    }


    /**
     * Afficher le détail d'un inventaire.
     */
    public function show($id)
    {
        $ownerId = Auth::user()->getOwnerId();

        $inventaire = Inventaire::where('user_id', $ownerId)
            ->with([
                'details.produit',
                'user',
            ])
            ->findOrFail($id);

        return view(
            'inventaire.show',
            compact('inventaire')
        );
    }


   
public function recapitulatif()
{
    $ownerId = Auth::user()->getOwnerId();

    /*
    |--------------------------------------------------------------------------
    | Inventaires clôturés
    |--------------------------------------------------------------------------
    */

    $inventaires = Inventaire::where('user_id', $ownerId)
        ->where('statut', 'cloture')
        ->latest('date_cloture')
        ->paginate(20);

    /*
    |--------------------------------------------------------------------------
    | Total des gains
    |--------------------------------------------------------------------------
    */

    $totalGain = Inventaire::where('user_id', $ownerId)
        ->where('statut', 'cloture')
        ->sum('total_gain');

    /*
    |--------------------------------------------------------------------------
    | Total des pertes
    |--------------------------------------------------------------------------
    */

    $totalPerte = Inventaire::where('user_id', $ownerId)
        ->where('statut', 'cloture')
        ->sum('total_perte');

    /*
    |--------------------------------------------------------------------------
    | Écart global
    |
    | Gain - Perte
    |
    | Positif  = gain global
    | Négatif  = perte globale
    | 0        = équilibre
    |--------------------------------------------------------------------------
    */

    $ecartGlobal = $totalGain - $totalPerte;

    /*
    |--------------------------------------------------------------------------
    | Résultat global
    |--------------------------------------------------------------------------
    */

    $resultat = $ecartGlobal;

    return view(
        'inventaire.recapitulatif',
        compact(
            'inventaires',
            'totalGain',
            'totalPerte',
            'ecartGlobal',
            'resultat'
        )
    );
}


}


<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Vente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================================================
        // UTILISATEUR CONNECTÉ
        // =========================================================

        $user = Auth::user();

        // Super administrateur
        if (
            $user &&
            method_exists($user, 'isSuperAdmin') &&
            $user->isSuperAdmin()
        ) {
            return redirect()->route('super-admin.dashboard');
        }

        // Sécurité
        if (!$user) {
            return redirect()->route('login');
        }

        // Propriétaire réel des données
        $userId = $user->getOwnerId();


        // =========================================================
        // STOCK ACTUEL RÉEL
        //
        // IMPORTANT :
        // La table stocks contient la quantité réellement disponible.
        //
        // stocks.quantite = stock actuellement disponible
        //
        // On ne recalcule donc PAS le stock avec mouvement_stocks.
        // =========================================================

        $stockSubQuery = DB::table('stocks')
            ->select(
                'produit_id',
                DB::raw('SUM(quantite) AS current_stock')
            )
            ->where(function ($query) {
                $query
                    ->whereNull('date_peremption')
                    ->orWhere('date_peremption', '>=', now());
            })
            ->groupBy('produit_id');


        // =========================================================
        // STOCK À SURVEILLER
        //
        // Un produit est à surveiller lorsque :
        //
        // stock actuel <= stock minimum
        //
        // On affiche les produits les plus urgents en premier.
        // =========================================================

        $lowStockProducts = Produit::query()
            ->leftJoinSub(
                $stockSubQuery,
                'stocks_actuels',
                function ($join) {
                    $join->on(
                        'produits.id',
                        '=',
                        'stocks_actuels.produit_id'
                    );
                }
            )
            ->where('produits.user_id', $userId)
            ->where('produits.statut', 1)
            ->whereRaw(
                'COALESCE(stocks_actuels.current_stock, 0) <= produits.stock_minimum'
            )
            ->select(
                'produits.id',
                'produits.nom_produit',
                'produits.stock_minimum',
                'produits.prix_produit',
                DB::raw(
                    'COALESCE(stocks_actuels.current_stock, 0) AS current_stock'
                )
            )
            ->orderByRaw(
                'COALESCE(stocks_actuels.current_stock, 0) ASC'
            )
            ->get();

        $lowStockCount = $lowStockProducts->count();


        // =========================================================
        // VALEUR RÉELLE DU STOCK
        //
        // Valeur du stock =
        //
        // quantité réellement disponible
        // × prix d'achat
        //
        // Exemple :
        //
        // Riz
        // Stock actuel = 10
        // Prix achat = 250 000
        //
        // Valeur = 10 × 250 000
        //        = 2 500 000
        // =========================================================

        $valeurStock = DB::table('produits')
            ->leftJoinSub(
                $stockSubQuery,
                'stocks_actuels',
                function ($join) {
                    $join->on(
                        'produits.id',
                        '=',
                        'stocks_actuels.produit_id'
                    );
                }
            )
            ->where('produits.user_id', $userId)
            ->where('produits.statut', 1)
            ->selectRaw('
                COALESCE(
                    SUM(
                        COALESCE(stocks_actuels.current_stock, 0)
                        * produits.prix_produit
                    ),
                    0
                ) AS valeur_stock
            ')
            ->value('valeur_stock');

        $valeurStock = (float) ($valeurStock ?? 0);


        // =========================================================
        // CRÉANCES CLIENTS
        //
        // Créance =
        //
        // montant total de la vente
        // - paiements déjà effectués
        // =========================================================

        $totalCreances = DB::table('ventes')
            ->leftJoin(
                DB::raw('(
                    SELECT
                        vente_id,
                        SUM(montant_paye) AS total_paye
                    FROM paiements
                    GROUP BY vente_id
                ) AS paiements_total'),
                'ventes.id',
                '=',
                'paiements_total.vente_id'
            )
            ->where('ventes.user_id', $userId)
            ->selectRaw('
                COALESCE(
                    SUM(
                        GREATEST(
                            ventes.montant_total
                            - COALESCE(paiements_total.total_paye, 0),
                            0
                        )
                    ),
                    0
                ) AS total_creances
            ')
            ->value('total_creances');

        $totalCreances = (float) ($totalCreances ?? 0);


        // =========================================================
        // TOTAL DES VENTES
        //
        // IMPORTANT :
        // montant_total contient déjà la remise.
        // =========================================================

        $totalSales = Vente::where('user_id', $userId)
            ->sum('montant_total');

        $totalSales = (float) ($totalSales ?? 0);


        // =========================================================
        // VENTES DU JOUR
        //
        // montant_total contient déjà la remise.
        // =========================================================

        $todaySales = Vente::where('user_id', $userId)
            ->whereDate(
                'date_vente',
                Carbon::today()
            )
            ->sum('montant_total');

        $todaySales = (float) ($todaySales ?? 0);


        // =========================================================
        // BÉNÉFICE DU JOUR
        //
        // IMPORTANT :
        //
        // On prend en compte les remises.
        //
        // Exemple :
        //
        // Prix brut       = 1 000 000
        // Remise          = 100 000
        // Vente réelle    = 900 000
        //
        // Le bénéfice doit être calculé sur 900 000
        // et non sur 1 000 000.
        //
        // La remise est répartie proportionnellement
        // entre les différents produits de la vente.
        // =========================================================

        $benefice = DB::table('vente_details')
            ->join(
                'produits',
                'vente_details.produit_id',
                '=',
                'produits.id'
            )
            ->join(
                'ventes',
                'vente_details.vente_id',
                '=',
                'ventes.id'
            )
            ->where('ventes.user_id', $userId)
            ->whereDate(
                'ventes.date_vente',
                Carbon::today()
            )
            ->selectRaw('
                COALESCE(
                    SUM(
                        (
                            (
                                vente_details.prix_unitaire
                                * vente_details.quantite
                            )
                            *
                            CASE
                                WHEN ventes.montant_brut > 0
                                THEN ventes.montant_total / ventes.montant_brut
                                ELSE 0
                            END
                        )
                        -
                        (
                            produits.prix_produit
                            * vente_details.quantite
                        )
                    ),
                    0
                ) AS profit
            ')
            ->value('profit');

        $benefice = (float) ($benefice ?? 0);


        // =========================================================
        // BÉNÉFICE TOTAL
        //
        // Même logique :
        //
        // CA réel après remise
        // - coût d'achat réel
        // = bénéfice réel
        // =========================================================

        $beneficeTotal = DB::table('vente_details')
            ->join(
                'produits',
                'vente_details.produit_id',
                '=',
                'produits.id'
            )
            ->join(
                'ventes',
                'vente_details.vente_id',
                '=',
                'ventes.id'
            )
            ->where('ventes.user_id', $userId)
            ->selectRaw('
                COALESCE(
                    SUM(
                        (
                            (
                                vente_details.prix_unitaire
                                * vente_details.quantite
                            )
                            *
                            CASE
                                WHEN ventes.montant_brut > 0
                                THEN ventes.montant_total / ventes.montant_brut
                                ELSE 0
                            END
                        )
                        -
                        (
                            produits.prix_produit
                            * vente_details.quantite
                        )
                    ),
                    0
                ) AS total
            ')
            ->value('total');

        $beneficeTotal = (float) ($beneficeTotal ?? 0);


        // =========================================================
        // PRODUITS LES PLUS VENDUS
        //
        // total_vendu = quantité vendue
        //
        // total_revenue = chiffre d'affaires réel après remise
        //
        // La remise est répartie proportionnellement sur
        // chaque produit de la vente.
        // =========================================================

        $topProducts = DB::table('vente_details')
            ->join(
                'produits',
                'vente_details.produit_id',
                '=',
                'produits.id'
            )
            ->join(
                'ventes',
                'vente_details.vente_id',
                '=',
                'ventes.id'
            )
            ->where('ventes.user_id', $userId)
            ->select(
                'produits.id',
                'produits.nom_produit',
                DB::raw(
                    'SUM(vente_details.quantite) AS total_vendu'
                ),
                DB::raw('
                    SUM(
                        (
                            vente_details.quantite
                            * vente_details.prix_unitaire
                        )
                        *
                        CASE
                            WHEN ventes.montant_brut > 0
                            THEN ventes.montant_total / ventes.montant_brut
                            ELSE 0
                        END
                    ) AS total_revenue
                ')
            )
            ->groupBy(
                'produits.id',
                'produits.nom_produit'
            )
            ->orderByDesc('total_vendu')
            ->limit(6)
            ->get();


        // =========================================================
        // POURCENTAGE DES PRODUITS LES PLUS VENDUS
        //
        // Le produit ayant vendu le plus de quantité = 100 %
        // =========================================================

        $maxVendu = (float) (
            $topProducts->max('total_vendu') ?? 0
        );

        $topProducts = $topProducts->map(
            function ($product) use ($maxVendu) {

                $product->percentage = $maxVendu > 0
                    ? (
                        ((float) $product->total_vendu
                        / $maxVendu) * 100
                    )
                    : 0;

                return $product;
            }
        );


        // =========================================================
        // VENTES DES 30 DERNIERS JOURS
        //
        // montant_total = montant après remise
        // =========================================================

        $salesLast30Days = DB::table('ventes')
            ->where('user_id', $userId)
            ->selectRaw('
                DATE(date_vente) AS date,
                SUM(montant_total) AS total
            ')
            ->whereDate(
                'date_vente',
                '>=',
                Carbon::now()->subDays(30)
            )
            ->groupBy(
                DB::raw('DATE(date_vente)')
            )
            ->orderBy('date')
            ->get()
            ->map(function ($item) {

                return [
                    'date' => (string) $item->date,
                    'total' => (float) $item->total,
                ];
            })
            ->toArray();


        // =========================================================
        // ENVOI AU DASHBOARD
        // =========================================================

        return view('dashboard', compact(
            'lowStockCount',
            'lowStockProducts',
            'totalSales',
            'todaySales',
            'benefice',
            'topProducts',
            'salesLast30Days',
            'beneficeTotal',
            'valeurStock',
            'totalCreances'
        ));
    }
}

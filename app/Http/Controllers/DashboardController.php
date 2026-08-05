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
        // Rediriger le super admin vers son propre dashboard
        $user = Auth::user();
        if ($user && method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard');
        }

        if (!$user) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
            return redirect()->route('login');
        }

        $userId = $user->getOwnerId();
        /**
         * ========================
         * Calcul du stock réel
         * ========================
         */
        $stockSubQuery = DB::table('mouvement_stocks')
            ->select(
                'produit_id',
                DB::raw("SUM(CASE WHEN type_mouvement = 'entree' THEN quantite ELSE -quantite END) as stock")
            )
            ->groupBy('produit_id');

        /**
         * ========================
         * Produits en rupture (filtrés par utilisateur)
         * ========================
         */
        $lowStockProducts = Produit::leftJoinSub($stockSubQuery, 'stocks', function ($join) {
                $join->on('produits.id', '=', 'stocks.produit_id');
            })
            ->where('produits.user_id', $userId)
            ->whereRaw('COALESCE(stocks.stock, 0) <= produits.stock_minimum')
            ->where('produits.statut', 1)
            ->select(
                'produits.id',
                'produits.nom_produit',
                'produits.stock_minimum',
                DB::raw('COALESCE(stocks.stock,0) as current_stock')
            )
            ->get();

        $lowStockCount = $lowStockProducts->count();

        /**
         * ========================
         * Ventes (filtrées par utilisateur)
         * ========================
         */
        $totalSales = Vente::where('user_id', $userId)->sum('montant_total');

        $todaySales = Vente::where('user_id', $userId)
            ->whereDate('date_vente', Carbon::today())
            ->sum('montant_total');

        /**
         * ========================
         * Bénéfice du jour (Prix de vente - Prix d'achat) - filtré par utilisateur
         * ========================
         */
        $benefice = DB::table('vente_details')
            ->join('produits', 'vente_details.produit_id', '=', 'produits.id')
            ->join('ventes', 'vente_details.vente_id', '=', 'ventes.id')
            ->where('ventes.user_id', $userId)
            ->whereDate('ventes.date_vente', Carbon::today())
            ->selectRaw('SUM((vente_details.prix_unitaire - produits.prix_produit) * vente_details.quantite) as profit')
            ->value('profit') ?? 0;

        /**
         * ========================
         * Bénéfice total (Prix de vente - Prix d'achat) - filtré par utilisateur
         * ========================
         */
        $beneficeTotal = DB::table('vente_details')
            ->join('produits', 'vente_details.produit_id', '=', 'produits.id')
            ->join('ventes', 'vente_details.vente_id', '=', 'ventes.id')
            ->where('ventes.user_id', $userId)
            ->selectRaw('SUM((vente_details.prix_unitaire - produits.prix_produit) * vente_details.quantite) as total')
            ->value('total') ?? 0;

        /**
         * ========================
         * Produits les plus vendus (filtrés par utilisateur)
         * ========================
         */
        $topProducts = DB::table('vente_details')
            ->join('produits', 'vente_details.produit_id', '=', 'produits.id')
            ->join('ventes', 'vente_details.vente_id', '=', 'ventes.id')
            ->where('ventes.user_id', $userId)
            ->select(
                'produits.nom_produit',
                DB::raw('SUM(vente_details.quantite) as total_vendu'),
                DB::raw('SUM(vente_details.quantite * vente_details.prix_unitaire) as total_revenue')
            )
            ->groupBy('produits.id', 'produits.nom_produit')
            ->orderByDesc('total_vendu')
            ->limit(6)
            ->get();

        /**
         * ========================
         * Ventes 30 derniers jours (filtrées par utilisateur)
         * ========================
         */
        $salesLast30Days = DB::table('ventes')
            ->where('user_id', $userId)
            ->selectRaw('DATE(date_vente) as date, SUM(montant_total) as total')
            ->whereDate('date_vente', '>=', Carbon::now()->subDays(30))
            ->groupBy(DB::raw('DATE(date_vente)'))
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => (string) $item->date,
                    'total' => (float) $item->total
                ];
            })
            ->toArray();

        return view('dashboard', compact(
            'lowStockCount',
            'lowStockProducts',
            'totalSales',
            'todaySales',
            'benefice',
            'topProducts',
            'salesLast30Days',
            'beneficeTotal'
        ));
    }
}

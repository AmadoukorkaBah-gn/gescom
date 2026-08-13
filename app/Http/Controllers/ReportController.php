<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\DetailVente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Rapport : Ventes par période
     */
    public function salesByPeriod(Request $request)
    {
        $dateDebut = $request->input(
            'date_debut',
            now()->subMonth()->format('Y-m-d')
        );

        $dateFin = $request->input(
            'date_fin',
            now()->format('Y-m-d')
        );

        // Utilisateur propriétaire des données
        $userId = Auth::user()->getOwnerId();

        /*
         * PostgreSQL :
         * DATE(date_vente) fonctionne avec PostgreSQL.
         */
        $ventes = Vente::whereDate('date_vente', '>=', $dateDebut)
            ->whereDate('date_vente', '<=', $dateFin)
            ->where('user_id', $userId)
            ->selectRaw("
                DATE(date_vente) as date,
                COUNT(*) as nombre_ventes,
                SUM(montant_total) as total_montant
            ")
            ->groupByRaw('DATE(date_vente)')
            ->orderBy('date')
            ->get()
            ->toArray();

        $totalVentes = collect($ventes)->sum('nombre_ventes');
        $totalMontant = collect($ventes)->sum('total_montant');

        return view(
            'reports.sales_by_period',
            compact(
                'ventes',
                'dateDebut',
                'dateFin',
                'totalVentes',
                'totalMontant'
            )
        );
    }


    /**
     * Rapport : Chiffre d'affaires
     */
    public function revenue(Request $request)
    {
        $periode = $request->input('periode', 'monthly');

        $dateDebut = match ($periode) {
            'daily' => now()->subDays(30),
            'weekly' => now()->subWeeks(12),
            'monthly' => now()->subMonths(12),
            'yearly' => now()->subYears(5),
            default => now()->subMonths(12),
        };

        // Propriétaire des données
        $userId = Auth::user()->getOwnerId();

        $data = match ($periode) {
            'daily' => $this->calculateDailyRevenue($dateDebut, $userId),

            'weekly' => $this->calculateWeeklyRevenue($dateDebut, $userId),

            'monthly' => $this->calculateMonthlyRevenue($dateDebut, $userId),

            'yearly' => $this->calculateYearlyRevenue($dateDebut, $userId),

            default => $this->calculateMonthlyRevenue($dateDebut, $userId),
        };

        $totalRevenue = collect($data)->sum('total');

        $averageRevenue = count($data) > 0
            ? $totalRevenue / count($data)
            : 0;

        return view(
            'reports.revenue',
            compact(
                'data',
                'periode',
                'totalRevenue',
                'averageRevenue'
            )
        );
    }


    /**
     * CA quotidien
     *
     * PostgreSQL
     */
    private function calculateDailyRevenue($dateDebut, $userId)
    {
        return Vente::where('date_vente', '>=', $dateDebut)
            ->where('user_id', $userId)

            ->selectRaw("
                DATE(date_vente) as date,
                SUM(montant_total) as total,
                COUNT(*) as nombre
            ")

            ->groupByRaw('DATE(date_vente)')
            ->orderBy('date')

            ->get()

            ->map(function ($item) {

                return [
                    'label' => Carbon::parse($item->date)
                        ->format('d/m'),

                    'total' => (float) $item->total,

                    'nombre' => (int) $item->nombre,
                ];
            })

            ->toArray();
    }


    /**
     * CA hebdomadaire
     *
     * PostgreSQL
     *
     * On utilise DATE_TRUNC('week', ...)
     * au lieu de YEARWEEK().
     */
    private function calculateWeeklyRevenue($dateDebut, $userId)
    {
        return Vente::where('date_vente', '>=', $dateDebut)
            ->where('user_id', $userId)

            ->selectRaw("
                DATE_TRUNC('week', date_vente) as semaine,
                SUM(montant_total) as total,
                COUNT(*) as nombre
            ")

            ->groupByRaw("DATE_TRUNC('week', date_vente)")
            ->orderBy('semaine')

            ->get()

            ->map(function ($item) {

                $date = Carbon::parse($item->semaine);

                return [
                    'label' => 'Semaine ' . $date->format('W'),

                    'total' => (float) $item->total,

                    'nombre' => (int) $item->nombre,
                ];
            })

            ->toArray();
    }


    /**
     * CA mensuel
     *
     * PostgreSQL
     *
     * On utilise DATE_TRUNC('month', ...)
     * au lieu de DATE_FORMAT().
     */
    private function calculateMonthlyRevenue($dateDebut, $userId)
    {
        return Vente::where('date_vente', '>=', $dateDebut)
            ->where('user_id', $userId)

            ->selectRaw("
                DATE_TRUNC('month', date_vente) as mois,
                SUM(montant_total) as total,
                COUNT(*) as nombre
            ")

            ->groupByRaw("DATE_TRUNC('month', date_vente)")
            ->orderBy('mois')

            ->get()

            ->map(function ($item) {

                $date = Carbon::parse($item->mois);

                return [
                    'label' => $date->format('M Y'),

                    'total' => (float) $item->total,

                    'nombre' => (int) $item->nombre,
                ];
            })

            ->toArray();
    }


    /**
     * CA annuel
     *
     * PostgreSQL
     */
    private function calculateYearlyRevenue($dateDebut, $userId)
    {
        return Vente::where('date_vente', '>=', $dateDebut)
            ->where('user_id', $userId)

            ->selectRaw("
                EXTRACT(YEAR FROM date_vente) as annee,
                SUM(montant_total) as total,
                COUNT(*) as nombre
            ")

            ->groupByRaw("EXTRACT(YEAR FROM date_vente)")
            ->orderBy('annee')

            ->get()

            ->map(function ($item) {

                return [
                    'label' => (int) $item->annee,

                    'total' => (float) $item->total,

                    'nombre' => (int) $item->nombre,
                ];
            })

            ->toArray();
    }


    /**
     * Rapport : Produits les plus vendus
     */
    public function topProducts(Request $request)
    {
        $limite = (int) $request->input('limite', 10);

        $dateDebut = $request->input(
            'date_debut',
            now()->subMonth()->format('Y-m-d')
        );

        $dateFin = $request->input(
            'date_fin',
            now()->format('Y-m-d')
        );

        // Propriétaire des données
        $userId = Auth::user()->getOwnerId();

        $produits = DetailVente::selectRaw("
                produits.id,
                produits.nom_produit,
                SUM(vente_details.quantite) as total_quantite,
                COUNT(DISTINCT ventes.id) as nombre_ventes,
                SUM(
                    vente_details.quantite * vente_details.prix_unitaire
                ) as chiffre_affaires
            ")

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

            ->whereDate(
                'ventes.date_vente',
                '>=',
                $dateDebut
            )

            ->whereDate(
                'ventes.date_vente',
                '<=',
                $dateFin
            )

            ->where(
                'ventes.user_id',
                $userId
            )

            ->groupBy(
                'produits.id',
                'produits.nom_produit'
            )

            ->orderByDesc('total_quantite')

            ->limit($limite)

            ->get()

            ->toArray();

        return view(
            'reports.top_products',
            compact(
                'produits',
                'limite',
                'dateDebut',
                'dateFin'
            )
        );
    }
}
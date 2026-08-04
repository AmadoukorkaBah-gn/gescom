<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\DetailVente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Rapport : Ventes par période
     */
    public function salesByPeriod(Request $request)
    {
        $dateDebut = $request->input('date_debut', now()->subMonth()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', now()->format('Y-m-d'));

        // Récupère uniquement les ventes de l'utilisateur connecté
        $userId = Auth::user()->getOwnerId();

        // Calcule les ventes par jour pour l'utilisateur
        $ventes = Vente::whereBetween('date_vente', [$dateDebut, $dateFin])
            ->where('user_id', $userId)
            ->selectRaw('DATE(date_vente) as date, COUNT(*) as nombre_ventes, SUM(montant_total) as total_montant')
            ->groupBy(DB::raw('DATE(date_vente)'))
            ->orderBy('date')
            ->get()
            ->toArray();

        $totalVentes = collect($ventes)->sum('nombre_ventes');
        $totalMontant = collect($ventes)->sum('total_montant');

        return view('reports.sales_by_period', compact('ventes', 'dateDebut', 'dateFin', 'totalVentes', 'totalMontant'));
    }

    /**
     * Rapport : Chiffre d'affaires
     */
    public function revenue(Request $request)
    {
        $periode = $request->input('periode', 'monthly'); // daily, weekly, monthly, yearly

        // Détermine la plage de dates selon la période
        $dateDebut = match($periode) {
            'daily' => now()->subDays(30),
            'weekly' => now()->subWeeks(12),
            'monthly' => now()->subMonths(12),
            'yearly' => now()->subYears(5),
            default => now()->subMonths(12),
        };

        // Calculer le CA uniquement pour l'utilisateur connecté
        $userId = Auth::user()->getOwnerId();

        // Calcule le CA selon la période (toujours pour l'utilisateur courant)
        $data = match($periode) {
            'daily' => $this->calculateDailyRevenue($dateDebut, $userId),
            'weekly' => $this->calculateWeeklyRevenue($dateDebut, $userId),
            'monthly' => $this->calculateMonthlyRevenue($dateDebut, $userId),
            'yearly' => $this->calculateYearlyRevenue($dateDebut, $userId),
            default => $this->calculateMonthlyRevenue($dateDebut, $userId),
        };

        $totalRevenue = collect($data)->sum('total');
        $averageRevenue = count($data) > 0 ? $totalRevenue / count($data) : 0;

        return view('reports.revenue', compact('data', 'periode', 'totalRevenue', 'averageRevenue'));
    }

    /**
     * Calcule le CA quotidien
     */
    private function calculateDailyRevenue($dateDebut, $userId)
    {
        return Vente::where('date_vente', '>=', $dateDebut)
            ->where('user_id', $userId)
            ->selectRaw('DATE(date_vente) as date, SUM(montant_total) as total, COUNT(*) as nombre')
            ->groupBy(DB::raw('DATE(date_vente)'))
            ->orderBy('date')
            ->get()
            ->map(fn($item) => [
                'label' => \Carbon\Carbon::parse($item->date)->format('d/m'),
                'total' => (float) $item->total,
                'nombre' => $item->nombre,
            ])
            ->toArray();
    }

    /**
     * Calcule le CA hebdomadaire
     */
    private function calculateWeeklyRevenue($dateDebut, $userId)
    {
        return Vente::where('date_vente', '>=', $dateDebut)
            ->where('user_id', $userId)
            ->selectRaw('YEARWEEK(date_vente) as week, SUM(montant_total) as total, COUNT(*) as nombre')
            ->groupBy(DB::raw('YEARWEEK(date_vente)'))
            ->orderBy('week')
            ->get()
            ->map(fn($item) => [
                'label' => 'Semaine ' . substr($item->week, -2),
                'total' => (float) $item->total,
                'nombre' => $item->nombre,
            ])
            ->toArray();
    }

    /**
     * Calcule le CA mensuel
     */
    private function calculateMonthlyRevenue($dateDebut, $userId)
    {
        return Vente::where('date_vente', '>=', $dateDebut)
            ->where('user_id', $userId)
            ->selectRaw('DATE_FORMAT(date_vente, "%Y-%m") as mois, SUM(montant_total) as total, COUNT(*) as nombre')
            ->groupBy(DB::raw('DATE_FORMAT(date_vente, "%Y-%m")'))
            ->orderBy('mois')
            ->get()
            ->map(fn($item) => [
                'label' => \Carbon\Carbon::createFromFormat('Y-m', $item->mois)->format('M Y'),
                'total' => (float) $item->total,
                'nombre' => $item->nombre,
            ])
            ->toArray();
    }

    /**
     * Calcule le CA annuel
     */
    private function calculateYearlyRevenue($dateDebut, $userId)
    {
        return Vente::where('date_vente', '>=', $dateDebut)
            ->where('user_id', $userId)
            ->selectRaw('YEAR(date_vente) as annee, SUM(montant_total) as total, COUNT(*) as nombre')
            ->groupBy(DB::raw('YEAR(date_vente)'))
            ->orderBy('annee')
            ->get()
            ->map(fn($item) => [
                'label' => $item->annee,
                'total' => (float) $item->total,
                'nombre' => $item->nombre,
            ])
            ->toArray();
    }

    /**
     * Rapport : Produits les plus vendus
     */
    public function topProducts(Request $request)
    {
        $limite = $request->input('limite', 10);
        $dateDebut = $request->input('date_debut', now()->subMonth()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', now()->format('Y-m-d'));

        // Récupère les produits les plus vendus pour l'utilisateur connecté
        $userId = Auth::user()->getOwnerId();

        $produits = DetailVente::selectRaw(
            'produits.id, produits.nom_produit, SUM(vente_details.quantite) as total_quantite, COUNT(DISTINCT ventes.id) as nombre_ventes, SUM(vente_details.quantite * vente_details.prix_unitaire) as chiffre_affaires'
        )
            ->join('produits', 'vente_details.produit_id', '=', 'produits.id')
            ->join('ventes', 'vente_details.vente_id', '=', 'ventes.id')
            ->whereBetween('ventes.date_vente', [$dateDebut, $dateFin])
            ->where('ventes.user_id', $userId)
            ->groupBy('produits.id', 'produits.nom_produit')
            ->orderBy('total_quantite', 'desc')
            ->limit($limite)
            ->get()
            ->toArray();

        return view('reports.top_products', compact('produits', 'limite', 'dateDebut', 'dateFin'));
    }
}

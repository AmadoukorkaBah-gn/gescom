<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Achat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetteController extends Controller
{
    /**
     * Afficher le tableau de bord des dettes
     */
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();

        // Dettes clients (ventes non entièrement payées)
        $dettesClients = Vente::with(['client', 'paiements'])
            ->where('user_id', $ownerId)
            ->whereIn('statut', ['en_cours', 'partiel'])
            ->orderBy('date_vente', 'desc')
            ->get()
            ->map(function ($vente) {
                $totalPaye = $vente->paiements->sum('montant_paye');
                $vente->total_paye = $totalPaye;
                $vente->reste_a_payer = $vente->montant_total - $totalPaye;
                return $vente;
            });

        // Dettes fournisseurs (achats non entièrement payés)
        $dettesFournisseurs = Achat::with(['fournisseur', 'paiements'])
            ->where('user_id', $ownerId)
            ->where('statut', 'recu')
            ->whereIn('statut_paiement', ['non_paye', 'partiel'])
            ->orderBy('date_achat', 'desc')
            ->get();

        // Totaux
        $totalDettesClients = $dettesClients->sum('reste_a_payer');
        $totalDettesFournisseurs = $dettesFournisseurs->sum('reste_a_payer');

        return view('comptabilite.dettes.index', compact(
            'dettesClients',
            'dettesFournisseurs',
            'totalDettesClients',
            'totalDettesFournisseurs'
        ));
    }

    /**
     * Détails des dettes d'un client spécifique
     */
    public function clientDetails($clientId)
    {
        $ownerId = Auth::user()->getOwnerId();

        $ventes = Vente::with(['client', 'paiements', 'details.produit'])
            ->where('user_id', $ownerId)
            ->where('client_id', $clientId)
            ->whereIn('statut', ['en_cours', 'partiel'])
            ->orderBy('date_vente', 'desc')
            ->get()
            ->map(function ($vente) {
                $totalPaye = $vente->paiements->sum('montant_paye');
                $vente->total_paye = $totalPaye;
                $vente->reste_a_payer = $vente->montant_total - $totalPaye;
                return $vente;
            });

        $client = $ventes->first()?->client;
        $totalDette = $ventes->sum('reste_a_payer');

        return view('comptabilite.dettes.client-details', compact('ventes', 'client', 'totalDette'));
    }

    /**
     * Détails des dettes envers un fournisseur spécifique
     */
    public function fournisseurDetails($fournisseurId)
    {
        $ownerId = Auth::user()->getOwnerId();

        $achats = Achat::with(['fournisseur', 'paiements', 'details.produit'])
            ->where('user_id', $ownerId)
            ->where('fournisseur_id', $fournisseurId)
            ->where('statut', 'recu')
            ->whereIn('statut_paiement', ['non_paye', 'partiel'])
            ->orderBy('date_achat', 'desc')
            ->get();

        $fournisseur = $achats->first()?->fournisseur;
        $totalDette = $achats->sum('reste_a_payer');

        return view('comptabilite.dettes.fournisseur-details', compact('achats', 'fournisseur', 'totalDette'));
    }
}

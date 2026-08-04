<?php

namespace App\Http\Controllers;

use App\Models\PaiementAchat;
use App\Models\Achat;
use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaiementAchatController extends Controller
{
    /**
     * Liste des paiements fournisseurs
     */
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();
        $paiements = PaiementAchat::with(['achat.fournisseur', 'caisse'])
            ->whereHas('achat', fn($q) => $q->where('user_id', $ownerId))
            ->orderBy('date_paiement', 'desc')
            ->paginate(15);

        return view('paiement-achats.index', compact('paiements'));
    }

    /**
     * Formulaire de création d'un paiement
     */
    public function create(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();
        $achat_id = $request->query('achat_id');
        
        $achat = null;
        if ($achat_id) {
            $achat = Achat::where('user_id', $ownerId)
                ->where('id', $achat_id)
                ->with('fournisseur')
                ->first();
        }

        $caisses = Caisse::where('user_id', $ownerId)->orderBy('nom')->get();
        
        // Achats non entièrement payés
        $achats = Achat::where('user_id', $ownerId)
            ->where('statut', 'recu')
            ->where('statut_paiement', '!=', 'paye')
            ->with('fournisseur')
            ->orderBy('date_achat', 'desc')
            ->get();

        return view('paiement-achats.create', compact('caisses', 'achats', 'achat'));
    }

    /**
     * Enregistrer un paiement
     */
    public function store(Request $request)
    {
        $request->validate([
            'achat_id' => 'required|exists:achats,id',
            'montant_paye' => 'required|numeric|min:0.01',
            'date_paiement' => 'required|date',
            'caisse_id' => 'required|exists:caisses,id',
            'mode' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $achat = Achat::findOrFail($request->achat_id);
        $caisse = Caisse::findOrFail($request->caisse_id);

        // Vérifier que le montant ne dépasse pas le reste à payer
        $resteAPayer = $achat->total - $achat->montant_paye;
        if ($request->montant_paye > $resteAPayer) {
            return back()->with('error', 'Le montant dépasse le reste à payer (' . number_format($resteAPayer, 2) . ' GNF).')->withInput();
        }

        // Vérifier le solde de la caisse
        if ($caisse->solde < $request->montant_paye) {
            return back()->with('error', 'Solde insuffisant dans la caisse. Solde actuel: ' . number_format($caisse->solde, 2) . ' GNF')->withInput();
        }

        DB::transaction(function () use ($request, $achat, $caisse) {
            // Créer le paiement
            PaiementAchat::create([
                'achat_id' => $request->achat_id,
                'caisse_id' => $request->caisse_id,
                'montant_paye' => $request->montant_paye,
                'date_paiement' => $request->date_paiement,
                'mode' => $request->mode,
                'note' => $request->note,
            ]);

            // Débiter la caisse
            $caisse->debiter($request->montant_paye);

            // Mettre à jour le statut de paiement de l'achat
            $achat->updateStatutPaiement();
        });

        return redirect()->route('achats.index')->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Afficher les détails d'un paiement
     */
    public function show(PaiementAchat $paiementAchat)
    {
        $paiementAchat->load('achat.fournisseur', 'caisse');
        return view('paiement-achats.show', compact('paiementAchat'));
    }

    /**
     * Supprimer un paiement
     */
    public function destroy(PaiementAchat $paiementAchat)
    {
        DB::transaction(function () use ($paiementAchat) {
            // Rembourser la caisse
            $caisse = Caisse::find($paiementAchat->caisse_id);
            if ($caisse) {
                $caisse->crediter($paiementAchat->montant_paye);
            }

            $achat = $paiementAchat->achat;
            
            // Supprimer le paiement
            $paiementAchat->delete();

            // Mettre à jour le statut de l'achat
            $achat->updateStatutPaiement();
        });

        return redirect()->route('paiement-achats.index')->with('success', 'Paiement supprimé et caisse remboursée.');
    }
}

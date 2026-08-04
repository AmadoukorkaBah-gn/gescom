<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retour;
use App\Models\Produit;
use App\Models\Vente;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;

class RetourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();
        // Affiche tous les retours avec le produit et la vente liés (filtrés par utilisateur via vente)
        $retours = Retour::with(['produit', 'vente'])
            ->whereHas('vente', function($q) use ($ownerId) {
                $q->where('user_id', $ownerId);
            })
            ->orderBy('date_retour', 'desc')
            ->get();
        return view('retours.index', compact('retours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ownerId = Auth::user()->getOwnerId();
        $ventes = Vente::where('user_id', $ownerId)->with('details.produit', 'client')->get();
        $produits = Produit::where('user_id', $ownerId)->get();
        return view('retours.create', compact('ventes', 'produits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vente_id' => 'required|exists:ventes,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'raison' => 'required|string',
            'caisse_id' => 'required|exists:caisses,id',
        ]);

        // Créer le retour
        $retour = Retour::create([
            'vente_id' => $request->vente_id,
            'produit_id' => $request->produit_id,
            'quantite' => $request->quantite,
            'date_retour' => now(),
            'raison' => $request->raison,
        ]);

        // Mettre à jour le stock via le modèle Produit
        $produit = Produit::find($request->produit_id);
        $produit->incrementStock($request->quantite, 'retour');

        // Diminuer l'argent encaissé (remboursement)
        // On cherche le paiement lié à la vente
        $vente = Vente::find($request->vente_id);
        $detailVente = $vente->details()->where('produit_id', $request->produit_id)->first();
        $prixUnitaire = $detailVente ? $detailVente->prix_unitaire : $produit->prix_vente;
        $montantARembourser = $prixUnitaire * $request->quantite;
        // On diminue le montant_paye du paiement principal de la vente
        // Répartir le remboursement sur tous les paiements liés à la vente (du plus ancien au plus récent)
        $paiements = Paiement::where('vente_id', $vente->id)->orderBy('date_paiement', 'asc')->get();
        $resteARembourser = $montantARembourser;
        foreach ($paiements as $paiement) {
            if ($resteARembourser <= 0) break;
            $aDeduire = min($paiement->montant_paye, $resteARembourser);
            $paiement->montant_paye -= $aDeduire;
            $paiement->save();
            $resteARembourser -= $aDeduire;
        }

        // Débiter la caisse sélectionnée
        $caisse = \App\Models\Caisse::find($request->caisse_id);
        if ($caisse) {
            $caisse->debiter($montantARembourser);
        }

        return redirect()->route('retours.index')->with('success', 'Retour enregistré, stock, paiement et caisse mis à jour.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $retour = Retour::with(['produit', 'vente'])->findOrFail($id);
        return view('retours.show', compact('retour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ownerId = Auth::user()->getOwnerId();
        $retour = Retour::findOrFail($id);
        $ventes = Vente::where('user_id', $ownerId)->get();
        $produits = Produit::where('user_id', $ownerId)->get();
        return view('retours.edit', compact('retour', 'ventes', 'produits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'vente_id' => 'required|exists:ventes,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'raison' => 'required|string',
        ]);

        $retour = Retour::findOrFail($id);
        $ancienneQuantite = $retour->quantite;

        $retour->update([
            'vente_id' => $request->vente_id,
            'produit_id' => $request->produit_id,
            'quantite' => $request->quantite,
            'raison' => $request->raison,
        ]);

        // Ajuster le stock
        $produit = Produit::find($request->produit_id);
        $diff = $request->quantite - $ancienneQuantite;

        if ($diff > 0) {
            $produit->incrementStock($diff, 'retour_modification');
        } elseif ($diff < 0) {
            $produit->decrementStock(abs($diff), 'retour_modification');
        }

        return redirect()->route('retours.index')->with('success', 'Retour mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $retour = Retour::findOrFail($id);

        // Ajuster le stock avant suppression
        $produit = Produit::find($retour->produit_id);
        $produit->decrementStock($retour->quantite, 'retour_supprime');

        $retour->delete();

        return redirect()->route('retours.index')->with('success', 'Retour supprimé avec succès.');
    }
}

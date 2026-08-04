<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Caisse;
use App\Models\Achat;
use App\Models\PaiementAchat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepenseController extends Controller
{
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();
        $depenses = Depense::with('caisse')
            ->whereHas('caisse', fn($q) => $q->where('user_id', $ownerId))
            ->orderBy('date_depense', 'desc')
            ->paginate(15);

        return view('comptabilite.depenses.index', compact('depenses'));
    }

    public function create(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();
        $achat_id = $request->query('achat_id');
        $achat = null;

        if ($achat_id) {
            $achat = Achat::where('user_id', $ownerId)
                ->with(['fournisseur', 'paiements'])
                ->find($achat_id);
        }

        $caisses = Caisse::where('user_id', $ownerId)->orderBy('nom')->get();
        return view('comptabilite.depenses.create', compact('caisses', 'achat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0.01',
            'caisse_id' => 'required|exists:caisses,id',
            'achat_id' => 'nullable|exists:achats,id',
            'mode' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $ownerId = Auth::user()->getOwnerId();

        // Forcer date_depense avec date + heure actuelles
        $dateDepense = now();

        // Si c'est un paiement d'achat, vérifier le montant
        if ($request->achat_id) {
            $achat = Achat::where('user_id', $ownerId)->findOrFail($request->achat_id);
            $resteAPayer = $achat->total - $achat->montant_paye;

            if ($request->montant > $resteAPayer) {
                return back()->with('error', 'Le montant dépasse le reste à payer (' . number_format($resteAPayer, 2) . ' GNF).')->withInput();
            }
        }

        // Vérifier le solde de la caisse
        $caisse = Caisse::find($request->caisse_id);
        if ($caisse->solde < $request->montant) {
            return back()->with('error', 'Solde insuffisant dans la caisse. Solde actuel: ' . number_format($caisse->solde, 2) . ' GNF')->withInput();
        }

        DB::transaction(function () use ($request, $ownerId, $caisse, $dateDepense) {
            // Créer la dépense
            $depense = Depense::create([
                'libelle' => $request->libelle,
                'montant' => $request->montant,
                'date_depense' => $dateDepense, // Correction ici
                'caisse_id' => $request->caisse_id,
                'user_id' => $ownerId,
            ]);

            // Débiter la caisse
            $caisse->debiter($request->montant);

            // Si c'est un paiement d'achat, créer le paiement associé
            if ($request->achat_id) {
                PaiementAchat::create([
                    'achat_id' => $request->achat_id,
                    'caisse_id' => $request->caisse_id,
                    'montant_paye' => $request->montant,
                    'date_paiement' => $dateDepense, // Correction ici
                    'mode' => $request->mode ?? 'especes',
                    'note' => $request->note,
                ]);

                // Mettre à jour le statut de paiement de l'achat
                $achat = Achat::find($request->achat_id);
                $achat->updateStatutPaiement();
            }
        });

        $redirectRoute = $request->achat_id ? 'achats.index' : 'depenses.index';
        return redirect()->route($redirectRoute)->with('success', 'Dépense enregistrée avec succès.');
    }

    public function show(Depense $depense)
    {
        $depense->load('caisse', 'user');
        return view('comptabilite.depenses.show', compact('depense'));
    }

    public function edit(Depense $depense)
    {
        $caisses = Caisse::where('user_id', Auth::user()->getOwnerId())->orderBy('nom')->get();
        return view('comptabilite.depenses.edit', compact('depense', 'caisses'));
    }

    public function update(Request $request, Depense $depense)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0.01',
            'caisse_id' => 'required|exists:caisses,id',
        ]);

        // Annuler l'ancien débit
        $ancienneCaisse = Caisse::find($depense->caisse_id);
        $ancienneCaisse->crediter($depense->montant);

        // Vérifier le nouveau solde
        $nouvelleCaisse = Caisse::find($request->caisse_id);
        if ($nouvelleCaisse->solde < $request->montant) {
            // Remettre l'ancien débit
            $ancienneCaisse->debiter($depense->montant);
            return back()->with('error', 'Solde insuffisant dans la caisse.')->withInput();
        }

        // Mettre à jour la dépense
        $depense->update($request->only('libelle', 'montant', 'date_depense', 'caisse_id'));

        // Appliquer le nouveau débit
        $nouvelleCaisse->debiter($request->montant);

        return redirect()->route('depenses.index')->with('success', 'Dépense mise à jour avec succès.');
    }

    public function destroy(Depense $depense)
    {
        // Annuler le débit (rembourser la caisse)
        $caisse = Caisse::find($depense->caisse_id);
        $caisse->crediter($depense->montant);

        $depense->delete();

        return redirect()->route('depenses.index')->with('success', 'Dépense supprimée avec succès.');
    }
}

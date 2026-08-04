<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use App\Models\Caisse;
use App\Models\Paiement;
use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecetteController extends Controller
{
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();
        $recettes = Recette::with('caisse')
            ->whereHas('caisse', fn($q) => $q->where('user_id', $ownerId))
            ->orderBy('date_recette', 'desc')
            ->paginate(15);

        return view('comptabilite.recettes.index', compact('recettes'));
    }

    public function create(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();
        $vente_id = $request->query('vente_id');
        $vente = null;

        if ($vente_id) {
            $vente = Vente::where('user_id', $ownerId)
                ->with(['client', 'paiements'])
                ->find($vente_id);

            if ($vente) {
                $totalPaye = $vente->paiements->sum('montant_paye');
                $resteAPayer = $vente->montant_total - $totalPaye;
            }
        }

        $caisses = Caisse::where('user_id', $ownerId)->orderBy('nom')->get();
        return view('comptabilite.recettes.create', compact('caisses', 'vente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0.01',
            'caisse_id' => 'required|exists:caisses,id',
            'vente_id' => 'nullable|exists:ventes,id',
            'mode' => 'nullable|string',
        ]);

        $ownerId = Auth::user()->getOwnerId();

        // Forcer date_recette avec date + heure actuelles
        $dateRecette = now();

        // Vérifier montant si paiement lié à une vente
        if ($request->vente_id) {
            $vente = Vente::where('user_id', $ownerId)
                ->with('paiements')
                ->findOrFail($request->vente_id);

            $totalPaye = $vente->paiements->sum('montant_paye');
            $resteAPayer = $vente->montant_total - $totalPaye;

            if ($request->montant > $resteAPayer) {
                return back()->with('error', 'Le montant dépasse le reste à payer (' . number_format($resteAPayer, 2) . ' GNF).')->withInput();
            }
        }

        DB::transaction(function () use ($request, $ownerId, $dateRecette) {
            // Créer la recette
            $recette = Recette::create([
                'libelle' => $request->libelle,
                'montant' => $request->montant,
                'date_recette' => $dateRecette, // Correction ici
                'caisse_id' => $request->caisse_id,
                'user_id' => $ownerId,
            ]);

            // Créditer la caisse
            $caisse = Caisse::find($request->caisse_id);
            $caisse->crediter($request->montant);

            // Si c'est un paiement de vente, créer le paiement associé
            if ($request->vente_id) {
                Paiement::create([
                    'vente_id' => $request->vente_id,
                    'montant_paye' => $request->montant,
                    'date_paiement' => $dateRecette, // Correction ici
                    'mode' => $request->mode ?? 'especes',
                    'caisse_id' => $request->caisse_id,
                ]);

                // Mettre à jour le statut de la vente
                $vente = Vente::with('paiements')->find($request->vente_id);
                $totalPaye = $vente->paiements->sum('montant_paye');

                if ($totalPaye >= $vente->montant_total) {
                    $vente->statut = 'payé';
                } elseif ($totalPaye > 0) {
                    $vente->statut = 'partiel';
                } else {
                    $vente->statut = 'en_cours';
                }
                $vente->save();
            }
        });

        $redirectRoute = $request->vente_id ? 'ventes.index' : 'recettes.index';
        return redirect()->route($redirectRoute)->with('success', 'Recette enregistrée avec succès.');
    }

    public function show(Recette $recette)
    {
        $recette->load('caisse', 'user');
        return view('comptabilite.recettes.show', compact('recette'));
    }

    public function edit(Recette $recette)
    {
        $caisses = Caisse::where('user_id', Auth::user()->getOwnerId())->orderBy('nom')->get();
        return view('comptabilite.recettes.edit', compact('recette', 'caisses'));
    }

    public function update(Request $request, Recette $recette)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0.01',
            'caisse_id' => 'required|exists:caisses,id',
        ]);

        // Annuler l'ancien crédit
        $ancienneCaisse = Caisse::find($recette->caisse_id);
        $ancienneCaisse->debiter($recette->montant);

        // Mettre à jour la recette
        $recette->update($request->only('libelle', 'montant', 'date_recette', 'caisse_id'));

        // Appliquer le nouveau crédit
        $nouvelleCaisse = Caisse::find($request->caisse_id);
        $nouvelleCaisse->crediter($request->montant);

        return redirect()->route('recettes.index')->with('success', 'Recette mise à jour avec succès.');
    }

    public function destroy(Recette $recette)
    {
        // Annuler le crédit
        $caisse = Caisse::find($recette->caisse_id);
        $caisse->debiter($recette->montant);

        $recette->delete();

        return redirect()->route('recettes.index')->with('success', 'Recette supprimée avec succès.');
    }
}

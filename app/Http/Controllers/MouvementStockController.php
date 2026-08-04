<?php

namespace App\Http\Controllers;

use App\Models\MouvementStock;
use App\Models\Produit;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MouvementStockController extends Controller
{
    /**
     * Display a listing of achats (mouvements de type 'entree' avec raison 'achat').
     */
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();
        $mouvements = MouvementStock::with('produit')
            ->whereHas('produit', fn($q) => $q->where('user_id', $ownerId))
            ->where('type_mouvement', 'entree')
            ->where('raison', 'achat')
            ->orderBy('date_mouvement', 'desc')
            ->paginate(10);

        return view('mouvemetstock.index', compact('mouvements'));
    }

    /**
     * Show the form for creating a new achat.
     */
    public function create()
    {
        $ownerId = Auth::user()->getOwnerId();
        $fournisseurs = Fournisseur::where('user_id', $ownerId)->orderBy('nom_fournisseur')->get();
        $produits = Produit::where('user_id', $ownerId)->orderBy('nom_produit')->get();

        return view('mouvemetstock.create', compact('fournisseurs', 'produits'));
    }

    /**
     * Store a newly created achat as mouvements de stock.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.produit_id' => 'required|exists:produits,id',
            'items.*.quantite' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $date = \Carbon\Carbon::parse($request->input('date'));

            foreach ($request->input('items') as $item) {
                MouvementStock::create([
                    'produit_id' => $item['produit_id'],
                    'type_mouvement' => 'entree',
                    'quantite' => (int) $item['quantite'],
                    'date_mouvement' => $date,
                    'raison' => 'achat',
                ]);
            }
        });

        return redirect()->route('mouvement.index')->with('success', 'Approvisionnement enregistré avec succès.');
    }

    /**
     * Display the specified mouvement.
     */
    public function show(MouvementStock $mouvement)
    {
        return view('mouvemetstock.show', compact('mouvement'));
    }

    /**
     * Show the form for editing the specified mouvement.
     */
    public function edit(MouvementStock $mouvement)
    {
        // Peut-être pas nécessaire pour achats, mais pour complétude
        return view('mouvemetstock.edit', compact('mouvement'));
    }

    /**
     * Update the specified mouvement in storage.
     */
    public function update(Request $request, MouvementStock $mouvement)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'type_mouvement' => 'required|in:entree,sortie',
            'quantite' => 'required|integer|min:1',
            'raison' => 'required|in:achat,vente,retour',
            'date_mouvement' => 'required|date',
        ]);

        $mouvement->update($request->all());

        return redirect()->route('mouvement.index')->with('success', 'Mouvement mis à jour.');
    }

    /**
     * Remove the specified mouvement from storage.
     */
    public function destroy(MouvementStock $mouvement)
    {
        $mouvement->delete();

        return redirect()->route('mouvement.index')->with('success', 'Mouvement supprimé.');
    }
}

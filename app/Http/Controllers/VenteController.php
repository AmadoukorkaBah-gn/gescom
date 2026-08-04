<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\DetailVente;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\MouvementStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class VenteController extends Controller
{
    public function index()
    {
        $ownerId = Auth::user()->getOwnerId();
        $ventes = Vente::where('user_id', $ownerId)
            ->with('client')
            ->orderBy('date_vente', 'desc')
            ->paginate(10);
        return view('ventes.index', compact('ventes'));
    }

    public function create()
    {
        $ownerId = Auth::user()->getOwnerId();
        $clients = Client::where('user_id', $ownerId)->orderBy('nom_client')->get();
        $produits = Produit::where('user_id', $ownerId)->orderBy('nom_produit')->get();
        return view('ventes.create', compact('clients', 'produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array|min:1',
            'items.*.produit_id' => 'required|exists:produits,id',
            'items.*.quantite' => 'required|integer|min:1',
            'items.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Prendre la date_vente avec l'heure actuelle
                $dateVente = now(); // date + heure actuelles

                $vente = Vente::create([
                    'user_id' => Auth::user()->getOwnerId(),
                    'client_id' => $request->client_id,
                    'date_vente' => $dateVente, // Correction ici
                    'montant_total' => collect($request->items)->sum(fn($i) => $i['quantite'] * $i['prix_unitaire']),
                    'statut' => 'en_cours',
                ]);

                foreach ($request->items as $item) {
                    $produit = Produit::findOrFail($item['produit_id']);
                    $quantiteVente = $item['quantite'];

                    // Récupérer les stocks disponibles (FIFO)
                    $stocks = Stock::where('produit_id', $produit->id)
                        ->where('quantite', '>', 0)
                        ->where(function($q){
                            $q->whereNull('date_peremption')
                              ->orWhere('date_peremption', '>=', now());
                        })
                        ->orderBy('date_entree')
                        ->lockForUpdate()
                        ->get();

                    $quantiteRestante = $quantiteVente;

                    foreach ($stocks as $stock) {
                        if ($quantiteRestante <= 0) break;

                        $decrement = min($quantiteRestante, $stock->quantite);

                        // Décrémenter le stock
                        $stock->quantite -= $decrement;
                        $stock->save();

                        // Créer un mouvement de stock
                        MouvementStock::create([
                            'produit_id' => $produit->id,
                            'type_mouvement' => 'sortie',
                            'quantite' => $decrement,
                            'date_mouvement' => $dateVente, // Correction ici
                            'raison' => 'vente',
                        ]);

                        $quantiteRestante -= $decrement;
                    }

                    if ($quantiteRestante > 0) {
                        throw new \Exception("Stock insuffisant pour le produit {$produit->nom_produit}");
                    }

                    // Créer le détail de vente
                    DetailVente::create([
                        'vente_id' => $vente->id,
                        'produit_id' => $produit->id,
                        'quantite' => $quantiteVente,
                        'prix_unitaire' => $item['prix_unitaire'],
                    ]);
                }
            });

            return redirect()->route('ventes.index')->with('success', 'Vente enregistrée et stock mis à jour.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Vente $vente)
    {
        $vente->load('client', 'details.produit');
        return view('ventes.show', compact('vente'));
    }

    public function edit(Vente $vente)
    {
        $clients = Client::orderBy('nom_client')->get();
        $produits = Produit::orderBy('nom_produit')->get();
        $vente->load('details');
        return view('ventes.edit', compact('vente', 'clients', 'produits'));
    }

    public function destroy(Vente $vente)
    {
        if ($vente->statut !== 'en_cours') {
            return back()->with('error', 'Impossible de supprimer une vente déjà traitée.');
        }
        $vente->delete();
        return redirect()->route('ventes.index')->with('success', 'Vente supprimée.');
    }

    public function showProcessForm(Vente $vente)
    {
        $vente->load('details.produit');
        return view('ventes.process', compact('vente'));
    }

    public function process(Request $request, Vente $vente)
    {
        if ($vente->statut !== 'en_cours') {
            return back()->with('error', 'Vente déjà traitée.');
        }

        DB::transaction(function () use ($vente) {
            foreach ($vente->details as $detail) {
                $quantiteRestante = $detail->quantite;

                $stocks = Stock::where('produit_id', $detail->produit_id)
                    ->where('quantite', '>', 0)
                    ->orderBy('date_entree')
                    ->lockForUpdate()
                    ->get();

                foreach ($stocks as $stock) {
                    if ($quantiteRestante <= 0) break;

                    $decrement = min($quantiteRestante, $stock->quantite);
                    $stock->quantite -= $decrement;
                    $stock->save();

                    MouvementStock::create([
                        'produit_id' => $detail->produit_id,
                        'type_mouvement' => 'sortie',
                        'quantite' => $decrement,
                        'date_mouvement' => $vente->date_vente, // garde la date_vente complète
                        'raison' => 'vente',
                    ]);

                    $quantiteRestante -= $decrement;
                }

                if ($quantiteRestante > 0) {
                    throw new \Exception("Stock insuffisant pour le produit {$detail->produit->nom_produit}");
                }
            }

            $vente->update(['statut' => 'traitee']);
        });

        return redirect()->route('paiement.create', ['vente_id' => $vente->id]);
    }

    public function receipt(Vente $vente)
    {
        $vente->load('client', 'details.produit');
        $pdf = Pdf::loadView('receipts.receipt', compact('vente'));
        return $pdf->download('receipt_' . $vente->id . '_' . now()->format('Y-m-d') . '.pdf');
    }
}

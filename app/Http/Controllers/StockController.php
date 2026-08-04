<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\MouvementStock;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    // Liste des produits avec stock réel
    public function index(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();
        $query = Produit::where('user_id', $ownerId)->with(['categorie', 'fournisseur', 'stocks']);

        if ($request->filled('search')) {
            $query->where('nom_produit', 'like', "%{$request->search}%");
        }

        $produits = $query->orderByDesc('statut')
                          ->orderBy('nom_produit')
                          ->paginate(10);

        // Ajouter le stock actuel à chaque produit
        $produits->getCollection()->transform(function ($produit) {
            $produit->stock_actuel = $produit->stockActuel();
            return $produit;
        });

        // Statistiques
        $totalProduits = Produit::where('user_id', $ownerId)->count();
        $produitsEnStock = $produits->getCollection()->where('stock_actuel', '>', 0)->count();
        $produitsRupture = $produits->getCollection()->where('stock_actuel', '<=', 0)->count();
        $produitsStockBas = $produits->getCollection()->filter(fn($p) => $p->stock_actuel < $p->stock_minimum)->count();

        return view('stocks.index', compact('produits', 'totalProduits', 'produitsEnStock', 'produitsRupture', 'produitsStockBas'));
    }

    // Mouvements de stock
    public function mouvements(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();
        $query = MouvementStock::with('produit')
            ->whereHas('produit', fn($q) => $q->where('user_id', $ownerId));

        if ($request->filled('produit_id')) {
            $query->where('produit_id', $request->produit_id);
        }

        if ($request->filled('type')) {
            $query->where('type_mouvement', $request->type);
        }

        $mouvements = $query->orderBy('date_mouvement', 'desc')->paginate(20);
        $produits = Produit::where('user_id', $ownerId)->orderBy('nom_produit')->get();

        $totalProduits = Produit::where('user_id', $ownerId)->count();
        $produitsEnStock = Produit::where('user_id', $ownerId)->get()->filter(fn($p) => $p->stockActuel() > 0)->count();

        return view('stocks.mouvements', compact('mouvements', 'produits', 'totalProduits', 'produitsEnStock'));
    }
}

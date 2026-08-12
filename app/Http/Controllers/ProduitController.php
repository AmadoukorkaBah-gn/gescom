<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduitRequest;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();
        $query = Produit::where('user_id', $ownerId)->with(['categorie', 'fournisseur']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nom_produit', 'like', "%{$search}%");
        }

        $produits = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('produits.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ownerId = Auth::user()->getOwnerId();
        $categories = Categorie::where('user_id', $ownerId)->orderBy('nom_categorie')->get();
        $fournisseurs = Fournisseur::where('user_id', $ownerId)->orderBy('nom_fournisseur')->get();

        return view('produits.create', compact('categories', 'fournisseurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(ProduitRequest $request)
{
    $data = $request->validated();
    $data['user_id'] = Auth::user()->getOwnerId();

$quantiteInitiale = (int) ($data['quantite_initiale'] ?? 0);
$datePeremption = $data['date_peremption'] ?? null;

unset($data['quantite_initiale'], $data['date_peremption']);

$produit = Produit::create($data);

if ($quantiteInitiale > 0) {
    $produit->incrementStock(
        $quantiteInitiale,
        'stock_initial',
        $datePeremption
    );
}

    return redirect()->route('produits.index')->with('success', 'Produit créé avec succès.');
}

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        $ownerId = Auth::user()->getOwnerId();
        $categories = Categorie::where('user_id', $ownerId)->orderBy('nom_categorie')->get();
        $fournisseurs = Fournisseur::where('user_id', $ownerId)->orderBy('nom_fournisseur')->get();

        return view('produits.edit', compact('produit', 'categories', 'fournisseurs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProduitRequest $request, Produit $produit)
    {
        $data = $request->validated();
        $produit->update($data);

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprimé.');
    }
}

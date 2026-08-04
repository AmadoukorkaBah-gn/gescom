@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Détails du Produit</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>Nom:</strong> {{ $produit->nom_produit }}
            </div>
            <div>
                <strong>Catégorie:</strong> {{ $produit->categorie->nom_categorie ?? '-' }}
            </div>
            <div>
                <strong>Fournisseur:</strong> {{ $produit->fournisseur->nom_fournisseur ?? '-' }}
            </div>
            <div>
                <strong>Prix d'achat:</strong> {{ number_format($produit->prix_produit, 2) }} €
            </div>
            <div>
                <strong>Prix de vente:</strong> {{ number_format($produit->prix_vente, 2) }} €
            </div>
            <div>
                <strong>Stock actuel:</strong> {{ $produit->stock }}
            </div>
            <div>
                <strong>Stock minimum:</strong> {{ $produit->stock_minimum }}
            </div>
            <div>
                <strong>Statut:</strong> {{ $produit->statut ? 'Actif' : 'Inactif' }}
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('produits.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
            <a href="{{ route('produits.edit', $produit) }}" class="ml-4 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Modifier
            </a>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Ajouter un produit</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produits.store') }}" method="POST" class="bg-white p-4 shadow rounded">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="nom_produit" class="block text-sm font-medium text-gray-700">Nom du produit</label>
                <input type="text" name="nom_produit" id="nom_produit" value="{{ old('nom_produit') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="categorie_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                <select name="categorie_id" id="categorie_id" class="mt-1 block w-full border rounded px-3 py-2" required>
                    <option value="">-- Choisir --</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>{{ $categorie->nom_categorie }}</option>
                    @endforeach
                </select>
            </div>

            <div>
    <label for="fournisseur_id" class="block text-sm font-medium text-gray-700">Fournisseur (optionnel)</label>
    <select name="fournisseur_id" id="fournisseur_id" class="mt-1 block w-full border rounded px-3 py-2">
        <option value="">-- Aucun fournisseur --</option>
        @foreach($fournisseurs as $fournisseur)
            <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>{{ $fournisseur->nom_fournisseur }}</option>
        @endforeach
    </select>
</div>

<div>
    <label for="quantite_initiale" class="block text-sm font-medium text-gray-700">Quantité en stock (optionnel)</label>
    <input type="number" name="quantite_initiale" id="quantite_initiale" min="0" value="{{ old('quantite_initiale', 0) }}" class="mt-1 block w-full border rounded px-3 py-2">
    <p class="text-xs text-gray-500 mt-1">Laisse à 0 si tu comptes plutôt passer par un achat fournisseur.</p>
</div>

            <div>
                <label for="prix_produit" class="block text-sm font-medium text-gray-700">Prix d'achat</label>
                <input type="number" step="0.01" name="prix_produit" id="prix_produit" value="{{ old('prix_produit') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="prix_vente" class="block text-sm font-medium text-gray-700">Prix de vente</label>
                <input type="number" step="0.01" name="prix_vente" id="prix_vente" value="{{ old('prix_vente') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="stock_minimum" class="block text-sm font-medium text-gray-700">Stock minimum</label>
                <input type="number" name="stock_minimum" id="stock_minimum" value="{{ old('stock_minimum', 0) }}" class="mt-1 block w-full border rounded px-3 py-2">
            </div>

           <div>
        <label class="block font-medium">Statut</label>
        <select name="statut" required class="border rounded w-full p-2">
    <option value="1">Actif</option>
    <option value="0">Inactif</option>
</select>

    </div>
        </div>

        <div class="mt-4 flex items-center gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
            <a href="{{ route('produits.index') }}" class="text-gray-600">Annuler</a>
        </div>
    </form>
</div>
@endsection

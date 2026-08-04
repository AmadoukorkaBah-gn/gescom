@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Produit</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form method="POST" action="{{ route('produits.update', $produit) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nom_produit" class="block text-sm font-medium text-gray-700">Nom du Produit</label>
                    <input type="text" name="nom_produit" id="nom_produit" value="{{ old('nom_produit', $produit->nom_produit) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('nom_produit')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="categorie_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select name="categorie_id" id="categorie_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ old('categorie_id', $produit->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom_categorie }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fournisseur_id" class="block text-sm font-medium text-gray-700">Fournisseur</label>
                    <select name="fournisseur_id" id="fournisseur_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Sélectionner un fournisseur</option>
                        @foreach($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id', $produit->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>
                                {{ $fournisseur->nom_fournisseur }}
                            </option>
                        @endforeach
                    </select>
                    @error('fournisseur_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="prix_produit" class="block text-sm font-medium text-gray-700">Prix d'Achat</label>
                    <input type="number" step="0.01" name="prix_produit" id="prix_produit" value="{{ old('prix_produit', $produit->prix_produit) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('prix_produit')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="prix_vente" class="block text-sm font-medium text-gray-700">Prix de Vente</label>
                    <input type="number" step="0.01" name="prix_vente" id="prix_vente" value="{{ old('prix_vente', $produit->prix_vente) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('prix_vente')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock_minimum" class="block text-sm font-medium text-gray-700">Stock Minimum</label>
                    <input type="number" name="stock_minimum" id="stock_minimum" value="{{ old('stock_minimum', $produit->stock_minimum) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('stock_minimum')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="statut" id="statut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="actif" {{ old('statut', $produit->statut ? 'actif' : 'inactif') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ old('statut', $produit->statut ? 'actif' : 'inactif') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('statut')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Mettre à jour
                </button>
                <a href="{{ route('produits.index') }}" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

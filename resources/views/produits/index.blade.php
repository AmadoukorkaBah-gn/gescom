@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Produits</h1>
        <a href="{{ route('produits.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajouter un Produit
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @php
        $lowStockProducts = $produits->filter(function($produit) {
            return $produit->stockActuel() < $produit->stock_minimum;
        });
    @endphp

    @if($lowStockProducts->count() > 0)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Alerte Stock Bas:</strong> {{ $lowStockProducts->count() }} produit(s) en rupture de stock.
            <a href="#low-stock" class="underline">Voir les produits concernés</a>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <div class="p-4 border-b">
            <form method="GET" action="{{ route('produits.index') }}" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom..." class="flex-1 border border-gray-300 rounded px-3 py-2">
                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Rechercher</button>
            </form>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <!-- En-tête -->
            <thead class="bg-orange-500">
                <tr>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">N°</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Nom</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Catégorie</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Fournisseur</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Prix Achat</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Prix Vente</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Stock</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Stock Min</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Statut</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <!-- Corps du tableau -->
            <tbody class="bg-white divide-y divide-gray-200 text-gray-900 font-bold">
                @forelse($produits as $produit)
                @php $stockActuel = $produit->stockActuel(); @endphp
                <tr class="{{ $stockActuel < $produit->stock_minimum ? 'bg-red-50' : '' }}">
                    <td class="px-2 py-2 text-xs">{{ $loop->iteration }}</td>
                    <td class="px-2 py-2 text-xs">{{ $produit->nom_produit }}</td>
                    <td class="px-2 py-2 text-xs">{{ $produit->categorie->nom_categorie ?? '-' }}</td>
                    <td class="px-2 py-2 text-xs">{{ $produit->fournisseur->nom_fournisseur ?? '-' }}</td>
                    <td class="px-2 py-2 text-xs">{{ number_format($produit->prix_produit, 2) }} GNF</td>
                    <td class="px-2 py-2 text-xs">{{ number_format($produit->prix_vente, 2) }} GNF</td>
                    <td class="px-2 py-2 text-xs {{ $stockActuel < $produit->stock_minimum ? 'text-red-600' : '' }}">
                        {{ $stockActuel }}
                    </td>
                    <td class="px-2 py-2 text-xs">{{ $produit->stock_minimum }}</td>
                    <td class="px-2 py-2 text-xs">
                        <span class="px-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $produit->statut ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $produit->statut ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>

                    <!-- Actions avec icônes -->
                    <td class="px-2 py-2 text-xs">
                        <div class="flex gap-1">
                            <!-- Voir -->
                            <a href="{{ route('produits.show', $produit) }}" class="bg-indigo-100 text-indigo-800 p-1 rounded hover:bg-indigo-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <!-- Modifier -->
                            <a href="{{ route('produits.edit', $produit) }}" class="bg-yellow-100 text-yellow-800 p-1 rounded hover:bg-yellow-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13.5V15h1.5l7.5-7.5-1.5-1.5L9 13.5z" />
                                </svg>
                            </a>

                            <!-- Supprimer -->
                            <form method="POST" action="{{ route('produits.destroy', $produit) }}" onsubmit="return confirm('Êtes-vous sûr ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-800 p-1 rounded hover:bg-red-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 2h4a1 1 0 011 1v1H9V3a1 1 0 011-1z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-2 py-2 text-center text-gray-500 text-xs">Aucun produit trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3 bg-gray-50 border-t">
            {{ $produits->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

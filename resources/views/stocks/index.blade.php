@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion du Stock</h1>
        <a href="{{ route('stocks.mouvements') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Voir Mouvements
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <div class="text-2xl font-bold text-gray-800">{{ $totalProduits }}</div>
                <div class="ml-4">
                    <div class="text-sm text-gray-500">Total Produits</div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <div class="text-2xl font-bold text-green-600">{{ $produitsEnStock }}</div>
                <div class="ml-4">
                    <div class="text-sm text-gray-500">En Stock</div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $produitsRupture }}</div>
                <div class="ml-4">
                    <div class="text-sm text-gray-500">En Rupture</div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <div class="text-2xl font-bold text-red-600">{{ $produitsStockBas }}</div>
                <div class="ml-4">
                    <div class="text-sm text-gray-500">Stock Bas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtre recherche -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-4">
        <div class="p-4 border-b">
            <form method="GET" action="{{ route('stocks.index') }}" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom..." class="flex-1 border border-gray-300 rounded px-3 py-2">
                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Rechercher</button>
            </form>
        </div>
    </div>

    <!-- Tableau produits -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fournisseur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Actuel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Minimum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">État</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($produits as $produit)
                <tr class="{{ $produit->stock_actuel < $produit->stock_minimum ? 'bg-red-50' : ($produit->stock_actuel == 0 ? 'bg-yellow-50' : '') }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $produit->nom_produit }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $produit->categorie->nom_categorie ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $produit->fournisseur->nom_fournisseur ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ $produit->stock_actuel < $produit->stock_minimum ? 'text-red-600 font-bold' : '' }}">
                        {{ $produit->stock_actuel }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $produit->stock_minimum }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($produit->stock_actuel == 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Rupture</span>
                        @elseif($produit->stock_actuel < $produit->stock_minimum)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Stock Bas</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">OK</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('produits.show', $produit) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Voir</a>
                        <a href="{{ route('produits.edit', $produit) }}" class="text-yellow-600 hover:text-yellow-900">Modifier</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Aucun produit trouvé.</td>
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

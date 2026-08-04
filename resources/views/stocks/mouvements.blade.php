@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-gray-800">{{ $totalProduits ?? 0 }}</div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-500">Total Produits</div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-green-600">{{ $produitsEnStock ?? 0 }}</div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-500">En Stock</div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $produitsRupture ?? 0 }}</div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-500">En Rupture</div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-red-600">{{ $produitsStockBas ?? 0 }}</div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-500">Stock Bas</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="mb-6">
            <form method="GET" class="flex gap-4">
                <select name="produit_id" class="border rounded px-3 py-2">
                    <option value="">Tous les produits</option>
                    @foreach($produits as $produit)
                        <option value="{{ $produit->id }}" {{ request('produit_id') == $produit->id ? 'selected' : '' }}>
                            {{ $produit->nom_produit }}
                        </option>
                    @endforeach
                </select>

                <select name="type" class="border rounded px-3 py-2">
                    <option value="">Tous les types</option>
                    <option value="entree" {{ request('type') == 'entree' ? 'selected' : '' }}>Entrée</option>
                    <option value="sortie" {{ request('type') == 'sortie' ? 'selected' : '' }}>Sortie</option>
                </select>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filtrer</button>
            </form>
        </div>

        <!-- Mouvements Table -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Produit</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Type</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Quantité</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Date</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Raison</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mouvements as $mouvement)
                        <tr>
                            <td class="px-4 py-2">{{ $mouvement->produit->nom_produit ?? '-' }}</td>
                            <td class="px-4 py-2">{{ ucfirst($mouvement->type_mouvement) }}</td>
                            <td class="px-4 py-2">{{ $mouvement->quantite }}</td>
                            <td class="px-4 py-2">{{ $mouvement->date_mouvement->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $mouvement->raison }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-500">Aucun mouvement trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $mouvements->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📆 Ventes par Période</h1>

    <!-- Filtres -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                <input type="date" name="date_debut" value="{{ $dateDebut }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                <input type="date" name="date_fin" value="{{ $dateFin }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    🔍 Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg rounded-lg p-6">
            <div class="text-sm opacity-90">Total des ventes</div>
            <div class="text-3xl font-bold">{{ $totalVentes }}</div>
            <div class="text-xs opacity-75 mt-2">Ventes réalisées</div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg rounded-lg p-6">
            <div class="text-sm opacity-90">Montant total</div>
            <div class="text-3xl font-bold">{{ number_format($totalMontant, 2, ',', ' ') }} GNF</div>
            <div class="text-xs opacity-75 mt-2">Chiffre d'affaires</div>
        </div>
    </div>

    <!-- Tableau des ventes -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de ventes</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant moyen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($ventes as $vente)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($vente['date'])->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $vente['nombre_ventes'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            {{ number_format($vente['total_montant'], 2, ',', ' ') }} GNF
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ number_format($vente['total_montant'] / $vente['nombre_ventes'], 2, ',', ' ') }} GNF
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Aucune vente trouvée pour cette période.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('rapports.ventes-par-periode') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            ↺ Réinitialiser les filtres
        </a>
    </div>
</div>
@endsection

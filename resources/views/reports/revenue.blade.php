@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">💰 Chiffre d'Affaires</h1>

    <!-- Filtres de période -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form method="GET" class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Période</label>
                <select name="periode" onchange="this.form.submit()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="daily" {{ $periode === 'daily' ? 'selected' : '' }}>📅 Quotidien (30 derniers jours)</option>
                    <option value="weekly" {{ $periode === 'weekly' ? 'selected' : '' }}>📊 Hebdomadaire (12 dernières semaines)</option>
                    <option value="monthly" {{ $periode === 'monthly' ? 'selected' : '' }}>📈 Mensuel (12 derniers mois)</option>
                    <option value="yearly" {{ $periode === 'yearly' ? 'selected' : '' }}>📉 Annuel (5 dernières années)</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg rounded-lg p-6">
            <div class="text-sm opacity-90">Chiffre d'affaires total</div>
            <div class="text-4xl font-bold">{{ number_format($totalRevenue, 0, ',', ' ') }} GNF</div>
            <div class="text-xs opacity-75 mt-2">Période sélectionnée</div>
        </div>
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 text-white shadow-lg rounded-lg p-6">
            <div class="text-sm opacity-90">Moyenne par période</div>
            <div class="text-4xl font-bold">{{ number_format($averageRevenue, 0, ',', ' ') }} GNF</div>
            <div class="text-xs opacity-75 mt-2">
                @switch($periode)
                    @case('daily') Par jour @break
                    @case('weekly') Par semaine @break
                    @case('monthly') Par mois @break
                    @case('yearly') Par année @break
                @endswitch
            </div>
        </div>
    </div>

    <!-- Graphique en barres simple (tableau alternatif) -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Évolution du CA</h2>
        
        @if(count($data) > 0)
            <div class="space-y-3">
                @php
                    $maxValue = collect($data)->max('total');
                @endphp
                @foreach($data as $item)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ $item['label'] }}</span>
                            <span class="text-sm font-semibold text-gray-900">
                                {{ number_format($item['total'], 0, ',', ' ') }} GNF ({{ $item['nombre'] }} ventes)
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-6">
                            <div 
                                class="bg-gradient-to-r from-blue-500 to-blue-600 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold"
                               @php
    $total = (float) $item['total'];
    $max   = max((float) $maxValue, 1);   // empêche division par zéro
    $percent = ($total / $max) * 100;
@endphp

       <div
       class="h-4 bg-blue-600 rounded"
    @style(['width' => $percent . '%'])
></div>

                            >
                                @if(($item['total'] / $maxValue) * 100 > 30)
                                    {{ round(($item['total'] / $maxValue) * 100) }}%
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                Aucune donnée disponible pour cette période.
            </div>
        @endif
    </div>

    <!-- Tableau détaillé -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CA</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de ventes</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CA moyen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($data as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item['label'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                            {{ number_format($item['total'], 0, ',', ' ') }} GNF
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                {{ $item['nombre'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ number_format($item['total'] / $item['nombre'], 0, ',', ' ') }} GNF
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Aucune donnée disponible.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

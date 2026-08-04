@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🔥 Produits les Plus Vendus</h1>

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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de produits</label>
                <select name="limite" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="5" {{ $limite == 5 ? 'selected' : '' }}>Top 5</option>
                    <option value="10" {{ $limite == 10 ? 'selected' : '' }}>Top 10</option>
                    <option value="20" {{ $limite == 20 ? 'selected' : '' }}>Top 20</option>
                    <option value="50" {{ $limite == 50 ? 'selected' : '' }}>Top 50</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    🔍 Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Tableau -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité vendue</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre de ventes</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Chiffre d'affaires</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($produits as $index => $produit)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @switch($index + 1)
                                @case(1) 🥇 @break
                                @case(2) 🥈 @break
                                @case(3) 🥉 @break
                                @default #{{ $index + 1 }}
                            @endswitch
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $produit['nom_produit'] }}</td>
                        <td class="px-6 py-4">{{ $produit['total_quantite'] }}</td>
                        <td class="px-6 py-4">{{ $produit['nombre_ventes'] }}</td>
                        <td class="px-6 py-4 font-semibold text-green-600">
                            {{ number_format($produit['chiffre_affaires'], 0, ',', ' ') }} GNF
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Aucun produit vendu sur cette période.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Graphique -->
@if(count($produits) > 0)
    <div class="bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Visualisation des quantités vendues</h2>

        @php
            $maxQty = collect($produits)->max('total_quantite');
        @endphp

        <div class="space-y-4">
            @foreach($produits as $produit)

                @php
                    // Calcul sécurisé
                    $qty = (float) $produit['total_quantite'];
                    $max = max((float) $maxQty, 1);
                    $percent = ($qty / $max) * 100;

                    // Style inline sans Blade dans l'attribut
                    $widthStyle = 'width:' . $percent . '%;';

                    // Couleur dynamique
                    if ($percent >= 70) {
                        $color = 'from-green-500 to-green-600';
                    } elseif ($percent >= 40) {
                        $color = 'from-yellow-500 to-yellow-600';
                    } else {
                        $color = 'from-red-500 to-red-600';
                    }
                @endphp

                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">
                            {{ substr($produit['nom_produit'], 0, 30) }}
                        </span>
                        <span class="text-sm font-semibold text-gray-900">
                            {{ $produit['total_quantite'] }} unités
                        </span>
                    </div>

                   <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">

    @php
        $qty = (float) $produit['total_quantite'];
        $max = max((float)$maxQty, 1);
        $percent = ($qty / $max) * 100;
        $widthStyle = 'width:' . $percent . '%;';
    @endphp

    <div 
        class="h-6 rounded-full flex items-center justify-center text-white text-xs font-bold bg-gradient-to-r {{ $color }} transition-all duration-700"
       @style(['width' => $percent . '%'])

    >

                            @if($percent > 30)
                                {{ round($percent) }}%
                            @endif
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endif

</div>
@endsection

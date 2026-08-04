@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Caisse: {{ $caisse->nom }}</h1>
        <a href="{{ route('caisses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Retour
        </a>
    </div>

    <!-- Solde actuel -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="text-center">
            <p class="text-gray-600 mb-2">Solde actuel</p>
            <p class="text-4xl font-bold {{ $caisse->solde >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($caisse->solde, 2) }} GNF
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Dernières recettes -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <span class="text-green-500 mr-2">📈</span> Dernières Recettes
            </h2>
            @forelse($caisse->recettes as $recette)
            <div class="border-b py-2 flex justify-between">
                <div>
                    <p class="font-medium">{{ $recette->libelle }}</p>
                   <p class="text-sm text-gray-500">
    {{ $recette->date_recette->format('d/m/Y à H:i') }}
</p>

                </div>
                <span class="text-green-600 font-bold">+{{ number_format($recette->montant, 2) }}</span>
            </div>
            @empty
            <p class="text-gray-500">Aucune recette</p>
            @endforelse
        </div>

        <!-- Dernières dépenses -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <span class="text-red-500 mr-2">📉</span> Dernières Dépenses
            </h2>
            @forelse($caisse->depenses as $depense)
            <div class="border-b py-2 flex justify-between">
                <div>
                    <p class="font-medium">{{ $depense->libelle }}</p>
                    <p class="text-sm text-gray-500">{{ $depense->date_depense->format('d/m/Y à H:i') }}</p>
                </div>
                <span class="text-red-600 font-bold">-{{ number_format($depense->montant, 2) }}</span>
            </div>
            @empty
            <p class="text-gray-500">Aucune dépense</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des Dettes</h1>

    <!-- Résumé -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Dettes Clients -->
        <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Créances Clients</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($totalDettesClients, 0, ',', ' ') }} GNF</p>
                    <p class="text-sm text-gray-500">{{ $dettesClients->count() }} vente(s) en attente</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Argent que les clients vous doivent</p>
        </div>

        <!-- Dettes Fournisseurs -->
        <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Dettes Fournisseurs</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($totalDettesFournisseurs, 0, ',', ' ') }} GNF</p>
                    <p class="text-sm text-gray-500">{{ $dettesFournisseurs->count() }} achat(s) en attente</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Argent que vous devez aux fournisseurs</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Liste Dettes Clients -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-green-500 px-4 py-3">
                <h2 class="text-lg font-bold text-white">Créances Clients (À recevoir)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-600 uppercase">Client</th>
                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-600 uppercase">Date</th>
                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-600 uppercase">Total</th>
                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-600 uppercase">Payé</th>
                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-600 uppercase">Reste</th>
                            <th class="px-3 py-2 text-center text-xs font-bold text-gray-600 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($dettesClients as $vente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-sm font-medium">{{ $vente->client->nom_client ?? 'Client inconnu' }}</td>
                            <td class="px-3 py-2 text-sm text-gray-500">{{ $vente->date_vente->format('d/m/Y') }}</td>
                            <td class="px-3 py-2 text-sm text-right">{{ number_format($vente->montant_total, 0, ',', ' ') }}</td>
                            <td class="px-3 py-2 text-sm text-right text-green-600">{{ number_format($vente->total_paye, 0, ',', ' ') }}</td>
                            <td class="px-3 py-2 text-sm text-right font-bold text-red-600">{{ number_format($vente->reste_a_payer, 0, ',', ' ') }}</td>
                            <td class="px-3 py-2 text-center">
                                <a href="{{ route('recettes.create', ['vente_id' => $vente->id]) }}" 
                                   class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                    Encaisser
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Aucune créance client en attente
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($dettesClients->count() > 0)
            <div class="bg-gray-50 px-4 py-3 border-t">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total créances:</span>
                    <span class="text-lg font-bold text-green-600">{{ number_format($totalDettesClients, 0, ',', ' ') }} GNF</span>
                </div>
            </div>
            @endif
        </div>

        <!-- Liste Dettes Fournisseurs -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-red-500 px-4 py-3">
                <h2 class="text-lg font-bold text-white">Dettes Fournisseurs (À payer)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-600 uppercase">Fournisseur</th>
                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-600 uppercase">Date</th>
                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-600 uppercase">Total</th>
                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-600 uppercase">Payé</th>
                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-600 uppercase">Reste</th>
                            <th class="px-3 py-2 text-center text-xs font-bold text-gray-600 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($dettesFournisseurs as $achat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-sm font-medium">{{ $achat->fournisseur->nom_fournisseur ?? 'Fournisseur inconnu' }}</td>
                            <td class="px-3 py-2 text-sm text-gray-500">{{ $achat->date_achat->format('d/m/Y') }}</td>
                            <td class="px-3 py-2 text-sm text-right">{{ number_format($achat->total, 0, ',', ' ') }}</td>
                            <td class="px-3 py-2 text-sm text-right text-green-600">{{ number_format($achat->montant_paye, 0, ',', ' ') }}</td>
                            <td class="px-3 py-2 text-sm text-right font-bold text-red-600">{{ number_format($achat->reste_a_payer, 0, ',', ' ') }}</td>
                            <td class="px-3 py-2 text-center">
                                <a href="{{ route('depenses.create', ['achat_id' => $achat->id]) }}" 
                                   class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                    Payer
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Aucune dette fournisseur en attente
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($dettesFournisseurs->count() > 0)
            <div class="bg-gray-50 px-4 py-3 border-t">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total dettes:</span>
                    <span class="text-lg font-bold text-red-600">{{ number_format($totalDettesFournisseurs, 0, ',', ' ') }} GNF</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Résumé par client/fournisseur -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <!-- Résumé par Client -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-green-600 px-4 py-3">
                <h2 class="text-lg font-bold text-white">Résumé par Client</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Client</th>
                            <th class="px-4 py-2 text-center text-xs font-bold text-gray-600 uppercase">Nb Ventes</th>
                            <th class="px-4 py-2 text-right text-xs font-bold text-gray-600 uppercase">Total Dû</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $clientsGrouped = $dettesClients->groupBy('client_id');
                        @endphp
                        @forelse($clientsGrouped as $clientId => $ventes)
                        @php
                            $client = $ventes->first()->client;
                            $totalDu = $ventes->sum('reste_a_payer');
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm font-medium">{{ $client->nom_client ?? 'Client inconnu' }}</td>
                            <td class="px-4 py-2 text-sm text-center">{{ $ventes->count() }}</td>
                            <td class="px-4 py-2 text-sm text-right font-bold text-green-600">{{ number_format($totalDu, 0, ',', ' ') }} GNF</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500">Aucun client endetté</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Résumé par Fournisseur -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-red-600 px-4 py-3">
                <h2 class="text-lg font-bold text-white">Résumé par Fournisseur</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Fournisseur</th>
                            <th class="px-4 py-2 text-center text-xs font-bold text-gray-600 uppercase">Nb Achats</th>
                            <th class="px-4 py-2 text-right text-xs font-bold text-gray-600 uppercase">Total Dû</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $fournisseursGrouped = $dettesFournisseurs->groupBy('fournisseur_id');
                        @endphp
                        @forelse($fournisseursGrouped as $fournisseurId => $achats)
                        @php
                            $fournisseur = $achats->first()->fournisseur;
                            $totalDu = $achats->sum('reste_a_payer');
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm font-medium">{{ $fournisseur->nom_fournisseur ?? 'Fournisseur inconnu' }}</td>
                            <td class="px-4 py-2 text-sm text-center">{{ $achats->count() }}</td>
                            <td class="px-4 py-2 text-sm text-right font-bold text-red-600">{{ number_format($totalDu, 0, ',', ' ') }} GNF</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500">Aucune dette fournisseur</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Solde Net -->
    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Solde Net (Créances - Dettes)</p>
                @php
                    $soldeNet = $totalDettesClients - $totalDettesFournisseurs;
                @endphp
                <p class="text-3xl font-bold {{ $soldeNet >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $soldeNet >= 0 ? '+' : '' }}{{ number_format($soldeNet, 0, ',', ' ') }} GNF
                </p>
            </div>
            <div class="{{ $soldeNet >= 0 ? 'bg-green-100' : 'bg-red-100' }} p-4 rounded-full">
                @if($soldeNet >= 0)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                </svg>
                @endif
            </div>
        </div>
        <p class="text-sm text-gray-400 mt-2">
            @if($soldeNet >= 0)
                Vous avez plus de créances que de dettes
            @else
                Vous devez plus que ce qu'on vous doit
            @endif
        </p>
    </div>
</div>
@endsection

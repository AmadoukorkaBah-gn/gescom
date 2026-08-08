@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Ventes</h1>
        <div class="flex gap-2 mb-4">
    <a href="{{ route('ventes.export.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
        Export PDF
    </a>
    <a href="{{ route('ventes.export.excel') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
        Export Excel
    </a>
</div>
        <a href="{{ route('ventes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nouvelle Vente
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <!-- En-tête orange -->
            <thead class="bg-orange-500">
                <tr>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">N°</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Client</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Date</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Total</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Statut</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <!-- Corps du tableau -->
            <tbody class="bg-white divide-y divide-gray-200 text-gray-900 font-bold">
                @foreach($ventes as $vente)
                <tr class="border-t">
                    <td class="px-2 py-2 text-xs">{{ $loop->iteration }}</td>
                    <td class="px-2 py-2 text-xs">{{ $vente->client->nom_client ?? '-' }}</td>
                    <td class="px-2 py-2 text-xs">{{ $vente->date_vente->format('Y-m-d') }}</td>
                    <td class="px-2 py-2 text-xs">{{ number_format($vente->montant_total, 2) }} GNF</td>
                    <td class="px-2 py-2 text-xs">
                        <span class="px-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($vente->statut == 'payé') bg-green-100 text-green-800
                            @elseif($vente->statut == 'partiel') bg-orange-100 text-orange-800
                            @elseif($vente->statut == 'en_cours') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            @if($vente->statut == 'en_cours')
                                Crédit
                            @elseif($vente->statut == 'payé')
                                Payé
                            @elseif($vente->statut == 'partiel')
                                Partiel
                            @else
                                {{ ucfirst($vente->statut) }}
                            @endif
                        </span>
                    </td>

                    <!-- Actions avec icônes -->
                    <td class="px-2 py-2 text-xs">
                        <div class="flex gap-1 items-center">
                            <!-- Voir (œil) -->
                            <a href="{{ route('ventes.show', $vente) }}" class="bg-blue-100 text-blue-800 p-1 rounded hover:bg-blue-200" title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <!-- Reçu / Imprimante -->
                            <a href="{{ route('ventes.receipt', $vente) }}" class="bg-indigo-100 text-indigo-800 p-1 rounded hover:bg-indigo-200" title="Imprimer le reçu">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 22h12v-7H6v7zM6 14h12v3H6v-3z" />
                                </svg>
                            </a>

                            @if($vente->statut == 'en_cours' || $vente->statut == 'partiel')
                                <!-- Paiement -->
                                <a href="{{ route('recettes.create', ['vente_id' => $vente->id]) }}" class="bg-green-100 text-green-800 p-1 rounded hover:bg-green-200" title="Encaisser">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2 0-4 1-4 3s2 3 4 3 4-1 4-3-2-3-4-3zm0 6v6" />
                                    </svg>
                                </a>
                            @endif

                            @if($vente->statut == 'en_cours')
                                <!-- Modifier (crayon) -->
                                <a href="{{ route('ventes.edit', $vente) }}" class="bg-yellow-100 text-yellow-800 p-1 rounded hover:bg-yellow-200" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13.5V15h1.5l7.5-7.5-1.5-1.5L9 13.5z" />
                                    </svg>
                                </a>

                                <!-- Supprimer (poubelle) -->
                                <form action="{{ route('ventes.destroy', $vente) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette vente ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-800 p-1 rounded hover:bg-red-200" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 2h4a1 1 0 011 1v1H9V3a1 1 0 011-1z" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $ventes->links() }}
        </div>
    </div>
</div>
@endsection

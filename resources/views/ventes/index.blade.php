@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-10">

    {{-- En-tête de page --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Ventes</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $ventes->total() ?? $ventes->count() }} vente(s) enregistrée(s)</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a
                href="{{ route('ventes.export.pdf') }}"
                class="inline-flex items-center gap-1.5 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 text-sm font-medium px-3.5 py-2 rounded-lg transition"
            >
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                </svg>
                PDF
            </a>

            <a
                href="{{ route('ventes.export.excel') }}"
                class="inline-flex items-center gap-1.5 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 text-sm font-medium px-3.5 py-2 rounded-lg transition"
            >
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                </svg>
                Excel
            </a>

            <a
                href="{{ route('ventes.create') }}"
                class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle vente
            </a>
        </div>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-2.5 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl mb-4">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-xl mb-4">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Tableau --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">N°</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Client</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Statut</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($ventes as $vente)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $vente->client->nom_client ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $vente->date_vente->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ number_format($vente->montant_total, 2) }} GNF</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full
                                @if($vente->statut == 'payé') bg-green-100 text-green-700
                                @elseif($vente->statut == 'partiel') bg-orange-100 text-orange-700
                                @elseif($vente->statut == 'en_cours') bg-yellow-100 text-yellow-700
                                @else bg-gray-100 text-gray-700 @endif">
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

                        <td class="px-4 py-3 text-sm">
                            <div class="flex justify-end gap-1.5">
                                <a href="{{ route('ventes.show', $vente) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition" title="Voir">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('ventes.receipt', $vente) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-indigo-600 hover:bg-indigo-50 transition" title="Imprimer le reçu">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 22h12v-7H6v7zM6 14h12v3H6v-3z" />
                                    </svg>
                                </a>

                                @if($vente->statut == 'en_cours' || $vente->statut == 'partiel')
                                    <a href="{{ route('recettes.create', ['vente_id' => $vente->id]) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-green-600 hover:bg-green-50 transition" title="Encaisser">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2 0-4 1-4 3s2 3 4 3 4-1 4-3-2-3-4-3zm0 6v6" />
                                        </svg>
                                    </a>
                                @endif

                                @if($vente->statut == 'en_cours')
                                    <a href="{{ route('ventes.edit', $vente) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-yellow-600 hover:bg-yellow-50 transition" title="Modifier">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13.5V15h1.5l7.5-7.5-1.5-1.5L9 13.5z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('ventes.destroy', $vente) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette vente ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 transition" title="Supprimer">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 2h4a1 1 0 011 1v1H9V3a1 1 0 011-1z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 2a1 1 0 00-1 1v1H6a2 2 0 00-2 2v13a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2V3a1 1 0 00-1-1H9z" />
                                </svg>
                                <p class="text-sm text-gray-500">Aucune vente enregistrée pour le moment</p>
                                <a href="{{ route('ventes.create') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 mt-1">Créer la première vente</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($ventes, 'links'))
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $ventes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
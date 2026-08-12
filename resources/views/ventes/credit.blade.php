{{-- resources/views/ventes/credit.blade.php --}}

@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 py-6">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">💳 Ventes à crédit</h1>
            <p class="mt-1 text-sm text-gray-500">Créances regroupées par client.</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('clients.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl
                      bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition">
                👤 <span>Ajouter un client</span>
            </a>

            <a href="{{ route('ventes.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl
                      bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm transition">
                ➕ <span>Nouvelle vente</span>
            </a>
        </div>
    </div>


    {{-- =====================================================
         STATISTIQUES GLOBALES
    ====================================================== --}}
    @php
        $toutesLesVentes    = $ventes->collapse();
        $nombreClients      = $ventes->count();
        $nombreVentesCredit = $toutesLesVentes->count();

        $totalCredit  = $toutesLesVentes->sum(fn ($v) => (float) $v->montant_total);
        $totalPaye    = $toutesLesVentes->sum(fn ($v) => (float) $v->paiements->sum('montant_paye'));
        $totalRestant = max($totalCredit - $totalPaye, 0);
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Clients débiteurs</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $nombreClients }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $nombreVentesCredit }} vente(s) à crédit</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-xl">👥</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Montant des ventes</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($totalCredit, 0, ',', ' ') }}
                        <span class="text-sm font-medium">GNF</span>
                    </p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center text-xl">🧾</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total restant</p>
                    <p class="mt-1 text-2xl font-bold text-red-600">
                        {{ number_format($totalRestant, 0, ',', ' ') }}
                        <span class="text-sm font-medium">GNF</span>
                    </p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-red-100 flex items-center justify-center text-xl">⚠️</div>
            </div>
        </div>

    </div>


    {{-- =====================================================
         MESSAGES
    ====================================================== --}}
    @if(session('success'))
        <div class="mb-5 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif


    {{-- =====================================================
         TABLEAU — une ligne par client
    ====================================================== --}}
    @if($ventes->count())

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Client</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Contact</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Ventes</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Payé</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Reste</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($ventes as $clientId => $ventesClient)

                            @php
                                $client = $ventesClient->first()->client;

                                $totalClient = $ventesClient->sum(fn ($v) => (float) $v->montant_total);
                                $payeClient  = $ventesClient->sum(fn ($v) => (float) $v->paiements->sum('montant_paye'));
                                $resteClient = max($totalClient - $payeClient, 0);

                                $rowId = 'client-detail-' . ($clientId ?? 'null');
                            @endphp

                            {{-- ============ LIGNE CLIENT ============ --}}
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                    {{ $client?->nom_client ?? 'Client non renseigné' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    {{ $client?->contact_client ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">
                                    {{ $ventesClient->count() }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">
                                    {{ number_format($totalClient, 0, ',', ' ') }} GNF
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-green-600 text-right">
                                    {{ number_format($payeClient, 0, ',', ' ') }} GNF
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-red-600 text-right">
                                    {{ number_format($resteClient, 0, ',', ' ') }} GNF
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button
                                        type="button"
                                        class="credit-toggle inline-flex items-center justify-center w-8 h-8 rounded-lg
                                               text-blue-600 hover:bg-blue-50 transition"
                                        data-target="{{ $rowId }}"
                                        title="Voir le détail"
                                    >
                                        <span class="credit-eye-icon">👁️</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- ============ LIGNE DÉTAIL (repliée par défaut) ============ --}}
                            <tr id="{{ $rowId }}" class="credit-detail-row hidden">
                                <td colspan="7" class="bg-gray-50 px-4 py-4">

                                    <div class="space-y-3">

                                        @foreach($ventesClient as $vente)

                                            @php
                                                $montant = (float) $vente->montant_total;
                                                $paye    = (float) $vente->paiements->sum('montant_paye');
                                                $reste   = max($montant - $paye, 0);
                                                $pourcentage = $montant > 0 ? min(($paye / $montant) * 100, 100) : 0;
                                            @endphp

                                            <div class="bg-white border border-gray-200 rounded-xl p-4">

                                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                                                    {{-- Détails vente + produits --}}
                                                    <div class="min-w-0 flex-1">

                                                        <div class="flex items-center gap-2 flex-wrap">
                                                            <span class="text-sm font-semibold text-gray-900">
                                                                Vente #{{ $vente->id }}
                                                            </span>
                                                            <span class="text-xs text-gray-400">
                                                                {{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y') }}
                                                            </span>

                                                            @if($reste <= 0)
                                                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Payée</span>
                                                            @elseif($paye > 0)
                                                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">Partielle</span>
                                                            @else
                                                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">Impayée</span>
                                                            @endif
                                                        </div>

                                                        {{-- Produits achetés --}}
                                                        <div class="flex flex-wrap gap-1.5 mt-2">
                                                            @forelse($vente->details as $detail)
                                                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-lg">
                                                                    {{ $detail->produit?->nom_produit ?? 'Produit supprimé' }}
                                                                    <span class="font-semibold">× {{ $detail->quantite }}</span>
                                                                </span>
                                                            @empty
                                                                <span class="text-xs text-gray-400 italic">Aucun produit enregistré</span>
                                                            @endforelse
                                                        </div>

                                                        {{-- Progression paiement --}}
                                                        <div class="mt-3 max-w-xs">
                                                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                                                <span>{{ number_format($paye, 0, ',', ' ') }} / {{ number_format($montant, 0, ',', ' ') }} GNF</span>
                                                                <span>{{ number_format($pourcentage, 0) }}%</span>
                                                            </div>
                                                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                                <div class="h-full bg-blue-600 rounded-full transition-all" style="width: {{ $pourcentage }}%"></div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    {{-- Montant + actions --}}
                                                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-start gap-3 shrink-0">

                                                        <div class="text-right">
                                                            <p class="text-xs text-gray-500">Reste</p>
                                                            <p class="text-lg font-bold text-red-600">
                                                                {{ number_format($reste, 0, ',', ' ') }} GNF
                                                            </p>
                                                        </div>

                                                        <div class="flex gap-2">
                                                            <a href="{{ route('ventes.show', $vente) }}"
                                                               class="inline-flex items-center justify-center px-3 py-2 rounded-lg
                                                                      border border-gray-300 bg-white text-gray-600 hover:bg-gray-100
                                                                      text-xs font-semibold transition"
                                                               title="Voir la vente">
                                                                👁️
                                                            </a>

                                                            <a href="{{ route('recettes.create', ['vente_id' => $vente->id]) }}"
                                                               class="inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg
                                                                      bg-green-600 hover:bg-green-700 text-white
                                                                      text-xs font-semibold transition">
                                                                💰 Encaisser
                                                            </a>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>

    @else

        {{-- =====================================================
             AUCUNE CRÉANCE
        ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-14 text-center">
            <div class="text-5xl mb-4">💳</div>
            <h3 class="text-lg font-bold text-gray-900">Aucune vente à crédit</h3>
            <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                Les ventes dont le paiement n'est pas entièrement réglé apparaîtront ici, regroupées par client.
            </p>

            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('clients.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                          bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                    👤 Ajouter un client
                </a>

                <a href="{{ route('ventes.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                          bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    ➕ Nouvelle vente
                </a>
            </div>
        </div>

    @endif

</div>
</div>


{{-- =============================================================
     JAVASCRIPT — repli / dépli au clic sur l'oeil
============================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.credit-toggle').forEach(function (btn) {

        btn.addEventListener('click', function () {

            const targetId = btn.getAttribute('data-target');
            const detailRow = document.getElementById(targetId);
            const icon = btn.querySelector('.credit-eye-icon');

            if (!detailRow) return;

            const estOuvert = !detailRow.classList.contains('hidden');

            if (estOuvert) {
                detailRow.classList.add('hidden');
                icon.textContent = '👁️';
            } else {
                detailRow.classList.remove('hidden');
                icon.textContent = '🙈';
            }

        });

    });

});
</script>

@endsection
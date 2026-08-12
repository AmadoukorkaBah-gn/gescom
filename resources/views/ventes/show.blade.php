@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto pb-10">


{{-- =========================================================
     EN-TÊTE
========================================================== --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

    <div>
        <nav class="text-sm text-gray-500 mb-1">
            <a
                href="{{ route('ventes.index') }}"
                class="hover:text-blue-600 transition"
            >
                Ventes
            </a>

            <span class="mx-1.5">/</span>

            <span class="text-gray-700 font-medium">
                Vente #{{ $vente->id }}
            </span>
        </nav>

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
            Détails de la vente
        </h1>
    </div>

    {{-- Statut --}}
    <span class="inline-flex self-start px-3 py-1.5 text-xs font-semibold rounded-full
        @if($vente->statut == 'payé')
            bg-green-100 text-green-700
        @elseif($vente->statut == 'partiel')
            bg-orange-100 text-orange-700
        @elseif($vente->statut == 'en_cours')
            bg-yellow-100 text-yellow-700
        @else
            bg-gray-100 text-gray-700
        @endif
    ">

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

</div>


{{-- =========================================================
     INFORMATIONS GÉNÉRALES
========================================================== --}}
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 sm:p-6 mb-6">

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        {{-- Client --}}
        <div>
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                Client
            </div>

            <div class="text-sm font-semibold text-gray-900">
                {{ $vente->client->nom_client ?? 'Client non renseigné' }}
            </div>
        </div>


        {{-- Date --}}
        <div>
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                Date de vente
            </div>

            <div class="text-sm font-semibold text-gray-900">
                {{ $vente->date_vente->format('d/m/Y à H:i') }}
            </div>
        </div>


        {{-- Total --}}
        <div>
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                Total à payer
            </div>

            <div class="text-lg font-bold text-blue-600">
                {{ number_format($vente->montant_total, 0, ',', ' ') }} GNF
            </div>
        </div>

    </div>

</div>


{{-- =========================================================
     PRODUITS VENDUS
========================================================== --}}
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">

    <div class="px-5 sm:px-6 pt-5 sm:pt-6 pb-1">

        <h2 class="text-base font-semibold text-gray-800">
            Produits vendus
        </h2>

    </div>


    <div class="overflow-x-auto mt-3">

        <table class="min-w-full divide-y divide-gray-100">

            <thead class="bg-gray-50">

                <tr>

                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Produit
                    </th>

                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Quantité
                    </th>

                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Prix unitaire
                    </th>

                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Sous-total
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100">

                @foreach($vente->details as $detail)

                <tr>

                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                        {{ $detail->produit->nom_produit }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-600 text-right">
                        {{ $detail->quantite }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-600 text-right">
                        {{ number_format($detail->prix_unitaire, 0, ',', ' ') }} GNF
                    </td>

                    <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">
                        {{ number_format(
                            $detail->quantite * $detail->prix_unitaire,
                            0,
                            ',',
                            ' '
                        ) }} GNF
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>


    {{-- =====================================================
         RÉCAPITULATIF FINANCIER
    ====================================================== --}}
    <div class="border-t border-gray-200 bg-gray-50 px-5 sm:px-6 py-5">

        <div class="max-w-md ml-auto space-y-3">

            {{-- Montant brut --}}
            <div class="flex items-center justify-between text-sm">

                <span class="text-gray-600">
                    Sous-total
                </span>

                <span class="font-semibold text-gray-900">
                    {{ number_format(
                        $vente->montant_brut,
                        0,
                        ',',
                        ' '
                    ) }} GNF
                </span>

            </div>


            {{-- Remise --}}
            @if($vente->montant_remise > 0)

                <div class="flex items-center justify-between text-sm">

                    <div class="flex items-center gap-2">

                        <span class="text-gray-600">
                            Remise
                        </span>

                        @if($vente->type_remise === 'pourcentage')

                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                -{{ number_format($vente->valeur_remise, 0, ',', ' ') }}%
                            </span>

                        @else

                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                Fixe
                            </span>

                        @endif

                    </div>

                    <span class="font-semibold text-orange-600">
                        - {{ number_format(
                            $vente->montant_remise,
                            0,
                            ',',
                            ' '
                        ) }} GNF
                    </span>

                </div>

            @endif


            {{-- Ligne séparatrice --}}
            <div class="border-t border-gray-300 pt-3"></div>


            {{-- Total --}}
            <div class="flex items-center justify-between">

                <span class="text-base font-bold text-gray-900">
                    Total à payer
                </span>

                <span class="text-xl font-bold text-blue-600">
                    {{ number_format(
                        $vente->montant_total,
                        0,
                        ',',
                        ' '
                    ) }} GNF
                </span>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     INFORMATIONS REMISE
========================================================== --}}
@if($vente->montant_remise > 0)

    <div class="bg-orange-50 border border-orange-200 rounded-2xl p-4 sm:p-5 mb-6">

        <div class="flex items-start gap-3">

            <div class="flex-shrink-0">

                <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center">

                    <svg
                        class="w-5 h-5 text-orange-600"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 14l6-6m2.5-3.5a2.5 2.5 0 11-3.536 0L6.5 12.5a2.5 2.5 0 103.536 3.536L17.5 8.5a2.5 2.5 0 10-3.536-3.536"
                        />
                    </svg>

                </div>

            </div>


            <div>

                <h3 class="text-sm font-semibold text-orange-900">
                    Remise accordée au client
                </h3>

                <p class="text-sm text-orange-700 mt-1">

                    @if($vente->type_remise === 'pourcentage')

                        Remise de
                        <strong>
                            {{ number_format($vente->valeur_remise, 0, ',', ' ') }}%
                        </strong>

                    @else

                        Remise fixe

                    @endif

                    d'un montant de

                    <strong>
                        {{ number_format(
                            $vente->montant_remise,
                            0,
                            ',',
                            ' '
                        ) }} GNF
                    </strong>.

                </p>

            </div>

        </div>

    </div>

@endif


{{-- =========================================================
     ACTIONS
========================================================== --}}
<div class="flex flex-wrap items-center gap-3">

    {{-- Retour --}}
    <a
        href="{{ route('ventes.index') }}"
        class="inline-flex items-center gap-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 text-sm font-medium px-4 py-2.5 rounded-lg transition"
    >

        <svg
            class="w-4 h-4"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"
            />
        </svg>

        Retour à la liste

    </a>


    {{-- PDF --}}
    <a
        href="{{ route('ventes.receipt', $vente) }}"
        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition"
    >

        <svg
            class="w-4 h-4"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2"
            />
        </svg>

        Télécharger / imprimer

    </a>


    {{-- Encaisser --}}
    @if($vente->statut == 'en_cours' || $vente->statut == 'partiel')

        <a
            href="{{ route('recettes.create', ['vente_id' => $vente->id]) }}"
            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 active:scale-[0.98] text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition"
        >

            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 8c-2 0-4 1-4 3s2 3 4 3 4-1 4-3-2-3-4-3zm0 6v6"
                />
            </svg>

            Encaisser

        </a>

    @endif

</div>


</div>
@endsection

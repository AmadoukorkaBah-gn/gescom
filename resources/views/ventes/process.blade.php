@extends('layouts.app')

@section('content')

<div class="w-full max-w-4xl mx-auto px-3 sm:px-5 lg:px-6 pb-8 sm:pb-10">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="mb-5 sm:mb-6">

        <nav class="flex flex-wrap items-center text-xs sm:text-sm text-gray-500 mb-2 gap-1">

            <a
                href="{{ route('ventes.index') }}"
                class="font-medium hover:text-blue-600 transition"
            >
                Ventes
            </a>

            <span class="text-gray-400">/</span>

            <span class="text-gray-700 font-medium">
                Traitement
            </span>

        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>

                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 tracking-tight">
                    Vente #{{ $vente->id }}
                </h1>

                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Vérifiez les détails avant de confirmer le traitement.
                </p>

            </div>

            <a
                href="{{ route('ventes.index') }}"
                class="inline-flex items-center justify-center gap-2
                       w-full sm:w-auto
                       px-4 py-2.5
                       rounded-lg
                       border border-gray-300
                       bg-white
                       text-sm font-medium text-gray-700
                       hover:bg-gray-50
                       transition"
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

                Retour aux ventes

            </a>

        </div>

    </div>


    {{-- =========================================================
         MESSAGE ERREUR
    ========================================================== --}}

    @if(session('error'))

        <div
            class="flex items-start gap-3
                   bg-red-50
                   border border-red-200
                   text-red-800
                   text-sm
                   px-4 py-3.5
                   rounded-xl
                   mb-5"
        >

            <svg
                class="w-5 h-5 flex-shrink-0 mt-0.5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m9-.75a9 9 0 11-18 0
                       9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                />
            </svg>

            <span class="leading-5">
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =========================================================
         INFORMATION
    ========================================================== --}}

    <div
        class="flex items-start gap-3
               bg-blue-50
               border border-blue-100
               text-blue-800
               text-xs sm:text-sm
               px-4 py-3.5
               rounded-xl
               mb-5"
    >

        <svg
            class="w-5 h-5 flex-shrink-0 mt-0.5"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M13 16h-1v-4h-1m1-4h.01
                   M21 12a9 9 0 11-18 0
                   9 9 0 0118 0z"
            />
        </svg>

        <span class="leading-5">
            Confirmer le traitement mettra à jour le stock des produits
            listés ci-dessous. Cette action est définitive.
        </span>

    </div>


    {{-- =========================================================
         DÉTAILS DE LA VENTE
    ========================================================== --}}

    <div
        class="bg-white
               border border-gray-200
               rounded-xl sm:rounded-2xl
               shadow-sm
               overflow-hidden
               mb-5 sm:mb-6"
    >

        {{-- Titre mobile/desktop --}}

        <div class="px-4 sm:px-5 py-4 border-b border-gray-100">

            <h2 class="text-base sm:text-lg font-semibold text-gray-900">
                Produits de la vente
            </h2>

            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                Détail des articles et montants.
            </p>

        </div>


        {{-- =====================================================
             TABLEAU DES PRODUITS
        ====================================================== --}}

        <div class="overflow-x-auto">

            <table class="min-w-[650px] w-full divide-y divide-gray-100">

                <thead class="bg-gray-50">

                    <tr>

                        <th
                            class="px-4 sm:px-5 py-3
                                   text-left
                                   text-[11px] sm:text-xs
                                   font-semibold
                                   text-gray-500
                                   uppercase
                                   tracking-wide"
                        >
                            Produit
                        </th>

                        <th
                            class="px-4 sm:px-5 py-3
                                   text-right
                                   text-[11px] sm:text-xs
                                   font-semibold
                                   text-gray-500
                                   uppercase
                                   tracking-wide"
                        >
                            Quantité
                        </th>

                        <th
                            class="px-4 sm:px-5 py-3
                                   text-right
                                   text-[11px] sm:text-xs
                                   font-semibold
                                   text-gray-500
                                   uppercase
                                   tracking-wide"
                        >
                            Prix unitaire
                        </th>

                        <th
                            class="px-4 sm:px-5 py-3
                                   text-right
                                   text-[11px] sm:text-xs
                                   font-semibold
                                   text-gray-500
                                   uppercase
                                   tracking-wide"
                        >
                            Total
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($vente->details as $detail)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- PRODUIT --}}

                            <td class="px-4 sm:px-5 py-3.5">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-8 h-8 sm:w-9 sm:h-9
                                               rounded-lg
                                               bg-blue-50
                                               text-blue-600
                                               flex items-center justify-center
                                               flex-shrink-0"
                                    >

                                        <svg
                                            class="w-4 h-4 sm:w-5 sm:h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                            />
                                        </svg>

                                    </div>

                                    <span
                                        class="text-sm
                                               font-semibold
                                               text-gray-900"
                                    >
                                        {{ $detail->produit->nom_produit }}
                                    </span>

                                </div>

                            </td>


                            {{-- QUANTITÉ --}}

                            <td
                                class="px-4 sm:px-5 py-3.5
                                       text-sm
                                       text-gray-600
                                       text-right
                                       font-medium"
                            >
                                {{ $detail->quantite }}
                            </td>


                            {{-- PRIX UNITAIRE --}}

                            <td
                                class="px-4 sm:px-5 py-3.5
                                       text-sm
                                       text-gray-600
                                       text-right
                                       whitespace-nowrap"
                            >
                                {{ number_format($detail->prix_unitaire, 2) }}
                                GNF
                            </td>


                            {{-- TOTAL --}}

                            <td
                                class="px-4 sm:px-5 py-3.5
                                       text-sm
                                       font-semibold
                                       text-gray-900
                                       text-right
                                       whitespace-nowrap"
                            >
                                {{ number_format($detail->quantite * $detail->prix_unitaire, 2) }}
                                GNF
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="px-4 py-10 text-center text-sm text-gray-500"
                            >
                                Aucun produit trouvé dans cette vente.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
         TOTAL
    ========================================================== --}}

    <div
        class="bg-slate-800
               rounded-xl sm:rounded-2xl
               shadow-sm
               p-4 sm:p-6
               mb-5 sm:mb-6"
    >

        <div
            class="flex flex-col sm:flex-row
                   sm:items-center
                   sm:justify-between
                   gap-2 sm:gap-4"
        >

            <div>

                <span
                    class="block
                           text-[11px] sm:text-xs
                           text-white/60
                           uppercase
                           tracking-wider
                           font-semibold"
                >
                    Montant total
                </span>

                <span class="block text-xs text-white/50 mt-1">
                    Total de la vente
                </span>

            </div>

            <span
                class="text-xl sm:text-2xl lg:text-3xl
                       font-bold
                       text-white
                       break-words"
            >
                {{ number_format($vente->montant_total, 2) }} GNF
            </span>

        </div>

    </div>


    {{-- =========================================================
         ACTIONS
    ========================================================== --}}

    <form
        action="{{ route('ventes.process', $vente) }}"
        method="POST"
        id="processVenteForm"
    >

        @csrf

        <div
            class="flex flex-col-reverse sm:flex-row
                   sm:items-center
                   gap-3"
        >

            {{-- ANNULER --}}

            <a
                href="{{ route('ventes.index') }}"
                class="inline-flex
                       items-center
                       justify-center
                       gap-2
                       w-full sm:w-auto
                       px-5 py-2.5
                       rounded-lg
                       border border-gray-300
                       bg-white
                       text-sm
                       font-medium
                       text-gray-700
                       hover:bg-gray-50
                       transition"
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
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>

                Annuler

            </a>


            {{-- CONFIRMER --}}

            <button
                type="submit"
                id="processBtn"
                onclick="return confirm('Confirmer le traitement de cette vente et mise à jour du stock ?')"
                class="inline-flex
                       items-center
                       justify-center
                       gap-2
                       w-full sm:w-auto
                       bg-green-600
                       hover:bg-green-700
                       active:scale-[0.98]
                       text-white
                       font-semibold
                       text-sm
                       py-2.5
                       px-5
                       rounded-lg
                       shadow-sm
                       transition"
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
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                Confirmer et traiter

            </button>

        </div>

    </form>

</div>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('processVenteForm');

    const button = document.getElementById('processBtn');


    if (form && button) {

        form.addEventListener('submit', function () {

            /*
             * Le onclick effectue déjà la confirmation.
             * Si l'utilisateur confirme, on bloque le bouton
             * afin d'éviter les doubles soumissions.
             */

            button.disabled = true;

            button.classList.add(
                'opacity-60',
                'cursor-not-allowed'
            );


            button.innerHTML = `

                <svg
                    class="animate-spin w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                >

                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>

                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                    ></path>

                </svg>

                Traitement...

            `;

        });

    }

});

</script>

@endsection
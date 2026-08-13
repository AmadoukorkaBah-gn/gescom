
@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #achatDetailsPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    #achatDetailsPage table {
        font-size: 14px;
    }
</style>

<div id="achatDetailsPage" class="container mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-8">

    {{-- =====================================================
         TITRE + RETOUR
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5 sm:mb-6">

        <div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 tracking-tight">
                Détails de l'Achat
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Informations et produits de cet achat
            </p>
        </div>

        <a href="{{ route('achats.index') }}"
           class="inline-flex items-center justify-center w-full sm:w-auto
                  bg-gray-500 hover:bg-gray-700 active:bg-gray-800
                  text-white font-semibold
                  py-2.5 px-4 rounded-lg
                  text-sm sm:text-base
                  transition duration-200
                  shadow-sm">
            ← Retour à la liste
        </a>

    </div>


    {{-- =====================================================
         INFORMATIONS GÉNÉRALES
    ====================================================== --}}
    <div class="bg-white shadow-sm sm:shadow-md rounded-xl
                p-4 sm:p-6 mb-5 sm:mb-6
                border border-gray-100">

        <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">
            Informations générales
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Fournisseur --}}
            <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                <p class="text-xs sm:text-sm text-gray-500 mb-1">
                    Fournisseur
                </p>

                <p class="text-sm sm:text-base font-semibold text-gray-800 break-words">
                    {{ $achat->fournisseur->nom_fournisseur }}
                </p>
            </div>

            {{-- Date --}}
            <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                <p class="text-xs sm:text-sm text-gray-500 mb-1">
                    Date d'achat
                </p>

                <p class="text-sm sm:text-base font-semibold text-gray-800">
                    {{ $achat->date_achat->format('Y-m-d') }}
                </p>
            </div>

            {{-- Facture --}}
            <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                <p class="text-xs sm:text-sm text-gray-500 mb-1">
                    Numéro de facture
                </p>

                <p class="text-sm sm:text-base font-semibold text-gray-800 break-words">
                    {{ $achat->numero_facture ?? '-' }}
                </p>
            </div>

            {{-- Total --}}
            <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                <p class="text-xs sm:text-sm text-gray-500 mb-1">
                    Total
                </p>

                <p class="text-sm sm:text-base font-bold text-gray-900 break-words">
                    {{ number_format($achat->total, 2) }} GNF
                </p>
            </div>

            {{-- Statut --}}
            <div class="bg-gray-50 rounded-lg p-3 sm:p-4 sm:col-span-2">

                <p class="text-xs sm:text-sm text-gray-500 mb-2">
                    Statut
                </p>

                <span class="px-3 py-1.5 inline-flex items-center
                             text-xs sm:text-sm leading-5 font-semibold
                             rounded-full

                    @if($achat->statut == 'en_cours')
                        bg-yellow-100 text-yellow-800

                    @elseif($achat->statut == 'recu')
                        bg-green-100 text-green-800

                    @else
                        bg-red-100 text-red-800
                    @endif
                ">
                    {{ ucfirst($achat->statut) }}
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUITS COMMANDÉS
    ====================================================== --}}
    <div class="bg-white shadow-sm sm:shadow-md rounded-xl
                border border-gray-100
                overflow-hidden mb-5 sm:mb-6">

        <div class="p-4 sm:p-6 pb-3 sm:pb-4">

            <h2 class="text-base sm:text-lg font-semibold text-gray-800">
                Produits commandés
            </h2>

            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Liste des produits inclus dans cet achat
            </p>

        </div>


        {{-- =================================================
             VUE MOBILE : CARTES
        ================================================== --}}
        <div class="md:hidden px-3 pb-4 space-y-3">

            @forelse($achat->details as $detail)

                <div class="border border-gray-200 rounded-xl p-4
                            bg-gray-50">

                    {{-- Produit --}}
                    <div class="mb-3">

                        <p class="text-xs text-gray-500 mb-1">
                            Produit
                        </p>

                        <p class="text-sm font-bold text-gray-900 break-words">
                            {{ $detail->produit->nom_produit }}
                        </p>

                    </div>


                    {{-- Informations --}}
                    <div class="grid grid-cols-2 gap-3
                                border-t border-gray-200 pt-3">

                        <div>
                            <p class="text-xs text-gray-500">
                                Quantité
                            </p>

                            <p class="text-sm font-semibold text-gray-800 mt-0.5">
                                {{ $detail->quantite }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Péremption
                            </p>

                            <p class="text-sm font-semibold text-gray-800 mt-0.5 break-words">
                                {{ $detail->date_peremption ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Prix unitaire
                            </p>

                            <p class="text-sm font-semibold text-gray-800 mt-0.5 break-words">
                                {{ number_format($detail->prix_unitaire, 2) }} GNF
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Sous-total
                            </p>

                            <p class="text-sm font-bold text-gray-900 mt-0.5 break-words">
                                {{ number_format($detail->quantite * $detail->prix_unitaire, 2) }} GNF
                            </p>
                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center py-8 text-sm text-gray-500">
                    Aucun produit associé à cet achat.
                </div>

            @endforelse

        </div>


        {{-- =================================================
             VUE DESKTOP : TABLEAU
        ================================================== --}}
        <div class="hidden md:block overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-4 lg:px-6 py-3
                                   text-left text-xs font-semibold
                                   text-gray-500 uppercase tracking-wider
                                   whitespace-nowrap">
                            Produit
                        </th>

                        <th class="px-4 lg:px-6 py-3
                                   text-left text-xs font-semibold
                                   text-gray-500 uppercase tracking-wider
                                   whitespace-nowrap">
                            Quantité achetée
                        </th>

                        <th class="px-4 lg:px-6 py-3
                                   text-left text-xs font-semibold
                                   text-gray-500 uppercase tracking-wider
                                   whitespace-nowrap">
                            Date péremption
                        </th>

                        <th class="px-4 lg:px-6 py-3
                                   text-left text-xs font-semibold
                                   text-gray-500 uppercase tracking-wider
                                   whitespace-nowrap">
                            Prix unitaire
                        </th>

                        <th class="px-4 lg:px-6 py-3
                                   text-left text-xs font-semibold
                                   text-gray-500 uppercase tracking-wider
                                   whitespace-nowrap">
                            Sous-total
                        </th>

                    </tr>

                </thead>


                <tbody class="bg-white divide-y divide-gray-200">

                    @forelse($achat->details as $detail)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-4 lg:px-6 py-3
                                       text-sm font-medium text-gray-900">
                                {{ $detail->produit->nom_produit }}
                            </td>

                            <td class="px-4 lg:px-6 py-3
                                       text-sm text-gray-700">
                                {{ $detail->quantite }}
                            </td>

                            <td class="px-4 lg:px-6 py-3
                                       text-sm text-gray-700 whitespace-nowrap">
                                {{ $detail->date_peremption ?? '-' }}
                            </td>

                            <td class="px-4 lg:px-6 py-3
                                       text-sm text-gray-700 whitespace-nowrap">
                                {{ number_format($detail->prix_unitaire, 2) }} GNF
                            </td>

                            <td class="px-4 lg:px-6 py-3
                                       text-sm font-semibold text-gray-900 whitespace-nowrap">
                                {{ number_format($detail->quantite * $detail->prix_unitaire, 2) }} GNF
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-6 py-8 text-center
                                       text-sm text-gray-500">
                                Aucun produit associé à cet achat.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         BOUTON DE RÉCEPTION
    ====================================================== --}}
    @if($achat->statut == 'en_cours')

        <div class="flex">

            <a href="{{ route('achats.receive.form', $achat) }}"
               class="inline-flex items-center justify-center
                      w-full sm:w-auto
                      bg-green-500 hover:bg-green-700
                      active:bg-green-800
                      text-white font-semibold
                      py-3 px-5
                      rounded-lg
                      text-sm sm:text-base
                      transition duration-200
                      shadow-sm">

                Recevoir et payer

            </a>

        </div>

    @endif

</div>

@endsection


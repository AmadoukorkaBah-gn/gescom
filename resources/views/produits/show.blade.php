@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 px-3 sm:px-5 lg:px-8 py-5 sm:py-8">

    <div class="max-w-5xl mx-auto">

        {{-- =========================
             EN-TÊTE
        ========================== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 tracking-tight">
                    Détails du Produit
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Informations détaillées sur le produit
                </p>
            </div>

            <a
                href="{{ route('produits.index') }}"
                class="inline-flex items-center justify-center gap-2
                       w-full sm:w-auto
                       px-4 py-2.5
                       bg-gray-700 hover:bg-gray-800
                       text-white text-sm font-semibold
                       rounded-xl shadow-sm
                       transition duration-200"
            >
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>

                Retour à la liste
            </a>

        </div>


        {{-- =========================
             CARTE PRINCIPALE
        ========================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Bandeau --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-5 sm:px-7 py-6">

                <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                    {{-- Icône produit --}}
                    <div class="w-14 h-14 sm:w-16 sm:h-16
                                bg-white/20 backdrop-blur-sm
                                rounded-2xl
                                flex items-center justify-center
                                flex-shrink-0">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-8 h-8 sm:w-9 sm:h-9 text-white"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />

                        </svg>

                    </div>

                    <div class="min-w-0">

                        <p class="text-blue-100 text-sm font-medium">
                            Produit
                        </p>

                        <h2 class="text-xl sm:text-2xl font-bold text-white truncate">
                            {{ $produit->nom_produit }}
                        </h2>

                    </div>

                </div>

            </div>


            {{-- =========================
                 INFORMATIONS
            ========================== --}}
            <div class="p-4 sm:p-6 lg:p-8">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    {{-- Nom --}}
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">
                            Nom du produit
                        </p>

                        <p class="text-base font-bold text-gray-800 break-words">
                            {{ $produit->nom_produit }}
                        </p>

                    </div>


                    {{-- Catégorie --}}
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">
                            Catégorie
                        </p>

                        <p class="text-base font-bold text-gray-800 break-words">
                            {{ $produit->categorie->nom_categorie ?? '-' }}
                        </p>

                    </div>


                    {{-- Fournisseur --}}
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">
                            Fournisseur
                        </p>

                        <p class="text-base font-bold text-gray-800 break-words">
                            {{ $produit->fournisseur->nom_fournisseur ?? '-' }}
                        </p>

                    </div>


                    {{-- Prix achat --}}
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">

                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600 mb-1">
                            Prix d'achat
                        </p>

                        <p class="text-lg font-extrabold text-blue-700 break-words">
                            {{ number_format($produit->prix_produit, 2, ',', ' ') }}
                            <span class="text-sm font-semibold">GNF</span>
                        </p>

                    </div>


                    {{-- Prix vente --}}
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">

                        <p class="text-xs font-semibold uppercase tracking-wide text-green-600 mb-1">
                            Prix de vente
                        </p>

                        <p class="text-lg font-extrabold text-green-700 break-words">
                            {{ number_format($produit->prix_vente, 2, ',', ' ') }}
                            <span class="text-sm font-semibold">GNF</span>
                        </p>

                    </div>


                    {{-- Stock actuel --}}
                    <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">

                        <p class="text-xs font-semibold uppercase tracking-wide text-purple-600 mb-1">
                            Stock actuel
                        </p>

                        <p class="text-lg font-extrabold text-purple-700">
                            {{ $produit->stock }}
                        </p>

                    </div>


                    {{-- Stock minimum --}}
                    <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">

                        <p class="text-xs font-semibold uppercase tracking-wide text-orange-600 mb-1">
                            Stock minimum
                        </p>

                        <p class="text-lg font-extrabold text-orange-700">
                            {{ $produit->stock_minimum }}
                        </p>

                    </div>


                    {{-- Statut --}}
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">
                            Statut
                        </p>

                        @if($produit->statut)

                            <span class="inline-flex items-center gap-2
                                         px-3 py-1.5
                                         rounded-full
                                         bg-green-100
                                         text-green-700
                                         text-sm
                                         font-bold">

                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>

                                Actif

                            </span>

                        @else

                            <span class="inline-flex items-center gap-2
                                         px-3 py-1.5
                                         rounded-full
                                         bg-red-100
                                         text-red-700
                                         text-sm
                                         font-bold">

                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>

                                Inactif

                            </span>

                        @endif

                    </div>

                </div>


                {{-- =========================
                     ACTIONS
                ========================== --}}
                <div class="mt-8 pt-6 border-t border-gray-100">

                    <div class="flex flex-col sm:flex-row gap-3">

                        <a
                            href="{{ route('produits.index') }}"
                            class="inline-flex items-center justify-center gap-2
                                   w-full sm:w-auto
                                   px-5 py-2.5
                                   bg-gray-100 hover:bg-gray-200
                                   text-gray-700
                                   font-semibold
                                   rounded-xl
                                   transition duration-200"
                        >

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M15 19l-7-7 7-7" />

                            </svg>

                            Retour à la liste

                        </a>


                        <a
                            href="{{ route('produits.edit', $produit) }}"
                            class="inline-flex items-center justify-center gap-2
                                   w-full sm:w-auto
                                   px-5 py-2.5
                                   bg-yellow-500 hover:bg-yellow-600
                                   text-white
                                   font-semibold
                                   rounded-xl
                                   shadow-sm
                                   transition duration-200"
                        >

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-8.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 8.5-8.5z" />

                            </svg>

                            Modifier le produit

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
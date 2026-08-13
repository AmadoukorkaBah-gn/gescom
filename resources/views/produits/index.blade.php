@extends('layouts.app')

@section('content')

<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                Gestion des Produits
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Gérez vos produits, prix et niveaux de stock
            </p>
        </div>

        <a href="{{ route('produits.create') }}"
           class="inline-flex items-center justify-center gap-2
                  w-full sm:w-auto
                  bg-blue-600 hover:bg-blue-700
                  text-white font-semibold
                  py-2.5 px-5
                  rounded-xl shadow-sm
                  transition duration-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4" />
            </svg>

            Ajouter un produit
        </a>
    </div>


    {{-- =========================================================
         MESSAGE SUCCÈS
    ========================================================== --}}
    @if(session('success'))

        <div class="mb-5 rounded-xl border border-green-200 bg-green-50
                    px-4 py-3 text-green-800 shadow-sm">

            <div class="flex items-start gap-3">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 mt-0.5 flex-shrink-0 text-green-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7" />
                </svg>

                <span class="text-sm font-medium">
                    {{ session('success') }}
                </span>

            </div>
        </div>

    @endif


    {{-- =========================================================
         CALCUL STOCK BAS
    ========================================================== --}}
    @php
        $lowStockProducts = $produits->filter(function($produit) {
            return $produit->stockActuel() < $produit->stock_minimum;
        });
    @endphp


    {{-- =========================================================
         ALERTE STOCK
    ========================================================== --}}
    @if($lowStockProducts->count() > 0)

        <div id="low-stock"
             class="mb-5 rounded-xl border border-red-200 bg-red-50
                    px-4 py-4 text-red-800 shadow-sm">

            <div class="flex flex-col sm:flex-row sm:items-center gap-3">

                <div class="flex items-center gap-3">

                    <div class="flex-shrink-0 bg-red-100 rounded-full p-2">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-red-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86l-8.18 14A2 2 0 003.83 21h16.34a2 2 0 001.72-3.14l-8.18-14a2 2 0 00-3.42 0z" />

                        </svg>

                    </div>

                    <div>
                        <p class="font-bold text-sm sm:text-base">
                            Alerte Stock Bas
                        </p>

                        <p class="text-sm mt-0.5">
                            {{ $lowStockProducts->count() }}
                            produit(s) nécessitent votre attention.
                        </p>
                    </div>

                </div>

                <a href="#low-stock-table"
                   class="sm:ml-auto text-sm font-semibold underline hover:no-underline">
                    Voir les produits concernés
                </a>

            </div>

        </div>

    @endif


    {{-- =========================================================
         CONTENEUR PRINCIPAL
    ========================================================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">


        {{-- =====================================================
             RECHERCHE
        ====================================================== --}}
        <div class="p-4 sm:p-5 border-b border-gray-100 bg-gray-50">

            <form method="GET"
                  action="{{ route('produits.index') }}"
                  class="flex flex-col sm:flex-row gap-3">

                <div class="relative flex-1">

                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-gray-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z" />

                        </svg>

                    </div>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Rechercher un produit..."

                        class="w-full
                               pl-10 pr-4 py-2.5
                               border border-gray-300
                               rounded-xl
                               bg-white
                               text-sm sm:text-base
                               text-gray-800
                               placeholder-gray-400
                               focus:outline-none
                               focus:ring-2
                               focus:ring-blue-500
                               focus:border-blue-500
                               transition"
                    >

                </div>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2
                               bg-gray-800 hover:bg-gray-900
                               text-white
                               font-semibold
                               px-5 py-2.5
                               rounded-xl
                               transition duration-200">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z" />

                    </svg>

                    Rechercher
                </button>

            </form>

        </div>


        {{-- =====================================================
             TABLEAU
        ====================================================== --}}
        <div id="low-stock-table" class="overflow-x-auto">

            <table class="min-w-[1100px] w-full divide-y divide-gray-200">

                {{-- EN-TÊTE --}}
                <thead class="bg-orange-500">

                    <tr>

                        <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                            N°
                        </th>

                        <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                            Nom
                        </th>

                        <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                            Catégorie
                        </th>

                        <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                            Fournisseur
                        </th>

                        <th class="px-3 py-3 text-right text-xs font-bold text-white uppercase tracking-wider">
                            Prix Achat
                        </th>

                        <th class="px-3 py-3 text-right text-xs font-bold text-white uppercase tracking-wider">
                            Prix Vente
                        </th>

                        <th class="px-3 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">
                            Stock
                        </th>

                        <th class="px-3 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">
                            Stock Min
                        </th>

                        <th class="px-3 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">
                            Statut
                        </th>

                        <th class="px-3 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">
                            Actions
                        </th>

                    </tr>

                </thead>


                {{-- CORPS --}}
                <tbody class="bg-white divide-y divide-gray-100">

                    @forelse($produits as $produit)

                        @php
                            $stockActuel = $produit->stockActuel();
                        @endphp

                        <tr class="
                            transition duration-150
                            hover:bg-gray-50
                            {{ $stockActuel < $produit->stock_minimum ? 'bg-red-50 hover:bg-red-100' : '' }}
                        ">

                            {{-- N° --}}
                            <td class="px-3 py-3 text-sm font-medium text-gray-600">
                                {{ $loop->iteration }}
                            </td>


                            {{-- NOM --}}
                            <td class="px-3 py-3 text-sm font-semibold text-gray-900">
                                {{ $produit->nom_produit }}
                            </td>


                            {{-- CATÉGORIE --}}
                            <td class="px-3 py-3 text-sm text-gray-600">
                                {{ $produit->categorie->nom_categorie ?? '-' }}
                            </td>


                            {{-- FOURNISSEUR --}}
                            <td class="px-3 py-3 text-sm text-gray-600">
                                {{ $produit->fournisseur->nom_fournisseur ?? '-' }}
                            </td>


                            {{-- PRIX ACHAT --}}
                            <td class="px-3 py-3 text-sm text-right font-medium text-gray-700 whitespace-nowrap">
                                {{ number_format($produit->prix_produit, 2, ',', ' ') }}
                                <span class="text-xs text-gray-400">GNF</span>
                            </td>


                            {{-- PRIX VENTE --}}
                            <td class="px-3 py-3 text-sm text-right font-semibold text-blue-600 whitespace-nowrap">
                                {{ number_format($produit->prix_vente, 2, ',', ' ') }}
                                <span class="text-xs text-gray-400">GNF</span>
                            </td>


                            {{-- STOCK --}}
                            <td class="px-3 py-3 text-center">

                                <span class="
                                    inline-flex items-center justify-center
                                    min-w-[42px]
                                    px-2.5 py-1
                                    rounded-lg
                                    text-sm font-bold
                                    {{ $stockActuel < $produit->stock_minimum
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-gray-100 text-gray-700' }}
                                ">
                                    {{ $stockActuel }}
                                </span>

                            </td>


                            {{-- STOCK MINIMUM --}}
                            <td class="px-3 py-3 text-center text-sm font-medium text-gray-600">
                                {{ $produit->stock_minimum }}
                            </td>


                            {{-- STATUT --}}
                            <td class="px-3 py-3 text-center">

                                <span class="
                                    inline-flex items-center
                                    px-2.5 py-1
                                    rounded-full
                                    text-xs font-semibold
                                    {{ $produit->statut
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}
                                ">

                                    <span class="
                                        w-1.5 h-1.5
                                        rounded-full
                                        mr-1.5
                                        {{ $produit->statut
                                            ? 'bg-green-500'
                                            : 'bg-red-500' }}
                                    "></span>

                                    {{ $produit->statut ? 'Actif' : 'Inactif' }}

                                </span>

                            </td>


                            {{-- ACTIONS --}}
                            <td class="px-3 py-3">

                                <div class="flex items-center justify-center gap-1.5">


                                    {{-- VOIR --}}
                                    <a href="{{ route('produits.show', $produit) }}"
                                       title="Voir le produit"
                                       class="
                                           inline-flex items-center justify-center
                                           w-8 h-8
                                           bg-indigo-100
                                           text-indigo-700
                                           rounded-lg
                                           hover:bg-indigo-200
                                           transition
                                       ">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                        </svg>

                                    </a>


                                    {{-- MODIFIER --}}
                                    <a href="{{ route('produits.edit', $produit) }}"
                                       title="Modifier le produit"
                                       class="
                                           inline-flex items-center justify-center
                                           w-8 h-8
                                           bg-yellow-100
                                           text-yellow-700
                                           rounded-lg
                                           hover:bg-yellow-200
                                           transition
                                       ">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M15.232 5.232l3.536 3.536M9 13.5V15h1.5l7.5-7.5-1.5-1.5L9 13.5z" />

                                        </svg>

                                    </a>


                                    {{-- SUPPRIMER --}}
                                    <form method="POST"
                                          action="{{ route('produits.destroy', $produit) }}"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="Supprimer le produit"
                                                class="
                                                    inline-flex items-center justify-center
                                                    w-8 h-8
                                                    bg-red-100
                                                    text-red-700
                                                    rounded-lg
                                                    hover:bg-red-200
                                                    transition
                                                ">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-4 w-4"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 2h4a1 1 0 011 1v1H9V3a1 1 0 011-1z" />

                                            </svg>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10"
                                class="px-4 py-10 text-center">

                                <div class="flex flex-col items-center justify-center">

                                    <div class="w-14 h-14 rounded-full bg-gray-100
                                                flex items-center justify-center mb-3">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-7 w-7 text-gray-400"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4" />

                                        </svg>

                                    </div>

                                    <p class="text-sm font-medium text-gray-500">
                                        Aucun produit trouvé.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             PAGINATION
        ====================================================== --}}
        <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-100">

            <div class="overflow-x-auto">
                {{ $produits->appends(request()->query())->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-7">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="mb-6 sm:mb-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                        Mouvements de stock
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Suivez les entrées et sorties de vos produits.
                    </p>
                </div>

                <div class="hidden sm:flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full
                                 bg-white border border-slate-200
                                 text-xs font-semibold text-slate-600 shadow-sm">
                        Gestion du stock
                    </span>
                </div>

            </div>

        </div>


        {{-- =====================================================
             STATISTIQUES
        ====================================================== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-6 sm:mb-8">

            {{-- Total produits --}}
            <div class="group bg-white rounded-2xl border border-slate-200
                        shadow-sm hover:shadow-md transition-all duration-200
                        p-4 sm:p-5">

                <div class="flex items-center gap-3">

                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12
                                rounded-xl bg-slate-100
                                flex items-center justify-center
                                text-slate-700">

                        <svg class="w-5 h-5 sm:w-6 sm:h-6"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>

                    </div>

                    <div class="min-w-0">

                        <p class="text-xs sm:text-sm font-medium text-slate-500 truncate">
                            Total Produits
                        </p>

                        <p class="mt-0.5 text-xl sm:text-2xl font-extrabold text-slate-800">
                            {{ $totalProduits ?? 0 }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- En stock --}}
            <div class="group bg-white rounded-2xl border border-slate-200
                        shadow-sm hover:shadow-md transition-all duration-200
                        p-4 sm:p-5">

                <div class="flex items-center gap-3">

                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12
                                rounded-xl bg-emerald-50
                                flex items-center justify-center
                                text-emerald-600">

                        <svg class="w-5 h-5 sm:w-6 sm:h-6"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>

                    </div>

                    <div class="min-w-0">

                        <p class="text-xs sm:text-sm font-medium text-slate-500 truncate">
                            En Stock
                        </p>

                        <p class="mt-0.5 text-xl sm:text-2xl font-extrabold text-emerald-600">
                            {{ $produitsEnStock ?? 0 }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Rupture --}}
            <div class="group bg-white rounded-2xl border border-slate-200
                        shadow-sm hover:shadow-md transition-all duration-200
                        p-4 sm:p-5">

                <div class="flex items-center gap-3">

                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12
                                rounded-xl bg-amber-50
                                flex items-center justify-center
                                text-amber-600">

                        <svg class="w-5 h-5 sm:w-6 sm:h-6"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"/>
                        </svg>

                    </div>

                    <div class="min-w-0">

                        <p class="text-xs sm:text-sm font-medium text-slate-500 truncate">
                            En Rupture
                        </p>

                        <p class="mt-0.5 text-xl sm:text-2xl font-extrabold text-amber-600">
                            {{ $produitsRupture ?? 0 }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Stock bas --}}
            <div class="group bg-white rounded-2xl border border-slate-200
                        shadow-sm hover:shadow-md transition-all duration-200
                        p-4 sm:p-5">

                <div class="flex items-center gap-3">

                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12
                                rounded-xl bg-red-50
                                flex items-center justify-center
                                text-red-600">

                        <svg class="w-5 h-5 sm:w-6 sm:h-6"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"/>
                        </svg>

                    </div>

                    <div class="min-w-0">

                        <p class="text-xs sm:text-sm font-medium text-slate-500 truncate">
                            Stock Bas
                        </p>

                        <p class="mt-0.5 text-xl sm:text-2xl font-extrabold text-red-600">
                            {{ $produitsStockBas ?? 0 }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             FILTRES
        ====================================================== --}}
        <div class="bg-white rounded-2xl border border-slate-200
                    shadow-sm p-4 sm:p-6 mb-6">

            <div class="flex items-center gap-3 mb-4">

                <div class="w-9 h-9 rounded-lg bg-blue-50
                            flex items-center justify-center text-blue-600">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-8.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>

                </div>

                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-800">
                        Filtrer les mouvements
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-500">
                        Affinez les résultats selon le produit et le type.
                    </p>
                </div>

            </div>


            <form method="GET"
                  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- Produit --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Produit
                    </label>

                    <select
                        name="produit_id"
                        class="w-full rounded-xl border border-slate-300
                               bg-white px-3.5 py-2.5
                               text-sm text-slate-700
                               shadow-sm
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               outline-none transition">

                        <option value="">
                            Tous les produits
                        </option>

                        @foreach($produits as $produit)

                            <option value="{{ $produit->id }}"
                                {{ request('produit_id') == $produit->id ? 'selected' : '' }}>

                                {{ $produit->nom_produit }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Type --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Type de mouvement
                    </label>

                    <select
                        name="type"
                        class="w-full rounded-xl border border-slate-300
                               bg-white px-3.5 py-2.5
                               text-sm text-slate-700
                               shadow-sm
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               outline-none transition">

                        <option value="">
                            Tous les types
                        </option>

                        <option value="entree"
                            {{ request('type') == 'entree' ? 'selected' : '' }}>
                            Entrée
                        </option>

                        <option value="sortie"
                            {{ request('type') == 'sortie' ? 'selected' : '' }}>
                            Sortie
                        </option>

                    </select>

                </div>


                {{-- Bouton --}}
                <div class="flex items-end">

                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center
                               gap-2 rounded-xl
                               bg-blue-600 hover:bg-blue-700
                               active:bg-blue-800
                               text-white font-semibold
                               px-5 py-2.5
                               text-sm
                               shadow-sm hover:shadow
                               transition-all duration-200">

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/>

                        </svg>

                        Filtrer les résultats

                    </button>

                </div>

            </form>

        </div>


        {{-- =====================================================
             TABLEAU DES MOUVEMENTS
        ====================================================== --}}
        <div class="bg-white rounded-2xl border border-slate-200
                    shadow-sm overflow-hidden">

            {{-- En-tête --}}
            <div class="px-4 sm:px-6 py-4
                        border-b border-slate-200
                        flex flex-col sm:flex-row
                        sm:items-center sm:justify-between gap-2">

                <div>

                    <h2 class="text-base sm:text-lg font-bold text-slate-800">
                        Historique des mouvements
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        Liste des entrées et sorties enregistrées.
                    </p>

                </div>

                <div class="text-xs font-medium text-slate-500">
                    {{ $mouvements->total() }} mouvement(s)
                </div>

            </div>


            {{-- Scroll horizontal sur mobile --}}
            <div class="overflow-x-auto">

                <table class="min-w-[760px] w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-4 sm:px-6 py-3.5
                                       text-left text-xs font-bold
                                       text-slate-500 uppercase tracking-wider">
                                Produit
                            </th>

                            <th class="px-4 sm:px-6 py-3.5
                                       text-left text-xs font-bold
                                       text-slate-500 uppercase tracking-wider">
                                Type
                            </th>

                            <th class="px-4 sm:px-6 py-3.5
                                       text-left text-xs font-bold
                                       text-slate-500 uppercase tracking-wider">
                                Quantité
                            </th>

                            <th class="px-4 sm:px-6 py-3.5
                                       text-left text-xs font-bold
                                       text-slate-500 uppercase tracking-wider">
                                Date
                            </th>

                            <th class="px-4 sm:px-6 py-3.5
                                       text-left text-xs font-bold
                                       text-slate-500 uppercase tracking-wider">
                                Raison
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($mouvements as $mouvement)

                            <tr class="hover:bg-slate-50 transition-colors">

                                {{-- Produit --}}
                                <td class="px-4 sm:px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="w-9 h-9 rounded-lg
                                                    bg-slate-100
                                                    flex items-center justify-center
                                                    text-slate-600
                                                    flex-shrink-0">

                                            <svg class="w-4 h-4"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>

                                            </svg>

                                        </div>

                                        <span class="text-sm font-semibold text-slate-800">
                                            {{ $mouvement->produit->nom_produit ?? '-' }}
                                        </span>

                                    </div>

                                </td>


                                {{-- Type --}}
                                <td class="px-4 sm:px-6 py-4">

                                    @if($mouvement->type_mouvement === 'entree')

                                        <span class="inline-flex items-center gap-1.5
                                                     px-2.5 py-1
                                                     rounded-full
                                                     bg-emerald-50
                                                     text-emerald-700
                                                     text-xs font-bold">

                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                                            Entrée

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5
                                                     px-2.5 py-1
                                                     rounded-full
                                                     bg-red-50
                                                     text-red-700
                                                     text-xs font-bold">

                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>

                                            Sortie

                                        </span>

                                    @endif

                                </td>


                                {{-- Quantité --}}
                                <td class="px-4 sm:px-6 py-4">

                                    <span class="text-sm font-bold text-slate-800">
                                        {{ $mouvement->quantite }}
                                    </span>

                                    <span class="text-xs text-slate-400 ml-1">
                                        unité(s)
                                    </span>

                                </td>


                                {{-- Date --}}
                                <td class="px-4 sm:px-6 py-4">

                                    <div class="flex flex-col">

                                        <span class="text-sm font-medium text-slate-700">
                                            {{ $mouvement->date_mouvement->format('d/m/Y') }}
                                        </span>

                                        @if($mouvement->date_mouvement->format('H:i') !== '00:00')

                                            <span class="text-xs text-slate-400">
                                                {{ $mouvement->date_mouvement->format('H:i') }}
                                            </span>

                                        @endif

                                    </div>

                                </td>


                                {{-- Raison --}}
                                <td class="px-4 sm:px-6 py-4">

                                    <span class="text-sm text-slate-600">
                                        {{ $mouvement->raison ?: '—' }}
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-12">

                                    <div class="flex flex-col items-center justify-center text-center">

                                        <div class="w-14 h-14 rounded-2xl
                                                    bg-slate-100
                                                    flex items-center justify-center
                                                    text-slate-400 mb-4">

                                            <svg class="w-7 h-7"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="1.8"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

                                            </svg>

                                        </div>

                                        <h3 class="text-sm font-bold text-slate-700">
                                            Aucun mouvement trouvé
                                        </h3>

                                        <p class="text-xs text-slate-400 mt-1">
                                            Aucun mouvement ne correspond aux filtres sélectionnés.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($mouvements->hasPages())

                <div class="px-4 sm:px-6 py-4
                            bg-slate-50
                            border-t border-slate-200">

                    {{ $mouvements->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
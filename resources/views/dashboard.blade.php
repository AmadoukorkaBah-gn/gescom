
@extends('layouts.app')

@section('content')

<div class="w-full max-w-[1600px] mx-auto px-3 sm:px-5 lg:px-7 py-4 sm:py-6">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="mb-7">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>
                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-6 h-6 text-white"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3 13h4v8H3v-8zm7-10h4v18h-4V3zm7 6h4v12h-4V9z"/>
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                            Tableau de bord
                        </h1>

                        <p class="mt-1 text-sm text-gray-500">
                            Suivez vos ventes, votre trésorerie et votre stock en un coup d'œil.
                        </p>
                    </div>

                </div>
            </div>

            <div class="flex items-center gap-2 text-sm text-gray-600 bg-white border border-gray-200 px-4 py-2.5 rounded-xl shadow-sm">

                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>

                <span class="font-semibold">
                    {{ now()->translatedFormat('d F Y') }}
                </span>

            </div>

        </div>
    </div>


    {{-- =========================================================
         INDICATEURS FINANCIERS
         3 PAR LIGNE SUR DESKTOP
    ========================================================== --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-7">


        {{-- =====================================================
             TOTAL DES VENTES
        ====================================================== --}}

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 p-5 shadow-lg shadow-blue-200/70 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>
            <div class="absolute -right-5 -bottom-12 w-24 h-24 rounded-full bg-white/5"></div>

            <div class="relative flex items-start justify-between">

                <div>
                    <p class="text-sm font-semibold text-blue-100">
                        Chiffre D'affaire
                    </p>

                    <div class="mt-3">
                        <span class="text-2xl sm:text-3xl font-extrabold text-white">
                            {{ number_format($totalSales, 0, ',', ' ') }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs font-medium text-blue-100">
                        GNF
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.657 0 3 .895 3 2m-3-2V5m0 11v3m9-7a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- =====================================================
             VENTES DU JOUR
        ====================================================== --}}

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 via-green-600 to-teal-700 p-5 shadow-lg shadow-emerald-200/70 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>

            <div class="relative flex items-start justify-between">

                <div>
                    <p class="text-sm font-semibold text-emerald-100">
                        Ventes aujourd'hui
                    </p>

                    <div class="mt-3">
                        <span class="text-2xl sm:text-3xl font-extrabold text-white">
                            {{ number_format($todaySales, 0, ',', ' ') }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs font-medium text-emerald-100">
                        GNF
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 10h18M7 15h2m4 0h2m-9 4h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- =====================================================
             BÉNÉFICE DU JOUR
        ====================================================== --}}

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-violet-500 via-purple-600 to-fuchsia-700 p-5 shadow-lg shadow-purple-200/70 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>

            <div class="relative flex items-start justify-between">

                <div>
                    <p class="text-sm font-semibold text-purple-100">
                        Bénéfice aujourd'hui
                    </p>

                    <div class="mt-3">
                        <span class="text-2xl sm:text-3xl font-extrabold text-white">
                            {{ number_format($benefice, 0, ',', ' ') }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs font-medium text-purple-100">
                        GNF
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- =====================================================
             BÉNÉFICE TOTAL
        ====================================================== --}}

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500 via-indigo-600 to-blue-800 p-5 shadow-lg shadow-indigo-200/70 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>

            <div class="relative flex items-start justify-between">

                <div>
                    <p class="text-sm font-semibold text-indigo-100">
                        Bénéfice total
                    </p>

                    <div class="mt-3">
                        <span class="text-2xl sm:text-3xl font-extrabold text-white">
                            {{ number_format($beneficeTotal, 0, ',', ' ') }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs font-medium text-indigo-100">
                        GNF
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 3 3 3 3-.895 3-3-1.343-3-3-3zm0 0V5m0 11v3m9-7a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- =====================================================
             VALEUR DU STOCK
        ====================================================== --}}

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-cyan-500 via-sky-600 to-blue-700 p-5 shadow-lg shadow-cyan-200/70 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>

            <div class="relative flex items-start justify-between">

                <div>
                    <p class="text-sm font-semibold text-cyan-100">
                        Valeur du stock
                    </p>

                    <div class="mt-3">
                        <span class="text-2xl sm:text-3xl font-extrabold text-white">
                            {{ number_format($valeurStock, 0, ',', ' ') }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs font-medium text-cyan-100">
                        GNF au prix d'achat
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- =====================================================
             CRÉANCES
        ====================================================== --}}

        <div class="relative overflow-hidden rounded-2xl p-5 shadow-lg hover:-translate-y-1 hover:shadow-xl transition-all duration-300
            {{ $totalCreances > 0
                ? 'bg-gradient-to-br from-red-500 via-rose-600 to-red-700 shadow-red-200/70'
                : 'bg-gradient-to-br from-gray-500 via-gray-600 to-gray-800 shadow-gray-200/70' }}">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>

            <div class="relative flex items-start justify-between">

                <div>

                    <div class="flex items-center gap-2">

                        <p class="text-sm font-semibold text-white/90">
                            Créances
                        </p>

                        @if($totalCreances > 0)
                            <span class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[9px] font-bold uppercase">
                                À récupérer
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[9px] font-bold uppercase">
                                Soldé
                            </span>
                        @endif

                    </div>

                    <div class="mt-3">
                        <span class="text-2xl sm:text-3xl font-extrabold text-white">
                            {{ number_format($totalCreances, 0, ',', ' ') }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs font-medium text-white/80">
                        GNF restant à récupérer
                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         STOCK + PRODUITS LES PLUS VENDUS
         TOUJOURS SUR LA MÊME LIGNE SUR GRAND ÉCRAN
    ========================================================== --}}

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


        {{-- =====================================================
             STOCK À SURVEILLER
        ====================================================== --}}

        <div class="bg-white border border-orange-200 rounded-2xl shadow-lg shadow-orange-100/60 overflow-hidden">

            <div class="px-5 py-5 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">

                <div class="flex items-center justify-between gap-3">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-xl bg-orange-500 flex items-center justify-center shadow-md shadow-orange-200">

                            <svg class="w-6 h-6 text-white"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>

                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-gray-900">
                                Stock à surveiller
                            </h2>

                            <p class="text-xs text-gray-500 mt-1">
                                Produits proches du seuil minimum
                            </p>
                        </div>

                    </div>

                    @if($lowStockCount > 0)

                        <span class="px-3 py-1.5 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                            {{ $lowStockCount }}
                            {{ $lowStockCount > 1 ? 'produits' : 'produit' }}
                        </span>

                    @else

                        <span class="px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                            Stock OK
                        </span>

                    @endif

                </div>

            </div>


            @if($lowStockCount > 0)

                <div class="divide-y divide-gray-100">

                    @foreach($lowStockProducts as $product)

                        <div class="px-5 py-4 hover:bg-orange-50/50 transition">

                            <div class="flex items-center justify-between gap-4">

                                <div class="flex items-center gap-3 min-w-0">

                                    <div class="w-9 h-9 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">

                                        <svg class="w-4 h-4 text-orange-600"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                        </svg>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="font-bold text-sm text-gray-900 truncate">
                                            {{ $product->nom_produit }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            Seuil :
                                            <span class="font-semibold text-gray-700">
                                                {{ number_format($product->stock_minimum, 0, ',', ' ') }}
                                            </span>
                                        </p>

                                    </div>

                                </div>

                                <div class="text-right shrink-0">

                                    <p class="text-xl font-extrabold
                                        {{ $product->current_stock <= 0
                                            ? 'text-red-600'
                                            : 'text-orange-500' }}">

                                        {{ number_format($product->current_stock, 0, ',', ' ') }}

                                    </p>

                                    <p class="text-[10px] text-gray-400 font-medium">
                                        disponible
                                    </p>

                                </div>

                            </div>


                            @php
                                $minimum = max((float) $product->stock_minimum, 1);
                                $stock = max((float) $product->current_stock, 0);
                                $stockPercent = min(($stock / $minimum) * 100, 100);
                            @endphp

                            <div class="mt-3 h-2 w-full bg-gray-100 rounded-full overflow-hidden">

                                <div
                                    class="h-full rounded-full transition-all duration-500
                                        {{ $product->current_stock <= 0
                                            ? 'bg-red-500'
                                            : 'bg-orange-500' }}"
                                    style="width: {{ $stockPercent }}%">
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="px-5 py-14 text-center">

                    <div class="mx-auto w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center">

                        <svg class="w-7 h-7 text-emerald-600"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>

                    </div>

                    <p class="mt-4 text-sm font-bold text-gray-800">
                        Aucun stock critique
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Tous vos produits sont au-dessus du seuil minimum.
                    </p>

                </div>

            @endif

        </div>


        {{-- =====================================================
             PRODUITS LES PLUS VENDUS
        ====================================================== --}}

        <div class="bg-white border border-blue-200 rounded-2xl shadow-lg shadow-blue-100/60 overflow-hidden">

            <div class="px-5 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">

                <div class="flex items-center gap-3">

                    <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center shadow-md shadow-blue-200">

                        <svg class="w-6 h-6 text-white"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>

                    </div>

                    <div>

                        <h2 class="text-lg font-bold text-gray-900">
                            Produits les plus vendus
                        </h2>

                        <p class="text-xs text-gray-500 mt-1">
                            Classement par quantité vendue
                        </p>

                    </div>

                </div>

            </div>


            @if($topProducts->count())

                <div class="divide-y divide-gray-100">

                    @foreach($topProducts as $index => $product)

                        <div class="px-5 py-4 hover:bg-blue-50/40 transition">

                            <div class="flex items-center gap-3">

                                {{-- RANG --}}

                                <div class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center
                                    {{ $index === 0
                                        ? 'bg-gradient-to-br from-yellow-400 to-orange-500 text-white shadow-md shadow-orange-200'
                                        : ($index === 1
                                            ? 'bg-gradient-to-br from-gray-300 to-gray-500 text-white'
                                            : ($index === 2
                                                ? 'bg-gradient-to-br from-orange-300 to-orange-500 text-white'
                                                : 'bg-gray-100 text-gray-600')) }}">

                                    <span class="text-sm font-extrabold">
                                        {{ $index + 1 }}
                                    </span>

                                </div>


                                <div class="flex-1 min-w-0">

                                    <div class="flex items-center justify-between gap-3">

                                        <div class="min-w-0">

                                            <p class="font-bold text-sm text-gray-900 truncate">
                                                {{ $product->nom_produit }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">

                                                {{ number_format($product->total_vendu, 0, ',', ' ') }}

                                                {{ $product->total_vendu > 1
                                                    ? 'unités vendues'
                                                    : 'unité vendue' }}

                                            </p>

                                        </div>

                                        <div class="text-right shrink-0">

                                            <p class="font-extrabold text-sm text-gray-900">
                                                {{ number_format($product->total_revenue, 0, ',', ' ') }}
                                            </p>

                                            <p class="text-[10px] text-blue-500 font-semibold">
                                                GNF
                                            </p>

                                        </div>

                                    </div>


                                    <div class="mt-3 w-full h-2 bg-gray-100 rounded-full overflow-hidden">

                                        <div
                                            class="h-full bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-500 rounded-full transition-all duration-500"
                                            style="width: {{ max(5, $product->percentage) }}%">
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="px-5 py-14 text-center">

                    <div class="mx-auto w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center">

                        <svg class="w-7 h-7 text-blue-400"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>

                    </div>

                    <p class="mt-4 text-sm font-bold text-gray-700">
                        Aucune vente enregistrée
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Les produits vendus apparaîtront automatiquement ici.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection


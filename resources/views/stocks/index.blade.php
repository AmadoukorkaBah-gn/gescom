@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">

        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                    Gestion du stock
                </h1>

                <p class="mt-1 text-sm sm:text-base text-slate-500">
                    Consultez l'état actuel de vos stocks et identifiez rapidement les produits à réapprovisionner.
                </p>
            </div>

            <a
                href="{{ route('stocks.mouvements') }}"
                class="
                    inline-flex items-center justify-center gap-2
                    px-4 py-2.5
                    rounded-lg
                    bg-blue-600
                    text-white
                    text-sm font-semibold
                    shadow-sm
                    hover:bg-blue-700
                    focus:outline-none
                    focus:ring-2
                    focus:ring-blue-500
                    focus:ring-offset-2
                    transition
                "
            >
                <span class="text-base">📊</span>
                Voir les mouvements
            </a>

        </div>


        {{-- =========================================================
             STATISTIQUES
        ========================================================== --}}

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-6">

            {{-- Total produits --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-5">

                <div class="flex items-center gap-3">

                    <div class="
                        flex-shrink-0
                        w-10 h-10
                        sm:w-11 sm:h-11
                        rounded-lg
                        bg-slate-100
                        flex items-center justify-center
                        text-xl
                    ">
                        📦
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">
                            Total produits
                        </p>

                        <p class="mt-1 text-xl sm:text-2xl font-bold text-slate-800">
                            {{ $totalProduits }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- En stock --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-5">

                <div class="flex items-center gap-3">

                    <div class="
                        flex-shrink-0
                        w-10 h-10
                        sm:w-11 sm:h-11
                        rounded-lg
                        bg-green-50
                        flex items-center justify-center
                        text-xl
                    ">
                        ✅
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">
                            En stock
                        </p>

                        <p class="mt-1 text-xl sm:text-2xl font-bold text-green-600">
                            {{ $produitsEnStock }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- Rupture --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-5">

                <div class="flex items-center gap-3">

                    <div class="
                        flex-shrink-0
                        w-10 h-10
                        sm:w-11 sm:h-11
                        rounded-lg
                        bg-amber-50
                        flex items-center justify-center
                        text-xl
                    ">
                        ⚠️
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">
                            En rupture
                        </p>

                        <p class="mt-1 text-xl sm:text-2xl font-bold text-amber-600">
                            {{ $produitsRupture }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- Stock bas --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-5">

                <div class="flex items-center gap-3">

                    <div class="
                        flex-shrink-0
                        w-10 h-10
                        sm:w-11 sm:h-11
                        rounded-lg
                        bg-red-50
                        flex items-center justify-center
                        text-xl
                    ">
                        🔻
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">
                            Stock bas
                        </p>

                        <p class="mt-1 text-xl sm:text-2xl font-bold text-red-600">
                            {{ $produitsStockBas }}
                        </p>
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             RECHERCHE
        ========================================================== --}}

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm mb-5">

            <div class="p-4 sm:p-5">

                <form
                    method="GET"
                    action="{{ route('stocks.index') }}"
                    class="flex flex-col sm:flex-row gap-3"
                >

                    <div class="relative flex-1">

                        <span class="
                            absolute
                            left-3
                            top-1/2
                            -translate-y-1/2
                            text-slate-400
                        ">
                            🔎
                        </span>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Rechercher un produit..."
                            class="
                                w-full
                                pl-10 pr-4
                                py-2.5
                                rounded-lg
                                border border-slate-300
                                bg-white
                                text-sm
                                text-slate-700
                                placeholder-slate-400
                                focus:border-blue-500
                                focus:ring-2
                                focus:ring-blue-500/20
                                focus:outline-none
                                transition
                            "
                        >

                    </div>

                    <button
                        type="submit"
                        class="
                            inline-flex items-center justify-center gap-2
                            px-5 py-2.5
                            rounded-lg
                            bg-slate-700
                            text-white
                            text-sm font-semibold
                            hover:bg-slate-800
                            focus:outline-none
                            focus:ring-2
                            focus:ring-slate-500
                            focus:ring-offset-2
                            transition
                        "
                    >
                        🔍 Rechercher
                    </button>

                </form>

            </div>

        </div>


        {{-- =========================================================
             TABLEAU
        ========================================================== --}}

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

            {{-- En-tête du tableau --}}
            <div class="px-4 sm:px-6 py-4 border-b border-slate-200">

                <div class="flex items-center gap-2">

                    <span class="text-xl">
                        📦
                    </span>

                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-800">
                            État des stocks
                        </h2>

                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                            Liste des produits et niveaux de stock actuels
                        </p>
                    </div>

                </div>

            </div>


            {{-- Scroll horizontal sur petits écrans --}}
            <div class="overflow-x-auto">

                <table class="min-w-[1000px] w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="
                                px-5 py-3
                                text-left
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                            ">
                                #
                            </th>

                            <th class="
                                px-5 py-3
                                text-left
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                            ">
                                Produit
                            </th>

                            <th class="
                                px-5 py-3
                                text-left
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                            ">
                                Catégorie
                            </th>

                            <th class="
                                px-5 py-3
                                text-left
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                            ">
                                Fournisseur
                            </th>

                            <th class="
                                px-5 py-3
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                            ">
                                Stock actuel
                            </th>

                            <th class="
                                px-5 py-3
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                            ">
                                Stock minimum
                            </th>

                            <th class="
                                px-5 py-3
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                            ">
                                État
                            </th>

                            <th class="
                                px-5 py-3
                                text-right
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                            ">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="bg-white divide-y divide-slate-100">

                        @forelse($produits as $produit)

                            <tr
                                class="
                                    transition
                                    hover:bg-slate-50
                                    {{ $produit->stock_actuel < $produit->stock_minimum
                                        ? 'bg-red-50/50'
                                        : ($produit->stock_actuel == 0
                                            ? 'bg-yellow-50/50'
                                            : '') }}
                                "
                            >

                                {{-- ID --}}
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- Produit --}}
                                <td class="px-5 py-4 whitespace-nowrap">

                                    <div class="text-sm font-semibold text-slate-800">
                                        {{ $produit->nom_produit }}
                                    </div>

                                </td>


                                {{-- Catégorie --}}
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ $produit->categorie->nom_categorie ?? '-' }}
                                </td>


                                {{-- Fournisseur --}}
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ $produit->fournisseur->nom_fournisseur ?? '-' }}
                                </td>


                                {{-- Stock actuel --}}
                                <td class="px-5 py-4 whitespace-nowrap text-center">

                                    <span
                                        class="
                                            inline-flex items-center justify-center
                                            min-w-[45px]
                                            px-3 py-1.5
                                            rounded-lg
                                            text-sm font-bold
                                            {{ $produit->stock_actuel < $produit->stock_minimum
                                                ? 'bg-red-100 text-red-700'
                                                : ($produit->stock_actuel == 0
                                                    ? 'bg-yellow-100 text-yellow-700'
                                                    : 'bg-blue-50 text-blue-700') }}
                                        "
                                    >
                                        {{ $produit->stock_actuel }}
                                    </span>

                                </td>


                                {{-- Stock minimum --}}
                                <td class="px-5 py-4 whitespace-nowrap text-center">

                                    <span class="text-sm font-medium text-slate-600">
                                        {{ $produit->stock_minimum }}
                                    </span>

                                </td>


                                {{-- État --}}
                                <td class="px-5 py-4 whitespace-nowrap text-center">

                                    @if($produit->stock_actuel == 0)

                                        <span class="
                                            inline-flex items-center gap-1.5
                                            px-3 py-1.5
                                            rounded-full
                                            bg-yellow-100
                                            text-yellow-800
                                            text-xs
                                            font-bold
                                        ">
                                            <span>●</span>
                                            Rupture
                                        </span>

                                    @elseif($produit->stock_actuel < $produit->stock_minimum)

                                        <span class="
                                            inline-flex items-center gap-1.5
                                            px-3 py-1.5
                                            rounded-full
                                            bg-red-100
                                            text-red-800
                                            text-xs
                                            font-bold
                                        ">
                                            <span>●</span>
                                            Stock bas
                                        </span>

                                    @else

                                        <span class="
                                            inline-flex items-center gap-1.5
                                            px-3 py-1.5
                                            rounded-full
                                            bg-green-100
                                            text-green-800
                                            text-xs
                                            font-bold
                                        ">
                                            <span>●</span>
                                            OK
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-5 py-4 whitespace-nowrap">

                                    <div class="flex items-center justify-end gap-2">

                                        <a
                                            href="{{ route('produits.show', $produit) }}"
                                            class="
                                                inline-flex items-center gap-1
                                                px-3 py-1.5
                                                rounded-lg
                                                bg-blue-50
                                                text-blue-700
                                                text-xs font-semibold
                                                hover:bg-blue-100
                                                transition
                                            "
                                        >
                                            👁 Voir
                                        </a>

                                        <a
                                            href="{{ route('produits.edit', $produit) }}"
                                            class="
                                                inline-flex items-center gap-1
                                                px-3 py-1.5
                                                rounded-lg
                                                bg-amber-50
                                                text-amber-700
                                                text-xs font-semibold
                                                hover:bg-amber-100
                                                transition
                                            "
                                        >
                                            ✏️ Modifier
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="px-6 py-12 text-center"
                                >

                                    <div class="text-4xl mb-3">
                                        📦
                                    </div>

                                    <p class="text-sm font-semibold text-slate-700">
                                        Aucun produit trouvé
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Aucun produit ne correspond à votre recherche.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
                 PAGINATION
            ====================================================== --}}

            <div class="
                px-4 sm:px-6
                py-4
                bg-slate-50
                border-t border-slate-200
                overflow-x-auto
            ">

                {{ $produits->appends(request()->query())->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
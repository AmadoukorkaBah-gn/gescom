@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">

        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-blue-100 text-blue-600 text-xl">
                        📆
                    </div>

                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800">
                            Ventes par période
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Analysez les ventes réalisées entre deux dates.
                        </p>
                    </div>
                </div>
            </div>

        </div>


        {{-- =========================================================
             FILTRES
        ========================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 mb-6">

            <div class="flex items-center gap-3 mb-5">

                <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 text-blue-600">
                    🔎
                </div>

                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-800">
                        Filtrer les ventes
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-500">
                        Sélectionnez une période pour afficher les résultats.
                    </p>
                </div>

            </div>


            <form method="GET">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- Date début --}}
                    <div>

                        <label
                            for="date_debut"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Date début
                        </label>

                        <input
                            type="date"
                            id="date_debut"
                            name="date_debut"
                            value="{{ $dateDebut }}"
                            class="
                                w-full
                                px-4 py-2.5
                                rounded-xl
                                border border-slate-300
                                bg-white
                                text-sm text-slate-700
                                shadow-sm
                                focus:outline-none
                                focus:border-blue-500
                                focus:ring-2
                                focus:ring-blue-100
                                transition
                            "
                        >

                    </div>


                    {{-- Date fin --}}
                    <div>

                        <label
                            for="date_fin"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Date fin
                        </label>

                        <input
                            type="date"
                            id="date_fin"
                            name="date_fin"
                            value="{{ $dateFin }}"
                            class="
                                w-full
                                px-4 py-2.5
                                rounded-xl
                                border border-slate-300
                                bg-white
                                text-sm text-slate-700
                                shadow-sm
                                focus:outline-none
                                focus:border-blue-500
                                focus:ring-2
                                focus:ring-blue-100
                                transition
                            "
                        >

                    </div>


                    {{-- Bouton --}}
                    <div class="sm:col-span-2 lg:col-span-2 flex items-end">

                        <button
                            type="submit"
                            class="
                                w-full
                                inline-flex
                                items-center
                                justify-center
                                gap-2
                                px-5
                                py-2.5
                                rounded-xl
                                bg-blue-600
                                hover:bg-blue-700
                                active:scale-[.98]
                                text-white
                                text-sm
                                font-bold
                                shadow-sm
                                hover:shadow-md
                                transition
                            "
                        >
                            <span>🔍</span>
                            <span>Filtrer les ventes</span>
                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- =========================================================
             STATISTIQUES
        ========================================================== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">

            {{-- Total ventes --}}
            <div
                class="
                    relative
                    overflow-hidden
                    bg-gradient-to-br
                    from-blue-600
                    to-blue-700
                    rounded-2xl
                    shadow-lg
                    p-5 sm:p-6
                    text-white
                "
            >

                <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10"></div>

                <div class="relative">

                    <div class="flex items-center justify-between mb-4">

                        <div>
                            <p class="text-sm font-medium text-blue-100">
                                Total des ventes
                            </p>

                            <p class="text-xs text-blue-200 mt-1">
                                Ventes réalisées
                            </p>
                        </div>

                        <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center text-xl">
                            🛒
                        </div>

                    </div>

                    <div class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                        {{ $totalVentes }}
                    </div>

                    <div class="mt-3 text-xs text-blue-100">
                        Sur la période sélectionnée
                    </div>

                </div>

            </div>


            {{-- Montant total --}}
            <div
                class="
                    relative
                    overflow-hidden
                    bg-gradient-to-br
                    from-emerald-600
                    to-emerald-700
                    rounded-2xl
                    shadow-lg
                    p-5 sm:p-6
                    text-white
                "
            >

                <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10"></div>

                <div class="relative">

                    <div class="flex items-center justify-between mb-4">

                        <div>
                            <p class="text-sm font-medium text-emerald-100">
                                Montant total
                            </p>

                            <p class="text-xs text-emerald-200 mt-1">
                                Chiffre d'affaires
                            </p>
                        </div>

                        <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center text-xl">
                            💰
                        </div>

                    </div>

                    <div class="text-2xl sm:text-4xl font-extrabold tracking-tight break-words">
                        {{ number_format($totalMontant, 2, ',', ' ') }}
                        <span class="text-lg sm:text-xl font-bold">GNF</span>
                    </div>

                    <div class="mt-3 text-xs text-emerald-100">
                        Total généré sur la période
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             TABLEAU DES VENTES
        ========================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- En-tête --}}
            <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                    <div>

                        <h2 class="text-lg sm:text-xl font-bold text-slate-800">
                            Détail des ventes
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Résultats regroupés par date.
                        </p>

                    </div>

                    <div
                        class="
                            inline-flex
                            items-center
                            self-start
                            px-3
                            py-1.5
                            rounded-lg
                            bg-slate-100
                            text-slate-600
                            text-xs
                            font-semibold
                        "
                    >
                        {{ $totalVentes }} vente(s)
                    </div>

                </div>

            </div>


            {{-- =====================================================
                 DESKTOP / TABLETTE
            ====================================================== --}}
            <div class="hidden md:block overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th
                                class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    text-slate-500
                                    uppercase
                                    tracking-wider
                                "
                            >
                                Date
                            </th>

                            <th
                                class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    text-slate-500
                                    uppercase
                                    tracking-wider
                                "
                            >
                                Nombre de ventes
                            </th>

                            <th
                                class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    text-slate-500
                                    uppercase
                                    tracking-wider
                                "
                            >
                                Montant total
                            </th>

                            <th
                                class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    text-slate-500
                                    uppercase
                                    tracking-wider
                                "
                            >
                                Montant moyen
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($ventes as $vente)

                            <tr class="hover:bg-slate-50 transition">

                                {{-- Date --}}
                                <td class="px-6 py-4 whitespace-nowrap">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="
                                                w-9 h-9
                                                rounded-lg
                                                bg-blue-50
                                                text-blue-600
                                                flex items-center
                                                justify-center
                                                text-sm
                                            "
                                        >
                                            📅
                                        </div>

                                        <span class="text-sm font-semibold text-slate-800">
                                            {{ \Carbon\Carbon::parse($vente['date'])->format('d/m/Y') }}
                                        </span>

                                    </div>

                                </td>


                                {{-- Nombre --}}
                                <td class="px-6 py-4 whitespace-nowrap">

                                    <span
                                        class="
                                            inline-flex
                                            items-center
                                            px-3
                                            py-1.5
                                            rounded-lg
                                            bg-blue-50
                                            text-blue-700
                                            text-sm
                                            font-bold
                                        "
                                    >
                                        {{ $vente['nombre_ventes'] }}
                                    </span>

                                </td>


                                {{-- Total --}}
                                <td class="px-6 py-4 whitespace-nowrap">

                                    <span class="text-sm font-bold text-emerald-600">
                                        {{ number_format($vente['total_montant'], 2, ',', ' ') }}
                                        GNF
                                    </span>

                                </td>


                                {{-- Moyenne --}}
                                <td class="px-6 py-4 whitespace-nowrap">

                                    <span class="text-sm font-medium text-slate-600">
                                        {{ number_format($vente['total_montant'] / $vente['nombre_ventes'], 2, ',', ' ') }}
                                        GNF
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="px-6 py-14 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="
                                                w-14 h-14
                                                rounded-full
                                                bg-slate-100
                                                flex items-center
                                                justify-center
                                                text-2xl
                                                mb-4
                                            "
                                        >
                                            📊
                                        </div>

                                        <p class="font-bold text-slate-700">
                                            Aucune vente trouvée
                                        </p>

                                        <p class="text-sm text-slate-500 mt-1">
                                            Aucune donnée ne correspond à cette période.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
                 MOBILE
            ====================================================== --}}
            <div class="md:hidden divide-y divide-slate-100">

                @forelse($ventes as $vente)

                    <div class="p-4">

                        {{-- Date --}}
                        <div class="flex items-center justify-between gap-3 mb-4">

                            <div class="flex items-center gap-3 min-w-0">

                                <div
                                    class="
                                        flex-shrink-0
                                        w-10 h-10
                                        rounded-xl
                                        bg-blue-50
                                        text-blue-600
                                        flex items-center
                                        justify-center
                                    "
                                >
                                    📅
                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs text-slate-500">
                                        Date
                                    </p>

                                    <p class="font-bold text-slate-800">
                                        {{ \Carbon\Carbon::parse($vente['date'])->format('d/m/Y') }}
                                    </p>

                                </div>

                            </div>


                            <span
                                class="
                                    flex-shrink-0
                                    inline-flex
                                    items-center
                                    px-2.5
                                    py-1
                                    rounded-lg
                                    bg-blue-50
                                    text-blue-700
                                    text-xs
                                    font-bold
                                "
                            >
                                {{ $vente['nombre_ventes'] }} vente(s)
                            </span>

                        </div>


                        {{-- Informations --}}
                        <div class="grid grid-cols-1 gap-3">

                            <div class="rounded-xl bg-slate-50 p-3">

                                <p class="text-xs text-slate-500">
                                    Montant total
                                </p>

                                <p class="mt-1 text-base font-extrabold text-emerald-600">
                                    {{ number_format($vente['total_montant'], 2, ',', ' ') }}
                                    GNF
                                </p>

                            </div>


                            <div class="rounded-xl bg-slate-50 p-3">

                                <p class="text-xs text-slate-500">
                                    Montant moyen par vente
                                </p>

                                <p class="mt-1 text-sm font-bold text-slate-700">
                                    {{ number_format($vente['total_montant'] / $vente['nombre_ventes'], 2, ',', ' ') }}
                                    GNF
                                </p>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="px-6 py-14 text-center">

                        <div
                            class="
                                w-14 h-14
                                mx-auto
                                rounded-full
                                bg-slate-100
                                flex items-center
                                justify-center
                                text-2xl
                                mb-4
                            "
                        >
                            📊
                        </div>

                        <p class="font-bold text-slate-700">
                            Aucune vente trouvée
                        </p>

                        <p class="text-sm text-slate-500 mt-1">
                            Aucune donnée ne correspond à cette période.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- =========================================================
             RÉINITIALISER
        ========================================================== --}}
        <div class="mt-5 flex justify-end">

            <a
                href="{{ route('rapports.ventes-par-periode') }}"
                class="
                    inline-flex
                    items-center
                    gap-2
                    px-4
                    py-2.5
                    rounded-xl
                    border
                    border-slate-300
                    bg-white
                    text-slate-600
                    text-sm
                    font-semibold
                    hover:bg-slate-50
                    hover:text-blue-600
                    transition
                    shadow-sm
                "
            >
                <span>↺</span>
                <span>Réinitialiser les filtres</span>
            </a>

        </div>

    </div>

</div>

@endsection
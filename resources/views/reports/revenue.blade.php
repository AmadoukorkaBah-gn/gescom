@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 sm:py-8 px-3 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="mb-6 sm:mb-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-blue-600 flex items-center justify-center shadow-sm">
                            <span class="text-xl sm:text-2xl">💰</span>
                        </div>

                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-800">
                                Chiffre d'affaires
                            </h1>

                            <p class="text-sm text-slate-500 mt-1">
                                Analyse et évolution de votre activité commerciale
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        {{-- =====================================================
             FILTRE
        ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-5 mb-6">

            <form method="GET">

                <div class="flex flex-col sm:flex-row sm:items-end gap-4">

                    <div class="w-full sm:max-w-sm">

                        <label
                            for="periode"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Période d'analyse
                        </label>

                        <select
                            id="periode"
                            name="periode"
                            onchange="this.form.submit()"
                            class="w-full px-4 py-2.5
                                   bg-white
                                   border border-slate-300
                                   rounded-xl
                                   text-sm text-slate-700
                                   font-medium
                                   focus:outline-none
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-100
                                   transition"
                        >

                            <option value="daily" {{ $periode === 'daily' ? 'selected' : '' }}>
                                📅 Quotidien — 30 derniers jours
                            </option>

                            <option value="weekly" {{ $periode === 'weekly' ? 'selected' : '' }}>
                                📊 Hebdomadaire — 12 dernières semaines
                            </option>

                            <option value="monthly" {{ $periode === 'monthly' ? 'selected' : '' }}>
                                📈 Mensuel — 12 derniers mois
                            </option>

                            <option value="yearly" {{ $periode === 'yearly' ? 'selected' : '' }}>
                                📉 Annuel — 5 dernières années
                            </option>

                        </select>

                    </div>

                </div>

            </form>

        </div>


        {{-- =====================================================
             STATISTIQUES
        ====================================================== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">

            {{-- CA TOTAL --}}
            <div class="relative overflow-hidden
                        bg-gradient-to-br from-violet-600 to-purple-700
                        rounded-2xl
                        shadow-lg
                        p-5 sm:p-6
                        text-white">

                <div class="absolute -right-8 -top-8
                            w-28 h-28
                            bg-white/10
                            rounded-full">
                </div>

                <div class="absolute -right-12 -bottom-12
                            w-36 h-36
                            bg-white/5
                            rounded-full">
                </div>

                <div class="relative">

                    <div class="flex items-center justify-between gap-3 mb-4">

                        <div>
                            <p class="text-sm font-medium text-white/80">
                                Chiffre d'affaires total
                            </p>

                            <p class="text-xs text-white/60 mt-1">
                                Période sélectionnée
                            </p>
                        </div>

                        <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center">
                            <span class="text-lg">💰</span>
                        </div>

                    </div>

                    <div class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight break-words">
                        {{ number_format($totalRevenue, 0, ',', ' ') }}
                        <span class="text-base sm:text-lg font-semibold text-white/80">
                            GNF
                        </span>
                    </div>

                </div>

            </div>


            {{-- MOYENNE --}}
            <div class="relative overflow-hidden
                        bg-gradient-to-br from-pink-500 to-rose-600
                        rounded-2xl
                        shadow-lg
                        p-5 sm:p-6
                        text-white">

                <div class="absolute -right-8 -top-8
                            w-28 h-28
                            bg-white/10
                            rounded-full">
                </div>

                <div class="absolute -right-12 -bottom-12
                            w-36 h-36
                            bg-white/5
                            rounded-full">
                </div>

                <div class="relative">

                    <div class="flex items-center justify-between gap-3 mb-4">

                        <div>
                            <p class="text-sm font-medium text-white/80">
                                Moyenne par période
                            </p>

                            <p class="text-xs text-white/60 mt-1">

                                @switch($periode)

                                    @case('daily')
                                        Par jour
                                    @break

                                    @case('weekly')
                                        Par semaine
                                    @break

                                    @case('monthly')
                                        Par mois
                                    @break

                                    @case('yearly')
                                        Par année
                                    @break

                                @endswitch

                            </p>
                        </div>

                        <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center">
                            <span class="text-lg">📊</span>
                        </div>

                    </div>

                    <div class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight break-words">
                        {{ number_format($averageRevenue, 0, ',', ' ') }}
                        <span class="text-base sm:text-lg font-semibold text-white/80">
                            GNF
                        </span>
                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             ÉVOLUTION DU CA
        ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6 mb-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

                <div>

                    <h2 class="text-lg sm:text-xl font-bold text-slate-800">
                        Évolution du chiffre d'affaires
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Visualisation des ventes sur la période sélectionnée
                    </p>

                </div>

                <div class="inline-flex items-center gap-2
                            px-3 py-1.5
                            rounded-lg
                            bg-blue-50
                            text-blue-700
                            text-xs font-semibold
                            w-fit">

                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>

                    Données commerciales

                </div>

            </div>


            @if(count($data) > 0)

                <div class="space-y-5">

                    @php
                        $maxValue = collect($data)->max('total');
                    @endphp

                    @foreach($data as $item)

                        @php
                            $total = (float) $item['total'];
                            $max = max((float) $maxValue, 1);
                            $percent = ($total / $max) * 100;
                        @endphp

                        <div>

                            {{-- Ligne informations --}}
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">

                                <span class="text-sm font-semibold text-slate-700">
                                    {{ $item['label'] }}
                                </span>

                                <div class="flex flex-wrap items-center gap-2">

                                    <span class="text-sm font-bold text-slate-800">
                                        {{ number_format($item['total'], 0, ',', ' ') }} GNF
                                    </span>

                                    <span class="inline-flex items-center
                                                 px-2 py-1
                                                 rounded-full
                                                 bg-slate-100
                                                 text-slate-600
                                                 text-xs font-semibold">

                                        {{ $item['nombre'] }}
                                        {{ $item['nombre'] > 1 ? 'ventes' : 'vente' }}

                                    </span>

                                </div>

                            </div>


                            {{-- Barre --}}
                            <div class="w-full h-7 sm:h-8
                                        bg-slate-100
                                        rounded-xl
                                        overflow-hidden">

                                <div
                                    class="h-full
                                           bg-gradient-to-r from-blue-500 to-blue-600
                                           rounded-xl
                                           flex items-center justify-end
                                           px-2 sm:px-3
                                           text-white
                                           text-xs
                                           font-bold
                                           transition-all duration-500"
                                    @style(['width' => max($percent, 2) . '%'])
                                >

                                    @if($percent > 30)
                                        {{ round($percent) }}%
                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="py-12 text-center">

                    <div class="w-16 h-16 mx-auto
                                rounded-2xl
                                bg-slate-100
                                flex items-center justify-center
                                text-3xl
                                mb-4">
                        📊
                    </div>

                    <h3 class="font-semibold text-slate-700">
                        Aucune donnée disponible
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Aucune vente n'a été enregistrée pour cette période.
                    </p>

                </div>

            @endif

        </div>


        {{-- =====================================================
             TABLEAU DÉTAILLÉ
        ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- En-tête tableau --}}
            <div class="p-4 sm:p-6 border-b border-slate-200">

                <h2 class="text-lg sm:text-xl font-bold text-slate-800">
                    Détail des performances
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Résumé des ventes par période
                </p>

            </div>


            {{-- DESKTOP --}}
            <div class="hidden md:block overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th class="px-6 py-4 text-left
                                       text-xs font-bold
                                       text-slate-500
                                       uppercase tracking-wider">
                                Période
                            </th>

                            <th class="px-6 py-4 text-right
                                       text-xs font-bold
                                       text-slate-500
                                       uppercase tracking-wider">
                                Chiffre d'affaires
                            </th>

                            <th class="px-6 py-4 text-center
                                       text-xs font-bold
                                       text-slate-500
                                       uppercase tracking-wider">
                                Nombre de ventes
                            </th>

                            <th class="px-6 py-4 text-right
                                       text-xs font-bold
                                       text-slate-500
                                       uppercase tracking-wider">
                                CA moyen
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($data as $item)

                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4">

                                    <div class="font-semibold text-slate-800">
                                        {{ $item['label'] }}
                                    </div>

                                </td>


                                <td class="px-6 py-4 text-right">

                                    <span class="font-bold text-emerald-600">
                                        {{ number_format($item['total'], 0, ',', ' ') }}
                                        GNF
                                    </span>

                                </td>


                                <td class="px-6 py-4 text-center">

                                    <span class="inline-flex items-center
                                                 justify-center
                                                 min-w-10
                                                 px-3 py-1.5
                                                 rounded-full
                                                 bg-amber-50
                                                 text-amber-700
                                                 text-sm
                                                 font-bold">

                                        {{ $item['nombre'] }}

                                    </span>

                                </td>


                                <td class="px-6 py-4 text-right">

                                    <span class="text-sm font-semibold text-slate-700">

                                        {{ $item['nombre'] > 0
                                            ? number_format(
                                                $item['total'] / $item['nombre'],
                                                0,
                                                ',',
                                                ' '
                                            )
                                            : 0
                                        }}

                                        GNF

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="px-6 py-12 text-center">

                                    <div class="w-14 h-14 mx-auto
                                                rounded-xl
                                                bg-slate-100
                                                flex items-center justify-center
                                                text-2xl
                                                mb-3">
                                        📋
                                    </div>

                                    <p class="font-semibold text-slate-700">
                                        Aucune donnée disponible
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Les performances apparaîtront ici lorsque des ventes seront enregistrées.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 MOBILE
            ================================================== --}}
            <div class="md:hidden divide-y divide-slate-100">

                @forelse($data as $item)

                    <div class="p-4">

                        <div class="flex items-start justify-between gap-3 mb-4">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Période
                                </p>

                                <h3 class="font-bold text-slate-800 mt-1">
                                    {{ $item['label'] }}
                                </h3>

                            </div>

                            <span class="inline-flex items-center
                                         px-2.5 py-1
                                         rounded-full
                                         bg-amber-50
                                         text-amber-700
                                         text-xs font-bold">

                                {{ $item['nombre'] }}
                                {{ $item['nombre'] > 1 ? 'ventes' : 'vente' }}

                            </span>

                        </div>


                        <div class="grid grid-cols-1 gap-3">

                            {{-- CA --}}
                            <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-3">

                                <p class="text-xs text-emerald-600 font-medium">
                                    Chiffre d'affaires
                                </p>

                                <p class="text-lg font-bold text-emerald-700 mt-1">
                                    {{ number_format($item['total'], 0, ',', ' ') }}
                                    GNF
                                </p>

                            </div>


                            {{-- CA moyen --}}
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-3">

                                <p class="text-xs text-slate-500 font-medium">
                                    CA moyen
                                </p>

                                <p class="text-lg font-bold text-slate-700 mt-1">

                                    {{ $item['nombre'] > 0
                                        ? number_format(
                                            $item['total'] / $item['nombre'],
                                            0,
                                            ',',
                                            ' '
                                        )
                                        : 0
                                    }}

                                    GNF

                                </p>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        <div class="w-14 h-14 mx-auto
                                    rounded-xl
                                    bg-slate-100
                                    flex items-center justify-center
                                    text-2xl
                                    mb-3">
                            📋
                        </div>

                        <p class="font-semibold text-slate-700">
                            Aucune donnée disponible
                        </p>

                        <p class="text-sm text-slate-500 mt-1">
                            Aucune vente enregistrée pour cette période.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection
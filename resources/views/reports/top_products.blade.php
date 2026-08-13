@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}

        <div class="mb-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800">
                        🔥 Produits les Plus Vendus
                    </h1>

                    <p class="mt-1 text-sm sm:text-base text-slate-500">
                        Analysez les produits ayant enregistré les meilleures ventes.
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
             FILTRES
        ====================================================== --}}

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 sm:p-6 mb-6">

            <div class="flex items-center gap-3 mb-5">

                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-blue-600 text-lg">
                    🔎
                </div>

                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Filtrer les résultats
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-500">
                        Sélectionnez la période et le nombre de produits à afficher.
                    </p>
                </div>

            </div>


            <form method="GET"
                  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Date début --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Date début
                    </label>

                    <input
                        type="date"
                        name="date_debut"
                        value="{{ $dateDebut }}"
                        class="w-full h-11 px-3 rounded-xl
                               border border-slate-300
                               bg-white
                               text-sm text-slate-700
                               shadow-sm
                               focus:border-blue-500
                               focus:ring-2
                               focus:ring-blue-100
                               outline-none
                               transition"
                    >

                </div>


                {{-- Date fin --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Date fin
                    </label>

                    <input
                        type="date"
                        name="date_fin"
                        value="{{ $dateFin }}"
                        class="w-full h-11 px-3 rounded-xl
                               border border-slate-300
                               bg-white
                               text-sm text-slate-700
                               shadow-sm
                               focus:border-blue-500
                               focus:ring-2
                               focus:ring-blue-100
                               outline-none
                               transition"
                    >

                </div>


                {{-- Limite --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nombre de produits
                    </label>

                    <select
                        name="limite"
                        class="w-full h-11 px-3 rounded-xl
                               border border-slate-300
                               bg-white
                               text-sm text-slate-700
                               shadow-sm
                               focus:border-blue-500
                               focus:ring-2
                               focus:ring-blue-100
                               outline-none
                               transition"
                    >

                        <option value="5" {{ $limite == 5 ? 'selected' : '' }}>
                            Top 5
                        </option>

                        <option value="10" {{ $limite == 10 ? 'selected' : '' }}>
                            Top 10
                        </option>

                        <option value="20" {{ $limite == 20 ? 'selected' : '' }}>
                            Top 20
                        </option>

                        <option value="50" {{ $limite == 50 ? 'selected' : '' }}>
                            Top 50
                        </option>

                    </select>

                </div>


                {{-- Bouton --}}
                <div class="flex items-end">

                    <button
                        type="submit"
                        class="w-full h-11
                               inline-flex items-center justify-center gap-2
                               rounded-xl
                               bg-blue-600
                               hover:bg-blue-700
                               active:bg-blue-800
                               text-white
                               text-sm font-bold
                               shadow-sm
                               transition"
                    >
                        🔍
                        Filtrer
                    </button>

                </div>

            </form>

        </div>


        {{-- =====================================================
             TABLEAU DES PRODUITS
        ====================================================== --}}

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

            {{-- En-tête --}}
            <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                <h2 class="text-lg sm:text-xl font-bold text-slate-800">
                    Classement des produits
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Produits classés selon les quantités vendues.
                </p>

            </div>


            {{-- ================= DESKTOP ================= --}}

            <div class="hidden md:block overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Rang
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Produit
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Quantité vendue
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Nombre de ventes
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold
                                       uppercase tracking-wider text-slate-500">
                                Chiffre d'affaires
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($produits as $index => $produit)

                            <tr class="hover:bg-slate-50 transition">

                                {{-- Rang --}}
                                <td class="px-6 py-4">

                                    @if($index + 1 === 1)

                                        <span class="inline-flex items-center justify-center
                                                     w-10 h-10 rounded-xl
                                                     bg-yellow-50
                                                     text-lg">
                                            🥇
                                        </span>

                                    @elseif($index + 1 === 2)

                                        <span class="inline-flex items-center justify-center
                                                     w-10 h-10 rounded-xl
                                                     bg-slate-100
                                                     text-lg">
                                            🥈
                                        </span>

                                    @elseif($index + 1 === 3)

                                        <span class="inline-flex items-center justify-center
                                                     w-10 h-10 rounded-xl
                                                     bg-orange-50
                                                     text-lg">
                                            🥉
                                        </span>

                                    @else

                                        <span class="inline-flex items-center justify-center
                                                     min-w-10 h-10 px-2
                                                     rounded-xl
                                                     bg-slate-100
                                                     text-slate-600
                                                     text-sm font-bold">
                                            #{{ $index + 1 }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Produit --}}
                                <td class="px-6 py-4">

                                    <div class="font-bold text-slate-800">
                                        {{ $produit['nom_produit'] }}
                                    </div>

                                </td>


                                {{-- Quantité --}}
                                <td class="px-6 py-4">

                                    <span class="inline-flex items-center
                                                 px-3 py-1.5
                                                 rounded-lg
                                                 bg-blue-50
                                                 text-blue-700
                                                 text-sm font-bold">
                                        {{ $produit['total_quantite'] }}
                                    </span>

                                </td>


                                {{-- Nombre de ventes --}}
                                <td class="px-6 py-4">

                                    <span class="inline-flex items-center
                                                 px-3 py-1.5
                                                 rounded-lg
                                                 bg-slate-100
                                                 text-slate-700
                                                 text-sm font-semibold">
                                        {{ $produit['nombre_ventes'] }}
                                    </span>

                                </td>


                                {{-- CA --}}
                                <td class="px-6 py-4 text-right">

                                    <span class="text-sm font-bold text-green-600">
                                        {{ number_format($produit['chiffre_affaires'], 0, ',', ' ') }}
                                        GNF
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-12 text-center">

                                    <div class="text-4xl mb-3">
                                        📦
                                    </div>

                                    <p class="text-base font-semibold text-slate-700">
                                        Aucun produit vendu
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Aucun produit vendu sur cette période.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ================= MOBILE ================= --}}

            <div class="md:hidden divide-y divide-slate-100">

                @forelse($produits as $index => $produit)

                    <div class="p-4 sm:p-5">

                        <div class="flex items-start gap-3">

                            {{-- Rang --}}
                            <div class="flex-shrink-0">

                                @if($index + 1 === 1)

                                    <span class="inline-flex items-center justify-center
                                                 w-10 h-10 rounded-xl bg-yellow-50 text-lg">
                                        🥇
                                    </span>

                                @elseif($index + 1 === 2)

                                    <span class="inline-flex items-center justify-center
                                                 w-10 h-10 rounded-xl bg-slate-100 text-lg">
                                        🥈
                                    </span>

                                @elseif($index + 1 === 3)

                                    <span class="inline-flex items-center justify-center
                                                 w-10 h-10 rounded-xl bg-orange-50 text-lg">
                                        🥉
                                    </span>

                                @else

                                    <span class="inline-flex items-center justify-center
                                                 w-10 h-10 rounded-xl
                                                 bg-slate-100
                                                 text-slate-600
                                                 text-sm font-bold">
                                        #{{ $index + 1 }}
                                    </span>

                                @endif

                            </div>


                            {{-- Produit --}}
                            <div class="min-w-0 flex-1">

                                <h3 class="font-bold text-slate-800 break-words">
                                    {{ $produit['nom_produit'] }}
                                </h3>

                                <div class="grid grid-cols-2 gap-3 mt-4">

                                    <div class="rounded-xl bg-blue-50 p-3">

                                        <p class="text-xs text-blue-600 font-medium">
                                            Quantité vendue
                                        </p>

                                        <p class="mt-1 text-lg font-extrabold text-blue-700">
                                            {{ $produit['total_quantite'] }}
                                        </p>

                                    </div>


                                    <div class="rounded-xl bg-slate-50 p-3">

                                        <p class="text-xs text-slate-500 font-medium">
                                            Nombre de ventes
                                        </p>

                                        <p class="mt-1 text-lg font-extrabold text-slate-700">
                                            {{ $produit['nombre_ventes'] }}
                                        </p>

                                    </div>

                                </div>


                                <div class="mt-3 rounded-xl bg-green-50 p-3">

                                    <p class="text-xs text-green-600 font-medium">
                                        Chiffre d'affaires
                                    </p>

                                    <p class="mt-1 text-base font-extrabold text-green-700">
                                        {{ number_format($produit['chiffre_affaires'], 0, ',', ' ') }}
                                        GNF
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        <div class="text-4xl mb-3">
                            📦
                        </div>

                        <p class="font-semibold text-slate-700">
                            Aucun produit vendu
                        </p>

                        <p class="text-sm text-slate-500 mt-1">
                            Aucun produit vendu sur cette période.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- =====================================================
             GRAPHIQUE
        ====================================================== --}}

        @if(count($produits) > 0)

            <div class="bg-white border border-slate-200 rounded-2xl
                        shadow-sm p-5 sm:p-6 mt-6">

                <div class="mb-6">

                    <h2 class="text-lg sm:text-xl font-bold text-slate-800">
                        📊 Visualisation des quantités vendues
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Comparaison des quantités vendues par produit.
                    </p>

                </div>


                @php
                    $maxQty = collect($produits)->max('total_quantite');
                @endphp


                <div class="space-y-5">

                    @foreach($produits as $produit)

                        @php

                            $qty = (float) $produit['total_quantite'];

                            $max = max((float)$maxQty, 1);

                            $percent = ($qty / $max) * 100;

                            $widthStyle = 'width:' . $percent . '%;';

                            if ($percent >= 70) {

                                $color = 'from-green-500 to-green-600';

                            } elseif ($percent >= 40) {

                                $color = 'from-yellow-500 to-yellow-600';

                            } else {

                                $color = 'from-red-500 to-red-600';

                            }

                        @endphp


                        <div>

                            {{-- Label --}}
                            <div class="flex flex-col sm:flex-row
                                        sm:items-center sm:justify-between
                                        gap-1 mb-2">

                                <span class="text-sm font-semibold text-slate-700
                                             break-words">

                                    {{ substr($produit['nom_produit'], 0, 30) }}

                                </span>

                                <span class="text-sm font-bold text-slate-800
                                             whitespace-nowrap">

                                    {{ $produit['total_quantite'] }} unités

                                </span>

                            </div>


                            {{-- Barre --}}
                            <div class="w-full bg-slate-100 rounded-full h-7 overflow-hidden">

                                <div
                                    class="h-7 rounded-full
                                           flex items-center justify-center
                                           text-white text-xs font-bold
                                           bg-gradient-to-r {{ $color }}
                                           transition-all duration-700"
                                    @style(['width' => $percent . '%'])
                                >

                                    @if($percent > 30)

                                        {{ round($percent) }}%

                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

    </div>

</div>

@endsection
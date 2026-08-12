```blade
@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">

        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a
                        href="{{ route('inventaire.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-800"
                    >
                        ← Inventaires
                    </a>
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                    Inventaire #{{ $inventaire->id }}
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Détail et résultat de l'inventaire
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('inventaire.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg
                           bg-slate-200 text-slate-700 text-sm font-semibold
                           hover:bg-slate-300 transition"
                >
                    ← Retour
                </a>

                @if(($inventaire->statut ?? null) !== 'cloture')

                    <a
                        href="{{ route('inventaire.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg
                               bg-blue-600 text-white text-sm font-semibold
                               hover:bg-blue-700 transition"
                    >
                        + Nouvel inventaire
                    </a>

                @endif

            </div>
        </div>


        {{-- =========================================================
             MESSAGE SESSION
        ========================================================== --}}
        @if(session('success'))

            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                {{ session('error') }}
            </div>

        @endif


        {{-- =========================================================
             INFORMATIONS INVENTAIRE
        ========================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

            {{-- Numéro --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Inventaire
                </p>

                <p class="text-xl font-bold text-slate-800 mt-1">
                    #{{ $inventaire->id }}
                </p>
            </div>


            {{-- Date --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Date
                </p>

                <p class="text-lg font-bold text-slate-800 mt-1">
                    {{ $inventaire->date_inventaire
                        ? \Carbon\Carbon::parse($inventaire->date_inventaire)->format('d/m/Y')
                        : '—'
                    }}
                </p>
            </div>


            {{-- Statut --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Statut
                </p>

                @if(($inventaire->statut ?? null) === 'cloture')

                    <span class="inline-flex mt-2 px-3 py-1 rounded-full text-xs font-bold
                                 bg-green-100 text-green-700">
                        ✓ Clôturé
                    </span>

                @else

                    <span class="inline-flex mt-2 px-3 py-1 rounded-full text-xs font-bold
                                 bg-orange-100 text-orange-700">
                        ● En cours
                    </span>

                @endif

            </div>


            {{-- Créateur --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Créé par
                </p>

                <p class="text-lg font-bold text-slate-800 mt-1">
                    {{ $inventaire->user->name ?? auth()->user()->name }}
                </p>

            </div>

        </div>


        {{-- =========================================================
             RÉSULTAT GLOBAL
        ========================================================== --}}
        @php

            $totalTheorique = $inventaire->details->sum(function ($detail) {
                return (float) ($detail->quantite_theorique ?? 0);
            });

            $totalReel = $inventaire->details->sum(function ($detail) {
                return (float) ($detail->quantite_reelle ?? 0);
            });

            $totalEcart = $inventaire->details->sum(function ($detail) {
                return (float) ($detail->ecart ?? (
                    ($detail->quantite_reelle ?? 0) -
                    ($detail->quantite_theorique ?? 0)
                ));
            });

        @endphp


        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

            {{-- Théorique --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500">
                            Stock théorique
                        </p>

                        <p class="text-2xl font-bold text-slate-800 mt-1">
                            {{ number_format($totalTheorique, 0, ',', ' ') }}
                        </p>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-xl">
                        📦
                    </div>

                </div>

            </div>


            {{-- Réel --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500">
                            Stock réel
                        </p>

                        <p class="text-2xl font-bold text-slate-800 mt-1">
                            {{ number_format($totalReel, 0, ',', ' ') }}
                        </p>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center text-xl">
                        🔎
                    </div>

                </div>

            </div>


            {{-- Écart --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Écart total
                        </p>

                        <p class="text-2xl font-bold mt-1
                            {{ $totalEcart > 0
                                ? 'text-green-600'
                                : ($totalEcart < 0 ? 'text-red-600' : 'text-slate-800')
                            }}"
                        >
                            {{ $totalEcart > 0 ? '+' : '' }}
                            {{ number_format($totalEcart, 0, ',', ' ') }}
                        </p>

                    </div>

                    <div class="w-11 h-11 rounded-xl
                        {{ $totalEcart > 0
                            ? 'bg-green-100'
                            : ($totalEcart < 0 ? 'bg-red-100' : 'bg-slate-100')
                        }}
                        flex items-center justify-center text-xl"
                    >
                        {{ $totalEcart > 0 ? '📈' : ($totalEcart < 0 ? '📉' : '✓') }}
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             EXPLICATION DU RÉSULTAT
        ========================================================== --}}
        @if(($inventaire->statut ?? null) === 'cloture')

            @if($totalEcart > 0)

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4">

                    <div class="flex gap-3">

                        <span class="text-xl">📈</span>

                        <div>
                            <h3 class="font-bold text-green-800">
                                Excédent de stock
                            </h3>

                            <p class="text-sm text-green-700 mt-1">
                                Le stock réel est supérieur au stock théorique de
                                <strong>{{ number_format($totalEcart, 0, ',', ' ') }}</strong>
                                unité(s).
                            </p>
                        </div>

                    </div>

                </div>

            @elseif($totalEcart < 0)

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                    <div class="flex gap-3">

                        <span class="text-xl">📉</span>

                        <div>
                            <h3 class="font-bold text-red-800">
                                Manque constaté
                            </h3>

                            <p class="text-sm text-red-700 mt-1">
                                Le stock réel est inférieur au stock théorique de
                                <strong>{{ number_format(abs($totalEcart), 0, ',', ' ') }}</strong>
                                unité(s).
                            </p>
                        </div>

                    </div>

                </div>

            @else

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4">

                    <div class="flex gap-3">

                        <span class="text-xl">✓</span>

                        <div>
                            <h3 class="font-bold text-green-800">
                                Inventaire équilibré
                            </h3>

                            <p class="text-sm text-green-700 mt-1">
                                Le stock réel correspond exactement au stock théorique.
                            </p>
                        </div>

                    </div>

                </div>

            @endif

        @else

            <div class="mb-6 rounded-xl border border-orange-200 bg-orange-50 p-4">

                <div class="flex gap-3">

                    <span class="text-xl">⚠️</span>

                    <div>
                        <h3 class="font-bold text-orange-800">
                            Inventaire non clôturé
                        </h3>

                        <p class="text-sm text-orange-700 mt-1">
                            Le résultat définitif de l'inventaire ne doit être considéré
                            comme final qu'après sa clôture.
                        </p>
                    </div>

                </div>

            </div>

        @endif


        {{-- =========================================================
             DÉTAIL DES PRODUITS
        ========================================================== --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-slate-200">

                <h2 class="text-lg font-bold text-slate-800">
                    Détail de l'inventaire
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Comparaison entre les quantités théoriques et les quantités réellement comptées.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th class="px-4 py-3 text-left font-semibold text-slate-600">
                                Produit
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-slate-600">
                                Catégorie
                            </th>

                            <th class="px-4 py-3 text-right font-semibold text-slate-600">
                                Théorique
                            </th>

                            <th class="px-4 py-3 text-right font-semibold text-slate-600">
                                Réel
                            </th>

                            <th class="px-4 py-3 text-right font-semibold text-slate-600">
                                Écart
                            </th>

                            <th class="px-4 py-3 text-center font-semibold text-slate-600">
                                État
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($inventaire->details as $detail)

                            @php

                                $theorique = (float) ($detail->quantite_theorique ?? 0);

                                $reel = (float) ($detail->quantite_reelle ?? 0);

                                $ecart = (float) ($detail->ecart ?? ($reel - $theorique));

                            @endphp

                            <tr class="hover:bg-slate-50 transition">

                                {{-- Produit --}}
                                <td class="px-4 py-3">

                                    <div class="font-semibold text-slate-800">
                                        {{ $detail->produit->nom_produit ?? 'Produit supprimé' }}
                                    </div>

                                    @if(isset($detail->produit->reference))
                                        <div class="text-xs text-slate-400">
                                            Réf. {{ $detail->produit->reference }}
                                        </div>
                                    @endif

                                </td>


                                {{-- Catégorie --}}
                                <td class="px-4 py-3 text-slate-600">

                                    {{ $detail->produit->categorie->nom ?? '—' }}

                                </td>


                                {{-- Théorique --}}
                                <td class="px-4 py-3 text-right font-medium text-slate-700">

                                    {{ number_format($theorique, 0, ',', ' ') }}

                                </td>


                                {{-- Réel --}}
                                <td class="px-4 py-3 text-right font-semibold text-slate-800">

                                    {{ number_format($reel, 0, ',', ' ') }}

                                </td>


                                {{-- Écart --}}
                                <td class="px-4 py-3 text-right font-bold
                                    {{ $ecart > 0
                                        ? 'text-green-600'
                                        : ($ecart < 0 ? 'text-red-600' : 'text-slate-500')
                                    }}"
                                >

                                    {{ $ecart > 0 ? '+' : '' }}
                                    {{ number_format($ecart, 0, ',', ' ') }}

                                </td>


                                {{-- État --}}
                                <td class="px-4 py-3 text-center">

                                    @if($ecart > 0)

                                        <span class="inline-flex px-2.5 py-1 rounded-full
                                                     bg-green-100 text-green-700
                                                     text-xs font-bold">
                                            Excédent
                                        </span>

                                    @elseif($ecart < 0)

                                        <span class="inline-flex px-2.5 py-1 rounded-full
                                                     bg-red-100 text-red-700
                                                     text-xs font-bold">
                                            Manquant
                                        </span>

                                    @else

                                        <span class="inline-flex px-2.5 py-1 rounded-full
                                                     bg-slate-100 text-slate-600
                                                     text-xs font-bold">
                                            Conforme
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-12 text-center text-slate-500"
                                >
                                    Aucun produit enregistré dans cet inventaire.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>


                    @if($inventaire->details->count())

                        <tfoot class="bg-slate-50 border-t-2 border-slate-200">

                            <tr>

                                <td
                                    colspan="2"
                                    class="px-4 py-4 text-right font-bold text-slate-700"
                                >
                                    TOTAL
                                </td>

                                <td class="px-4 py-4 text-right font-bold text-slate-800">
                                    {{ number_format($totalTheorique, 0, ',', ' ') }}
                                </td>

                                <td class="px-4 py-4 text-right font-bold text-slate-800">
                                    {{ number_format($totalReel, 0, ',', ' ') }}
                                </td>

                                <td class="px-4 py-4 text-right font-bold
                                    {{ $totalEcart > 0
                                        ? 'text-green-600'
                                        : ($totalEcart < 0 ? 'text-red-600' : 'text-slate-700')
                                    }}"
                                >
                                    {{ $totalEcart > 0 ? '+' : '' }}
                                    {{ number_format($totalEcart, 0, ',', ' ') }}
                                </td>

                                <td></td>

                            </tr>

                        </tfoot>

                    @endif

                </table>

            </div>

        </div>


        {{-- =========================================================
             NOTES
        ========================================================== --}}
        @if(!empty($inventaire->note))

            <div class="mt-6 bg-white rounded-xl border border-slate-200 shadow-sm p-5">

                <h2 class="font-bold text-slate-800 mb-2">
                    📝 Note
                </h2>

                <p class="text-sm text-slate-600 whitespace-pre-line">
                    {{ $inventaire->note }}
                </p>

            </div>

        @endif


        {{-- =========================================================
             CLÔTURE
        ========================================================== --}}
        @if(($inventaire->statut ?? null) !== 'cloture')

            <div class="mt-6 bg-white rounded-xl border border-orange-200 shadow-sm p-5">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>

                        <h2 class="font-bold text-slate-800">
                            Clôturer l'inventaire
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            La clôture permet de valider définitivement les écarts
                            constatés lors du comptage.
                        </p>

                    </div>


                    @if(Route::has('inventaire.cloturer'))

                        <form
                            method="POST"
                            action="{{ route('inventaire.cloturer', $inventaire) }}"
                            onsubmit="return confirm('Voulez-vous vraiment clôturer cet inventaire ? Cette opération doit être effectuée après vérification des quantités.');"
                        >

                            @csrf

                            @method('PATCH')

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center px-5 py-2.5
                                       rounded-lg bg-orange-600 text-white
                                       text-sm font-semibold
                                       hover:bg-orange-700
                                       focus:outline-none focus:ring-2
                                       focus:ring-orange-400
                                       transition"
                            >
                                🔒 Clôturer l'inventaire
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        @else

            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-5">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        ✓
                    </div>

                    <div>

                        <h2 class="font-bold text-green-800">
                            Inventaire clôturé
                        </h2>

                        <p class="text-sm text-green-700 mt-1">
                            Cet inventaire a été définitivement validé.
                        </p>

                    </div>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection

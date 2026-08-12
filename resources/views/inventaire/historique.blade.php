@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 px-4 sm:px-6 lg:px-8">

<div class="max-w-7xl mx-auto">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                Historique des inventaires
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Consultez les inventaires clôturés et les écarts constatés.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <a href="{{ route('inventaire.index') }}"
               class="inline-flex items-center justify-center gap-2
                      px-4 py-2.5 rounded-lg
                      bg-slate-700 text-white
                      text-sm font-semibold
                      hover:bg-slate-800
                      transition">

                📦 Inventaire

            </a>

            <a href="{{ route('inventaire.create') }}"
               class="inline-flex items-center justify-center gap-2
                      px-4 py-2.5 rounded-lg
                      bg-blue-600 text-white
                      text-sm font-semibold
                      hover:bg-blue-700
                      transition">

                ➕ Nouvel inventaire

            </a>

        </div>

    </div>


    {{-- =========================================================
         MESSAGES
    ========================================================== --}}

    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200
                    bg-green-50 px-4 py-3 text-sm text-green-700">

            ✅ {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="mb-6 rounded-lg border border-red-200
                    bg-red-50 px-4 py-3 text-sm text-red-700">

            ⚠️ {{ session('error') }}

        </div>

    @endif


    {{-- =========================================================
         STATISTIQUES
    ========================================================== --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">

            <p class="text-sm text-slate-500">
                Inventaires clôturés
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-800">
                {{ $inventaires->total() }}
            </p>

        </div>


        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">

            <p class="text-sm text-slate-500">
                Total des gains
            </p>

            <p class="mt-2 text-2xl font-bold text-green-600">
                {{ number_format($totalGains ?? 0, 0, ',', ' ') }}
                GNF
            </p>

        </div>


        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">

            <p class="text-sm text-slate-500">
                Total des pertes
            </p>

            <p class="mt-2 text-2xl font-bold text-red-600">
                {{ number_format($totalPertes ?? 0, 0, ',', ' ') }}
                GNF
            </p>

        </div>


        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">

            <p class="text-sm text-slate-500">
                Solde global
            </p>

            @php
                $soldeGlobal = ($totalGains ?? 0) - ($totalPertes ?? 0);
            @endphp

            <p class="mt-2 text-2xl font-bold
                {{ $soldeGlobal >= 0 ? 'text-green-600' : 'text-red-600' }}">

                {{ number_format(abs($soldeGlobal), 0, ',', ' ') }}
                GNF

            </p>

        </div>

    </div>


    {{-- =========================================================
         TABLEAU
    ========================================================== --}}

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-200">

            <h2 class="text-lg font-bold text-slate-800">
                Inventaires clôturés
            </h2>

        </div>


        {{-- VERSION DESKTOP --}}
        <div class="hidden md:block overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-5 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Date
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Référence
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Produits
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Valeur théorique
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Valeur réelle
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Écart
                        </th>

                        <th class="px-5 py-3 text-center text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Statut
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse($inventaires as $inventaire)

                        @php
                            $ecart = $inventaire->ecart ?? 0;
                        @endphp

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-700">

                                {{ optional($inventaire->date_inventaire)->format('d/m/Y') 
                                    ?? ($inventaire->date_inventaire ?? '-') }}

                            </td>


                            <td class="px-5 py-4 whitespace-nowrap">

                                <span class="font-semibold text-slate-800">
                                    {{ $inventaire->reference 
                                        ?? ('INV-' . str_pad($inventaire->id, 5, '0', STR_PAD_LEFT)) }}
                                </span>

                            </td>


                            <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600">

                                {{ $inventaire->details_count 
                                    ?? ($inventaire->details->count() ?? 0) }}

                            </td>


                            <td class="px-5 py-4 whitespace-nowrap text-right text-sm font-medium text-slate-700">

                                {{ number_format($inventaire->valeur_theorique ?? 0, 0, ',', ' ') }}
                                GNF

                            </td>


                            <td class="px-5 py-4 whitespace-nowrap text-right text-sm font-medium text-slate-700">

                                {{ number_format($inventaire->valeur_reelle ?? 0, 0, ',', ' ') }}
                                GNF

                            </td>


                            <td class="px-5 py-4 whitespace-nowrap text-right">

                                @if($ecart > 0)

                                    <span class="font-bold text-green-600">
                                        +{{ number_format($ecart, 0, ',', ' ') }} GNF
                                    </span>

                                @elseif($ecart < 0)

                                    <span class="font-bold text-red-600">
                                        {{ number_format($ecart, 0, ',', ' ') }} GNF
                                    </span>

                                @else

                                    <span class="font-bold text-slate-500">
                                        0 GNF
                                    </span>

                                @endif

                            </td>


                            <td class="px-5 py-4 text-center">

                                <span class="inline-flex items-center px-2.5 py-1
                                             rounded-full text-xs font-semibold
                                             bg-green-100 text-green-700">

                                    ✓ Clôturé

                                </span>

                            </td>


                            <td class="px-5 py-4 text-right whitespace-nowrap">

                                <a href="{{ route('inventaire.show', $inventaire->id) }}"
                                   class="inline-flex items-center gap-1
                                          px-3 py-2 rounded-lg
                                          bg-blue-50 text-blue-700
                                          text-sm font-semibold
                                          hover:bg-blue-100 transition">

                                    👁️ Voir

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="px-6 py-12 text-center">

                                <div class="text-4xl mb-3">
                                    📦
                                </div>

                                <h3 class="text-lg font-semibold text-slate-700">
                                    Aucun inventaire clôturé
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Les inventaires clôturés apparaîtront ici.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- VERSION MOBILE --}}
        <div class="md:hidden divide-y divide-slate-100">

            @forelse($inventaires as $inventaire)

                @php
                    $ecart = $inventaire->ecart ?? 0;
                @endphp

                <div class="p-4">

                    <div class="flex items-start justify-between gap-3">

                        <div>

                            <p class="font-bold text-slate-800">

                                {{ $inventaire->reference 
                                    ?? ('INV-' . str_pad($inventaire->id, 5, '0', STR_PAD_LEFT)) }}

                            </p>

                            <p class="text-xs text-slate-500 mt-1">

                                {{ optional($inventaire->date_inventaire)->format('d/m/Y') 
                                    ?? ($inventaire->date_inventaire ?? '-') }}

                            </p>

                        </div>


                        <span class="inline-flex items-center px-2 py-1
                                     rounded-full text-xs font-semibold
                                     bg-green-100 text-green-700">

                            ✓ Clôturé

                        </span>

                    </div>


                    <div class="grid grid-cols-2 gap-3 mt-4">

                        <div class="rounded-lg bg-slate-50 p-3">

                            <p class="text-xs text-slate-500">
                                Valeur théorique
                            </p>

                            <p class="mt-1 text-sm font-bold text-slate-800">

                                {{ number_format($inventaire->valeur_theorique ?? 0, 0, ',', ' ') }}
                                GNF

                            </p>

                        </div>


                        <div class="rounded-lg bg-slate-50 p-3">

                            <p class="text-xs text-slate-500">
                                Valeur réelle
                            </p>

                            <p class="mt-1 text-sm font-bold text-slate-800">

                                {{ number_format($inventaire->valeur_reelle ?? 0, 0, ',', ' ') }}
                                GNF

                            </p>

                        </div>

                    </div>


                    <div class="flex items-center justify-between mt-4">

                        <div>

                            <p class="text-xs text-slate-500">
                                Écart
                            </p>

                            @if($ecart > 0)

                                <p class="font-bold text-green-600">
                                    +{{ number_format($ecart, 0, ',', ' ') }} GNF
                                </p>

                            @elseif($ecart < 0)

                                <p class="font-bold text-red-600">
                                    {{ number_format($ecart, 0, ',', ' ') }} GNF
                                </p>

                            @else

                                <p class="font-bold text-slate-500">
                                    0 GNF
                                </p>

                            @endif

                        </div>


                        <a href="{{ route('inventaire.show', $inventaire->id) }}"
                           class="inline-flex items-center gap-1
                                  px-3 py-2 rounded-lg
                                  bg-blue-600 text-white
                                  text-sm font-semibold
                                  hover:bg-blue-700 transition">

                            👁️ Voir le détail

                        </a>

                    </div>

                </div>

            @empty

                <div class="p-10 text-center">

                    <div class="text-4xl mb-3">
                        📦
                    </div>

                    <p class="font-semibold text-slate-700">
                        Aucun inventaire clôturé
                    </p>

                    <p class="text-sm text-slate-500 mt-1">
                        Les inventaires terminés apparaîtront ici.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if($inventaires->hasPages())

            <div class="px-5 py-4 border-t border-slate-200">

                {{ $inventaires->links() }}

            </div>

        @endif

    </div>

</div>


</div>

@endsection

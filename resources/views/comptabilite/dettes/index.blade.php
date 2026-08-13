@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50">

    <div class="container mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-8">

        <!-- =========================================================
             EN-TÊTE
        ========================================================== -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                    Gestion des Dettes
                </h1>

                <p class="text-sm sm:text-base text-slate-500 mt-1">
                    Suivi des créances clients et des dettes fournisseurs
                </p>
            </div>

        </div>


        <!-- =========================================================
             CARTES RÉSUMÉ
        ========================================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-7">

            <!-- Créances clients -->
            <div class="bg-white rounded-2xl border-2 border-blue-200 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden">

                <div class="p-5 sm:p-6">

                    <div class="flex items-start justify-between gap-4">

                        <div class="min-w-0">

                            <p class="text-xs sm:text-sm font-bold uppercase tracking-wide text-slate-500">
                                Créances Clients
                            </p>

                            <p class="mt-2 text-xl sm:text-2xl lg:text-3xl font-extrabold text-green-600 break-words">
                                {{ number_format($totalDettesClients, 0, ',', ' ') }} GNF
                            </p>

                            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                                {{ $dettesClients->count() }} vente(s) en attente
                            </p>

                        </div>

                        <div class="flex-shrink-0 bg-green-50 border border-green-200 p-3 rounded-xl">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-7 w-7 sm:h-8 sm:w-8 text-green-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />

                            </svg>

                        </div>

                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100">

                        <p class="text-xs sm:text-sm text-slate-400">
                            Argent que les clients vous doivent
                        </p>

                    </div>

                </div>

            </div>


            <!-- Dettes fournisseurs -->
            <div class="bg-white rounded-2xl border-2 border-blue-200 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden">

                <div class="p-5 sm:p-6">

                    <div class="flex items-start justify-between gap-4">

                        <div class="min-w-0">

                            <p class="text-xs sm:text-sm font-bold uppercase tracking-wide text-slate-500">
                                Dettes Fournisseurs
                            </p>

                            <p class="mt-2 text-xl sm:text-2xl lg:text-3xl font-extrabold text-red-600 break-words">
                                {{ number_format($totalDettesFournisseurs, 0, ',', ' ') }} GNF
                            </p>

                            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                                {{ $dettesFournisseurs->count() }} achat(s) en attente
                            </p>

                        </div>

                        <div class="flex-shrink-0 bg-red-50 border border-red-200 p-3 rounded-xl">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-7 w-7 sm:h-8 sm:w-8 text-red-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />

                            </svg>

                        </div>

                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100">

                        <p class="text-xs sm:text-sm text-slate-400">
                            Argent que vous devez aux fournisseurs
                        </p>

                    </div>

                </div>

            </div>

        </div>



        <!-- =========================================================
             CRÉANCES CLIENTS / DETTES FOURNISSEURS
        ========================================================== -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 lg:gap-6">


            <!-- =====================================================
                 CRÉANCES CLIENTS
            ====================================================== -->
            <div class="bg-white rounded-2xl border-2 border-blue-200 shadow-sm overflow-hidden">

                <div class="px-4 sm:px-5 py-4 bg-green-600">

                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <h2 class="text-base sm:text-lg font-extrabold text-white">
                                Créances Clients
                            </h2>

                            <p class="text-xs text-green-100 mt-0.5">
                                Montants à recevoir
                            </p>
                        </div>

                        <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold">
                            {{ $dettesClients->count() }}
                        </span>

                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-[760px] w-full">

                        <thead class="bg-slate-50 border-b border-blue-100">

                            <tr>

                                <th class="px-3 sm:px-4 py-3 text-left text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Client
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-left text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Date
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-right text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Total
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-right text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Payé
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-right text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Reste
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-center text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse($dettesClients as $vente)

                            <tr class="hover:bg-blue-50/40 transition-colors">

                                <td class="px-3 sm:px-4 py-3 text-sm font-semibold text-slate-800">
                                    {{ $vente->client->nom_client ?? 'Client inconnu' }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-sm text-slate-500 whitespace-nowrap">
                                    {{ $vente->date_vente->format('d/m/Y') }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-sm text-right font-medium text-slate-700 whitespace-nowrap">
                                    {{ number_format($vente->montant_total, 0, ',', ' ') }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-sm text-right font-semibold text-green-600 whitespace-nowrap">
                                    {{ number_format($vente->total_paye, 0, ',', ' ') }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-sm text-right font-extrabold text-red-600 whitespace-nowrap">
                                    {{ number_format($vente->reste_a_payer, 0, ',', ' ') }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-center">

                                    <a href="{{ route('recettes.create', ['vente_id' => $vente->id]) }}"
                                       class="inline-flex items-center justify-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transition">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-3.5 h-3.5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />

                                        </svg>

                                        Encaisser

                                    </a>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="6" class="px-4 py-10 text-center">

                                    <div class="flex flex-col items-center">

                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="w-6 h-6 text-slate-400"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                                            </svg>

                                        </div>

                                        <p class="text-sm font-semibold text-slate-500">
                                            Aucune créance client en attente
                                        </p>

                                    </div>

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                @if($dettesClients->count() > 0)

                <div class="bg-slate-50 px-4 sm:px-5 py-4 border-t border-blue-100">

                    <div class="flex items-center justify-between gap-3">

                        <span class="text-sm font-semibold text-slate-600">
                            Total créances
                        </span>

                        <span class="text-base sm:text-lg font-extrabold text-green-600">
                            {{ number_format($totalDettesClients, 0, ',', ' ') }} GNF
                        </span>

                    </div>

                </div>

                @endif

            </div>



            <!-- =====================================================
                 DETTES FOURNISSEURS
            ====================================================== -->
            <div class="bg-white rounded-2xl border-2 border-blue-200 shadow-sm overflow-hidden">

                <div class="px-4 sm:px-5 py-4 bg-red-600">

                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <h2 class="text-base sm:text-lg font-extrabold text-white">
                                Dettes Fournisseurs
                            </h2>

                            <p class="text-xs text-red-100 mt-0.5">
                                Montants à payer
                            </p>
                        </div>

                        <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold">
                            {{ $dettesFournisseurs->count() }}
                        </span>

                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-[760px] w-full">

                        <thead class="bg-slate-50 border-b border-blue-100">

                            <tr>

                                <th class="px-3 sm:px-4 py-3 text-left text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Fournisseur
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-left text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Date
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-right text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Total
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-right text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Payé
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-right text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Reste
                                </th>

                                <th class="px-3 sm:px-4 py-3 text-center text-[11px] sm:text-xs font-extrabold text-slate-600 uppercase tracking-wide">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse($dettesFournisseurs as $achat)

                            <tr class="hover:bg-blue-50/40 transition-colors">

                                <td class="px-3 sm:px-4 py-3 text-sm font-semibold text-slate-800">
                                    {{ $achat->fournisseur->nom_fournisseur ?? 'Fournisseur inconnu' }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-sm text-slate-500 whitespace-nowrap">
                                    {{ $achat->date_achat->format('d/m/Y') }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-sm text-right font-medium text-slate-700 whitespace-nowrap">
                                    {{ number_format($achat->total, 0, ',', ' ') }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-sm text-right font-semibold text-green-600 whitespace-nowrap">
                                    {{ number_format($achat->montant_paye, 0, ',', ' ') }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-sm text-right font-extrabold text-red-600 whitespace-nowrap">
                                    {{ number_format($achat->reste_a_payer, 0, ',', ' ') }}
                                </td>

                                <td class="px-3 sm:px-4 py-3 text-center">

                                    <a href="{{ route('depenses.create', ['achat_id' => $achat->id]) }}"
                                       class="inline-flex items-center justify-center gap-1.5 bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transition">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-3.5 h-3.5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />

                                        </svg>

                                        Payer

                                    </a>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="6" class="px-4 py-10 text-center">

                                    <div class="flex flex-col items-center">

                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="w-6 h-6 text-slate-400"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                                            </svg>

                                        </div>

                                        <p class="text-sm font-semibold text-slate-500">
                                            Aucune dette fournisseur en attente
                                        </p>

                                    </div>

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                @if($dettesFournisseurs->count() > 0)

                <div class="bg-slate-50 px-4 sm:px-5 py-4 border-t border-blue-100">

                    <div class="flex items-center justify-between gap-3">

                        <span class="text-sm font-semibold text-slate-600">
                            Total dettes
                        </span>

                        <span class="text-base sm:text-lg font-extrabold text-red-600">
                            {{ number_format($totalDettesFournisseurs, 0, ',', ' ') }} GNF
                        </span>

                    </div>

                </div>

                @endif

            </div>

        </div>



        <!-- =========================================================
             RÉSUMÉ PAR CLIENT / FOURNISSEUR
        ========================================================== -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 lg:gap-6 mt-6">


            <!-- Résumé clients -->
            <div class="bg-white rounded-2xl border-2 border-blue-200 shadow-sm overflow-hidden">

                <div class="bg-green-600 px-4 sm:px-5 py-4">

                    <h2 class="text-base sm:text-lg font-extrabold text-white">
                        Résumé par Client
                    </h2>

                    <p class="text-xs text-green-100 mt-0.5">
                        Vue globale des créances
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-[500px] w-full">

                        <thead class="bg-slate-50 border-b border-blue-100">

                            <tr>

                                <th class="px-4 py-3 text-left text-xs font-extrabold text-slate-600 uppercase">
                                    Client
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-extrabold text-slate-600 uppercase">
                                    Nb Ventes
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-extrabold text-slate-600 uppercase">
                                    Total Dû
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @php
                                $clientsGrouped = $dettesClients->groupBy('client_id');
                            @endphp

                            @forelse($clientsGrouped as $clientId => $ventes)

                            @php
                                $client = $ventes->first()->client;
                                $totalDu = $ventes->sum('reste_a_payer');
                            @endphp

                            <tr class="hover:bg-blue-50/40">

                                <td class="px-4 py-3 text-sm font-semibold text-slate-800">
                                    {{ $client->nom_client ?? 'Client inconnu' }}
                                </td>

                                <td class="px-4 py-3 text-sm text-center">

                                    <span class="inline-flex items-center justify-center min-w-8 px-2 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">
                                        {{ $ventes->count() }}
                                    </span>

                                </td>

                                <td class="px-4 py-3 text-sm text-right font-extrabold text-green-600 whitespace-nowrap">
                                    {{ number_format($totalDu, 0, ',', ' ') }} GNF
                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="px-4 py-8 text-center text-sm text-slate-500">
                                    Aucun client endetté
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>



            <!-- Résumé fournisseurs -->
            <div class="bg-white rounded-2xl border-2 border-blue-200 shadow-sm overflow-hidden">

                <div class="bg-red-600 px-4 sm:px-5 py-4">

                    <h2 class="text-base sm:text-lg font-extrabold text-white">
                        Résumé par Fournisseur
                    </h2>

                    <p class="text-xs text-red-100 mt-0.5">
                        Vue globale des dettes
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-[500px] w-full">

                        <thead class="bg-slate-50 border-b border-blue-100">

                            <tr>

                                <th class="px-4 py-3 text-left text-xs font-extrabold text-slate-600 uppercase">
                                    Fournisseur
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-extrabold text-slate-600 uppercase">
                                    Nb Achats
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-extrabold text-slate-600 uppercase">
                                    Total Dû
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @php
                                $fournisseursGrouped = $dettesFournisseurs->groupBy('fournisseur_id');
                            @endphp

                            @forelse($fournisseursGrouped as $fournisseurId => $achats)

                            @php
                                $fournisseur = $achats->first()->fournisseur;
                                $totalDu = $achats->sum('reste_a_payer');
                            @endphp

                            <tr class="hover:bg-blue-50/40">

                                <td class="px-4 py-3 text-sm font-semibold text-slate-800">
                                    {{ $fournisseur->nom_fournisseur ?? 'Fournisseur inconnu' }}
                                </td>

                                <td class="px-4 py-3 text-sm text-center">

                                    <span class="inline-flex items-center justify-center min-w-8 px-2 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">
                                        {{ $achats->count() }}
                                    </span>

                                </td>

                                <td class="px-4 py-3 text-sm text-right font-extrabold text-red-600 whitespace-nowrap">
                                    {{ number_format($totalDu, 0, ',', ' ') }} GNF
                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="px-4 py-8 text-center text-sm text-slate-500">
                                    Aucune dette fournisseur
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        <!-- =========================================================
             SOLDE NET
        ========================================================== -->

        @php
            $soldeNet = $totalDettesClients - $totalDettesFournisseurs;
        @endphp

        <div class="mt-6 bg-white rounded-2xl border-2 border-blue-200 shadow-sm overflow-hidden">

            <div class="p-5 sm:p-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">

                    <div>

                        <p class="text-xs sm:text-sm font-bold uppercase tracking-wide text-slate-500">
                            Solde Net
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            Créances - Dettes
                        </p>

                        <p class="mt-2 text-2xl sm:text-3xl lg:text-4xl font-extrabold {{ $soldeNet >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $soldeNet >= 0 ? '+' : '' }}{{ number_format($soldeNet, 0, ',', ' ') }} GNF
                        </p>

                    </div>


                    <div class="{{ $soldeNet >= 0 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }} border-2 p-4 rounded-2xl self-start sm:self-center">

                        @if($soldeNet >= 0)

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-9 w-9 sm:h-10 sm:w-10 text-green-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />

                            </svg>

                        @else

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-9 w-9 sm:h-10 sm:w-10 text-red-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />

                            </svg>

                        @endif

                    </div>

                </div>


                <div class="mt-5 pt-4 border-t border-slate-100">

                    <p class="text-xs sm:text-sm text-slate-500">

                        @if($soldeNet >= 0)

                            <span class="font-semibold text-green-600">
                                Situation favorable :
                            </span>

                            Vous avez plus de créances que de dettes.

                        @else

                            <span class="font-semibold text-red-600">
                                Attention :
                            </span>

                            Vous devez plus que ce qu'on vous doit.

                        @endif

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
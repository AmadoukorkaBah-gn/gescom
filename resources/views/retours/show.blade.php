@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 sm:py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-3xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <p class="text-sm font-semibold text-indigo-600 mb-1">
                    Gestion des retours
                </p>

                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight">
                    Détail du retour
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Informations concernant le retour #{{ $retour->id }}
                </p>
            </div>

            <a
                href="{{ route('retours.index') }}"
                class="inline-flex items-center justify-center gap-2
                       px-4 py-2.5
                       rounded-lg
                       bg-slate-700
                       text-white
                       text-sm font-semibold
                       shadow-sm
                       hover:bg-slate-800
                       transition"
            >
                ← Retour à la liste
            </a>

        </div>


        {{-- =====================================================
             CARTE PRINCIPALE
        ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- Bandeau --}}
            <div class="px-5 sm:px-7 py-5 bg-gradient-to-r from-indigo-600 to-indigo-700">

                <div class="flex items-center gap-4">

                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-white/15
                                flex items-center justify-center text-2xl">
                        ↩️
                    </div>

                    <div class="min-w-0">
                        <h2 class="text-lg sm:text-xl font-bold text-white">
                            Retour #{{ $retour->id }}
                        </h2>

                        <p class="text-sm text-indigo-100 mt-1">
                            Informations détaillées du retour
                        </p>
                    </div>

                </div>

            </div>


            {{-- Informations --}}
            <div class="p-5 sm:p-7">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">


                    {{-- Produit --}}
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">
                            Produit
                        </p>

                        <p class="text-base sm:text-lg font-bold text-slate-800 break-words">
                            {{ $retour->produit->nom_produit }}
                        </p>

                    </div>


                    {{-- Vente --}}
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">
                            Vente concernée
                        </p>

                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg
                                     bg-blue-100 text-blue-700
                                     text-sm font-bold">
                            #{{ $retour->vente->id }}
                        </span>

                    </div>


                    {{-- Quantité --}}
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">
                            Quantité retournée
                        </p>

                        <div class="flex items-center gap-2">

                            <span class="text-2xl font-bold text-slate-800">
                                {{ $retour->quantite }}
                            </span>

                            <span class="text-sm text-slate-500">
                                unité(s)
                            </span>

                        </div>

                    </div>


                    {{-- Date --}}
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">
                            Date du retour
                        </p>

                        <p class="text-base font-semibold text-slate-800">
                            {{ $retour->date_retour }}
                        </p>

                    </div>


                    {{-- Raison --}}
                    <div class="sm:col-span-2 rounded-xl border border-amber-200 bg-amber-50 p-4">

                        <p class="text-xs font-semibold uppercase tracking-wide text-amber-700 mb-2">
                            Raison du retour
                        </p>

                        <p class="text-sm sm:text-base font-semibold text-amber-900 break-words">
                            {{ $retour->raison }}
                        </p>

                    </div>

                </div>


                {{-- =================================================
                     ACTION
                ================================================== --}}
                <div class="mt-7 pt-6 border-t border-slate-200">

                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                        <a
                            href="{{ route('retours.index') }}"
                            class="inline-flex items-center justify-center
                                   px-5 py-2.5
                                   rounded-lg
                                   border border-slate-300
                                   bg-white
                                   text-slate-700
                                   text-sm font-semibold
                                   hover:bg-slate-50
                                   transition"
                        >
                            Retour à la liste
                        </a>

                        <a
                            href="{{ route('retours.edit', $retour->id) }}"
                            class="inline-flex items-center justify-center gap-2
                                   px-5 py-2.5
                                   rounded-lg
                                   bg-indigo-600
                                   text-white
                                   text-sm font-semibold
                                   shadow-sm
                                   hover:bg-indigo-700
                                   transition"
                        >
                            ✏️ Modifier le retour
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
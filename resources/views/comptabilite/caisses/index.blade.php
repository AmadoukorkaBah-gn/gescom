@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    #caissesPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    #caissesPage .caisse-card {
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    #caissesPage .caisse-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 35px rgba(15, 23, 42, .10);
    }

    #caissesPage .action-btn {
        transition: all .18s ease;
    }

    #caissesPage .action-btn:hover {
        transform: translateY(-1px);
    }

    #caissesPage .balance-positive {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    #caissesPage .balance-negative {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
</style>

<div id="caissesPage" class="min-h-screen bg-slate-50">

    <div class="w-full max-w-7xl mx-auto px-3 sm:px-5 lg:px-8 py-5 sm:py-7 lg:py-10">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between mb-7 sm:mb-9">

            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="flex items-center justify-center w-11 h-11 sm:w-12 sm:h-12
                                rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">

                        <svg class="w-6 h-6 sm:w-7 sm:h-7"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3 10h18M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold
                                   tracking-tight text-slate-900">
                            Gestion des Caisses
                        </h1>

                        <p class="text-sm sm:text-base text-slate-500 mt-0.5">
                            Gérez vos caisses et consultez leurs soldes
                        </p>
                    </div>
                </div>
            </div>

            {{-- Bouton nouvelle caisse --}}
            <a href="{{ route('caisses.create') }}"
               class="action-btn inline-flex items-center justify-center gap-2
                      w-full sm:w-auto
                      px-5 py-3
                      rounded-xl
                      bg-blue-600 hover:bg-blue-700
                      text-white text-sm sm:text-base font-semibold
                      shadow-lg shadow-blue-600/20
                      focus:outline-none focus:ring-4 focus:ring-blue-500/20">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>

                <span>Nouvelle Caisse</span>
            </a>

        </div>


        {{-- =====================================================
             MESSAGES DE SUCCÈS / ERREUR
        ====================================================== --}}

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50
                        px-4 py-4 sm:px-5
                        text-emerald-800 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                    <div class="text-sm sm:text-base font-medium">
                        {{ session('success') }}
                    </div>

                </div>
            </div>
        @endif


        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50
                        px-4 py-4 sm:px-5
                        text-red-800 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>

                    <div class="text-sm sm:text-base font-medium">
                        {{ session('error') }}
                    </div>

                </div>
            </div>
        @endif


        {{-- =====================================================
             LISTE DES CAISSES
        ====================================================== --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">

            @forelse($caisses as $caisse)

                <div class="caisse-card bg-white rounded-2xl
                            border border-slate-200
                            shadow-sm overflow-hidden">

                    {{-- =================================================
                         PARTIE PRINCIPALE
                    ================================================== --}}
                    <div class="p-5 sm:p-6">

                        {{-- Nom + icône --}}
                        <div class="flex items-start justify-between gap-4 mb-6">

                            <div class="flex items-center gap-3 min-w-0">

                                <div class="flex-shrink-0 flex items-center justify-center
                                            w-11 h-11 sm:w-12 sm:h-12
                                            rounded-xl bg-blue-50 text-blue-600">

                                    <svg class="w-6 h-6"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M3 10h18M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                                    </svg>

                                </div>

                                <div class="min-w-0">
                                    <h2 class="text-base sm:text-lg font-bold text-slate-900 truncate">
                                        {{ $caisse->nom }}
                                    </h2>

                                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                                        Caisse
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                             SOLDE
                        ================================================== --}}
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 mb-5">

                            <div class="flex items-center justify-between gap-3">

                                <div>
                                    <p class="text-xs sm:text-sm font-medium text-slate-500 mb-1">
                                        Solde disponible
                                    </p>

                                    <p class="text-xl sm:text-2xl font-extrabold tracking-tight text-slate-900">
                                        {{ number_format($caisse->solde, 2) }}
                                        <span class="text-sm sm:text-base font-semibold text-slate-500">
                                            GNF
                                        </span>
                                    </p>
                                </div>

                                {{-- Badge solde --}}
                                <span class="
                                    inline-flex items-center gap-1.5
                                    px-2.5 py-1.5
                                    rounded-full
                                    text-xs font-bold
                                    whitespace-nowrap
                                    {{ $caisse->solde >= 0
                                        ? 'balance-positive'
                                        : 'balance-negative' }}
                                ">

                                    @if($caisse->solde >= 0)

                                        <svg class="w-3.5 h-3.5"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M5 10l7-7 7 7M12 3v18"/>
                                        </svg>

                                        Positif

                                    @else

                                        <svg class="w-3.5 h-3.5"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M19 14l-7 7-7-7m7 7V3"/>
                                        </svg>

                                        Négatif

                                    @endif

                                </span>

                            </div>

                        </div>


                        {{-- =================================================
                             ACTIONS
                        ================================================== --}}
                        <div class="grid grid-cols-3 gap-2">

                            {{-- Détails --}}
                            <a href="{{ route('caisses.show', $caisse) }}"
                               class="action-btn inline-flex items-center justify-center gap-1.5
                                      px-2 py-2.5
                                      rounded-xl
                                      bg-indigo-50 hover:bg-indigo-100
                                      text-indigo-700
                                      border border-indigo-100
                                      text-xs sm:text-sm font-semibold
                                      focus:outline-none focus:ring-4 focus:ring-indigo-500/10">

                                <svg class="w-4 h-4 flex-shrink-0"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>

                                <span>Détails</span>
                            </a>


                            {{-- Modifier --}}
                            <a href="{{ route('caisses.edit', $caisse) }}"
                               class="action-btn inline-flex items-center justify-center gap-1.5
                                      px-2 py-2.5
                                      rounded-xl
                                      bg-amber-50 hover:bg-amber-100
                                      text-amber-700
                                      border border-amber-100
                                      text-xs sm:text-sm font-semibold
                                      focus:outline-none focus:ring-4 focus:ring-amber-500/10">

                                <svg class="w-4 h-4 flex-shrink-0"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>

                                <span>Modifier</span>
                            </a>


                            {{-- Supprimer --}}
                            <form action="{{ route('caisses.destroy', $caisse) }}"
                                  method="POST"
                                  class="w-full">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="action-btn w-full inline-flex items-center justify-center gap-1.5
                                               px-2 py-2.5
                                               rounded-xl
                                               bg-red-50 hover:bg-red-100
                                               text-red-700
                                               border border-red-100
                                               text-xs sm:text-sm font-semibold
                                               focus:outline-none focus:ring-4 focus:ring-red-500/10"
                                        onclick="return confirm('Voulez-vous vraiment supprimer cette caisse ?')">

                                    <svg class="w-4 h-4 flex-shrink-0"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-5 0V4h4v3m-7 0h10"/>
                                    </svg>

                                    <span>Supprimer</span>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @empty

                {{-- =================================================
                     AUCUNE CAISSE
                ================================================== --}}
                <div class="sm:col-span-2 xl:col-span-3">

                    <div class="bg-white border border-slate-200
                                rounded-2xl shadow-sm
                                px-5 py-12 sm:py-16
                                text-center">

                        <div class="mx-auto flex items-center justify-center
                                    w-16 h-16
                                    rounded-2xl
                                    bg-slate-100 text-slate-400 mb-5">

                            <svg class="w-8 h-8"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M3 10h18M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                            </svg>

                        </div>

                        <h3 class="text-lg sm:text-xl font-bold text-slate-800">
                            Aucune caisse trouvée
                        </h3>

                        <p class="mt-2 text-sm sm:text-base text-slate-500 max-w-md mx-auto">
                            Vous n'avez encore créé aucune caisse.
                            Commencez par créer votre première caisse.
                        </p>

                        <a href="{{ route('caisses.create') }}"
                           class="action-btn mt-6 inline-flex items-center justify-center gap-2
                                  px-5 py-3
                                  rounded-xl
                                  bg-blue-600 hover:bg-blue-700
                                  text-white
                                  text-sm sm:text-base
                                  font-semibold
                                  shadow-lg shadow-blue-600/20">

                            <svg class="w-5 h-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 4v16m8-8H4"/>
                            </svg>

                            Créer une caisse

                        </a>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection
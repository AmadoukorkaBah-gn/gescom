@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #caissesPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    #caissesPage .action-btn {
        transition:
            background-color .2s ease,
            color .2s ease,
            transform .15s ease;
    }

    #caissesPage .action-btn:hover {
        transform: translateY(-1px);
    }
</style>


<div id="caissesPage" class="w-full">

    {{-- =========================================================
         CONTENEUR PRINCIPAL
    ========================================================== --}}
    <div class="w-full max-w-[1500px] mx-auto px-3 sm:px-5 lg:px-8 xl:px-10 py-4 sm:py-6 lg:py-8">


        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}
        <div class="flex flex-col lg:flex-row
                    lg:items-center
                    lg:justify-between
                    gap-5
                    mb-6 lg:mb-8">

            {{-- TITRE --}}
            <div class="flex items-center gap-3 sm:gap-4 min-w-0">

                <div class="w-11 h-11 sm:w-12 sm:h-12
                            bg-blue-600
                            rounded-xl
                            flex items-center justify-center
                            shadow-sm
                            shrink-0">

                    <i class="fas fa-wallet text-white text-lg sm:text-xl"></i>

                </div>

                <div class="min-w-0">

                    <h1 class="text-xl sm:text-2xl lg:text-3xl
                               font-bold
                               text-gray-900
                               tracking-tight">

                        Gestion des caisses

                    </h1>

                    <p class="text-xs sm:text-sm lg:text-base
                              text-gray-500
                              mt-1">

                        Gérez vos caisses et consultez leurs soldes.

                    </p>

                </div>

            </div>


            {{-- NOUVELLE CAISSE --}}
            <a href="{{ route('caisses.create') }}"
               class="w-full lg:w-auto
                      inline-flex
                      items-center
                      justify-center
                      gap-2
                      min-h-[44px] sm:min-h-[46px]
                      px-5
                      bg-blue-600
                      hover:bg-blue-700
                      active:bg-blue-800
                      text-white
                      text-sm sm:text-base
                      font-semibold
                      rounded-xl
                      shadow-sm
                      transition duration-200">

                <i class="fas fa-plus text-sm"></i>

                <span>Nouvelle caisse</span>

            </a>

        </div>


        {{-- =========================================================
             MESSAGES
        ========================================================== --}}

        @if(session('success'))

            <div class="flex items-start gap-3
                        bg-green-50
                        border border-green-200
                        text-green-800
                        px-4 py-3.5
                        rounded-xl
                        mb-5
                        shadow-sm">

                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>

                <span class="text-sm sm:text-base leading-5">
                    {{ session('success') }}
                </span>

            </div>

        @endif


        @if(session('error'))

            <div class="flex items-start gap-3
                        bg-red-50
                        border border-red-200
                        text-red-800
                        px-4 py-3.5
                        rounded-xl
                        mb-5
                        shadow-sm">

                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                </div>

                <span class="text-sm sm:text-base leading-5">
                    {{ session('error') }}
                </span>

            </div>

        @endif


        {{-- =========================================================
             PETIT RÉSUMÉ
        ========================================================== --}}

        @if($caisses->count() > 0)

            <div class="flex items-center justify-between
                        mb-4 sm:mb-5">

                <div>

                    <h2 class="text-base sm:text-lg
                               font-semibold
                               text-gray-800">

                        Vos caisses

                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">

                        {{ $caisses->count() }}
                        {{ $caisses->count() > 1 ? 'caisses disponibles' : 'caisse disponible' }}

                    </p>

                </div>

                <div class="hidden sm:flex
                            items-center justify-center
                            w-9 h-9
                            rounded-lg
                            bg-blue-50
                            text-blue-600">

                    <i class="fas fa-wallet text-sm"></i>

                </div>

            </div>

        @endif


        {{-- =========================================================
             LISTE DES CAISSES
        ========================================================== --}}

        <div class="grid
                    grid-cols-1
                    sm:grid-cols-2
                    xl:grid-cols-3
                    2xl:grid-cols-4
                    gap-4 sm:gap-5 lg:gap-6">


            @forelse($caisses as $caisse)


                {{-- =================================================
                     CARTE CAISSE
                ================================================== --}}

                <div class="group
                            bg-white
                            border border-gray-200
                            rounded-2xl
                            shadow-sm
                            hover:shadow-md
                            hover:border-blue-200
                            p-4 sm:p-5
                            flex flex-col
                            min-h-[245px]
                            transition duration-200">


                    {{-- =================================================
                         EN-TÊTE CARTE
                    ================================================== --}}

                    <div class="flex items-start
                                justify-between
                                gap-3
                                pb-4
                                border-b border-gray-100">


                        {{-- Nom --}}
                        <div class="flex items-center
                                    gap-3
                                    min-w-0">

                            <div class="w-10 h-10
                                        bg-blue-50
                                        border border-blue-100
                                        rounded-xl
                                        flex items-center
                                        justify-center
                                        shrink-0">

                                <i class="fas fa-wallet text-blue-600"></i>

                            </div>


                            <div class="min-w-0">

                                <h3 class="text-sm sm:text-base
                                           font-bold
                                           text-gray-900
                                           truncate">

                                    {{ $caisse->nom }}

                                </h3>

                                <p class="text-xs
                                          text-gray-400
                                          mt-0.5">

                                    Caisse

                                </p>

                            </div>

                        </div>


                        {{-- Indicateur solde --}}
                        <div class="shrink-0">

                            @if($caisse->solde >= 0)

                                <span class="inline-flex
                                             items-center
                                             gap-1.5
                                             px-2.5 py-1
                                             bg-green-50
                                             border border-green-100
                                             text-green-700
                                             rounded-full
                                             text-[11px] sm:text-xs
                                             font-semibold">

                                    <span class="w-1.5 h-1.5
                                                 rounded-full
                                                 bg-green-500"></span>

                                    Positif

                                </span>

                            @else

                                <span class="inline-flex
                                             items-center
                                             gap-1.5
                                             px-2.5 py-1
                                             bg-red-50
                                             border border-red-100
                                             text-red-700
                                             rounded-full
                                             text-[11px] sm:text-xs
                                             font-semibold">

                                    <span class="w-1.5 h-1.5
                                                 rounded-full
                                                 bg-red-500"></span>

                                    Négatif

                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                         SOLDE
                    ================================================== --}}

                    <div class="py-5 flex-1">

                        <p class="text-xs
                                  font-medium
                                  text-gray-400
                                  uppercase
                                  tracking-wide
                                  mb-2">

                            Solde disponible

                        </p>


                        <div class="flex items-baseline
                                    gap-1.5
                                    min-w-0">

                            <span class="text-xl sm:text-2xl lg:text-[25px]
                                         font-bold
                                         tracking-tight
                                         truncate
                                         {{ $caisse->solde >= 0
                                             ? 'text-gray-900'
                                             : 'text-red-600' }}">

                                {{ number_format($caisse->solde, 2) }}

                            </span>

                            <span class="text-xs sm:text-sm
                                         font-semibold
                                         text-gray-400
                                         shrink-0">

                                GNF

                            </span>

                        </div>

                    </div>


                    {{-- =================================================
                         ACTIONS
                    ================================================== --}}

                    <div class="pt-3
                                border-t border-gray-100
                                flex items-center justify-between">


                        {{-- VOIR --}}
                        <a href="{{ route('caisses.show', $caisse) }}"
                           title="Voir les détails"
                           aria-label="Voir les détails"
                           class="action-btn
                                  inline-flex
                                  items-center
                                  justify-center
                                  w-10 h-10
                                  rounded-xl
                                  text-blue-600
                                  hover:bg-blue-50
                                  active:bg-blue-100">

                            <i class="fas fa-eye text-sm"></i>

                        </a>


                        {{-- MODIFIER --}}
                        <a href="{{ route('caisses.edit', $caisse) }}"
                           title="Modifier"
                           aria-label="Modifier"
                           class="action-btn
                                  inline-flex
                                  items-center
                                  justify-center
                                  w-10 h-10
                                  rounded-xl
                                  text-yellow-600
                                  hover:bg-yellow-50
                                  active:bg-yellow-100">

                            <i class="fas fa-pen text-sm"></i>

                        </a>


                        {{-- SUPPRIMER --}}
                        <form action="{{ route('caisses.destroy', $caisse) }}"
                              method="POST"
                              class="inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    title="Supprimer"
                                    aria-label="Supprimer"
                                    class="action-btn
                                           inline-flex
                                           items-center
                                           justify-center
                                           w-10 h-10
                                           rounded-xl
                                           text-red-600
                                           hover:bg-red-50
                                           active:bg-red-100"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette caisse ?')">

                                <i class="fas fa-trash-alt text-sm"></i>

                            </button>

                        </form>


                    </div>

                </div>


            @empty


                {{-- =================================================
                     AUCUNE CAISSE
                ================================================== --}}

                <div class="col-span-1
                            sm:col-span-2
                            xl:col-span-3
                            2xl:col-span-4">

                    <div class="bg-white
                                border border-gray-200
                                rounded-2xl
                                shadow-sm
                                p-8 sm:p-12
                                text-center">


                        <div class="w-16 h-16
                                    mx-auto
                                    bg-blue-50
                                    border border-blue-100
                                    rounded-2xl
                                    flex items-center
                                    justify-center
                                    mb-5">

                            <i class="fas fa-wallet
                                      text-blue-500
                                      text-2xl"></i>

                        </div>


                        <h2 class="text-lg sm:text-xl
                                   font-bold
                                   text-gray-800
                                   mb-2">

                            Aucune caisse trouvée

                        </h2>


                        <p class="text-sm
                                  text-gray-500
                                  mb-6">

                            Vous n'avez encore créé aucune caisse.

                        </p>


                        <a href="{{ route('caisses.create') }}"
                           class="inline-flex
                                  items-center
                                  justify-center
                                  gap-2
                                  min-h-[44px]
                                  px-5
                                  bg-blue-600
                                  hover:bg-blue-700
                                  text-white
                                  text-sm
                                  font-semibold
                                  rounded-xl
                                  shadow-sm
                                  transition duration-200">

                            <i class="fas fa-plus text-xs"></i>

                            Créer une caisse

                        </a>

                    </div>

                </div>


            @endforelse


        </div>

    </div>

</div>

@endsection
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
</style>


<div id="caissesPage"
     class="container mx-auto px-3 sm:px-4 lg:px-6 py-6 sm:py-8">


    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row
                sm:items-center
                sm:justify-between
                gap-4
                mb-6 sm:mb-8">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 sm:w-12 sm:h-12
                        bg-blue-600
                        rounded-xl
                        flex items-center justify-center
                        shadow-sm
                        shrink-0">

                <i class="fas fa-wallet text-white text-lg"></i>

            </div>

            <div>

                <h1 class="text-xl sm:text-2xl lg:text-3xl
                           font-bold
                           text-gray-800
                           tracking-tight">

                    Gestion des Caisses

                </h1>

                <p class="text-xs sm:text-sm
                          text-gray-500
                          mt-1">

                    Gérez vos caisses et leurs soldes.

                </p>

            </div>

        </div>


        {{-- Nouvelle caisse --}}
        <a href="{{ route('caisses.create') }}"
           class="inline-flex
                  items-center
                  justify-center
                  min-h-[46px]
                  w-full sm:w-auto
                  px-5
                  bg-blue-600
                  hover:bg-blue-700
                  text-white
                  text-sm sm:text-base
                  font-bold
                  rounded-xl
                  shadow-sm
                  transition duration-200">

            <i class="fas fa-plus mr-2"></i>

            Nouvelle Caisse

        </a>

    </div>


    {{-- =====================================================
         MESSAGES
    ====================================================== --}}

    @if(session('success'))

        <div class="flex items-start gap-3
                    bg-green-50
                    border border-green-200
                    text-green-800
                    px-4 py-3
                    rounded-xl
                    mb-5
                    text-sm sm:text-base">

            <i class="fas fa-check-circle mt-0.5"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('error'))

        <div class="flex items-start gap-3
                    bg-red-50
                    border border-red-200
                    text-red-800
                    px-4 py-3
                    rounded-xl
                    mb-5
                    text-sm sm:text-base">

            <i class="fas fa-exclamation-circle mt-0.5"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         LISTE DES CAISSES
    ====================================================== --}}

    <div class="grid
                grid-cols-1
                sm:grid-cols-2
                lg:grid-cols-3
                xl:grid-cols-4
                gap-4 sm:gap-5 lg:gap-6">


        @forelse($caisses as $caisse)


            {{-- =================================================
                 CARTE CAISSE
            ================================================== --}}

            <div class="bg-white
                        border-2 border-blue-100
                        hover:border-blue-400
                        rounded-2xl
                        shadow-md
                        hover:shadow-lg
                        p-4 sm:p-5
                        transition duration-200">


                {{-- En-tête carte --}}
                <div class="flex items-start
                            justify-between
                            gap-3
                            mb-5">


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

                            <i class="fas fa-wallet
                                      text-blue-600"></i>

                        </div>


                        <div class="min-w-0">

                            <h2 class="text-base sm:text-lg
                                       font-bold
                                       text-gray-800
                                       truncate">

                                {{ $caisse->nom }}

                            </h2>

                            <p class="text-xs
                                      text-gray-400
                                      mt-0.5">

                                Caisse

                            </p>

                        </div>

                    </div>


                    {{-- Solde --}}
                    <span class="shrink-0
                                 px-2.5 py-1.5
                                 rounded-full
                                 text-xs sm:text-sm
                                 font-bold
                                 whitespace-nowrap
                                 {{ $caisse->solde >= 0
                                     ? 'bg-green-100 text-green-800'
                                     : 'bg-red-100 text-red-800' }}">

                        {{ number_format($caisse->solde, 2) }} GNF

                    </span>

                </div>


                {{-- =================================================
                     INFORMATIONS
                ================================================== --}}

                <div class="bg-gray-50
                            border border-gray-100
                            rounded-xl
                            px-4 py-3
                            mb-5">

                    <p class="text-xs
                              text-gray-400
                              mb-1">

                        Solde disponible

                    </p>

                    <p class="text-lg sm:text-xl
                              font-bold
                              {{ $caisse->solde >= 0
                                  ? 'text-green-600'
                                  : 'text-red-600' }}">

                        {{ number_format($caisse->solde, 2) }}

                        <span class="text-xs sm:text-sm
                                     font-semibold
                                     text-gray-400">

                            GNF

                        </span>

                    </p>

                </div>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}

                <div class="grid
                            grid-cols-1
                            sm:grid-cols-3
                            gap-2">


                    {{-- Détails --}}
                    <a href="{{ route('caisses.show', $caisse) }}"
                       class="inline-flex
                              items-center
                              justify-center
                              min-h-[42px]
                              px-3
                              bg-indigo-500
                              hover:bg-indigo-600
                              text-white
                              text-xs sm:text-sm
                              font-semibold
                              rounded-xl
                              transition duration-200">

                        <i class="fas fa-eye mr-1.5"></i>

                        Détails

                    </a>


                    {{-- Modifier --}}
                    <a href="{{ route('caisses.edit', $caisse) }}"
                       class="inline-flex
                              items-center
                              justify-center
                              min-h-[42px]
                              px-3
                              bg-yellow-500
                              hover:bg-yellow-600
                              text-white
                              text-xs sm:text-sm
                              font-semibold
                              rounded-xl
                              transition duration-200">

                        <i class="fas fa-edit mr-1.5"></i>

                        Modifier

                    </a>


                    {{-- Supprimer --}}
                    <form action="{{ route('caisses.destroy', $caisse) }}"
                          method="POST"
                          class="w-full">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="w-full
                                       min-h-[42px]
                                       px-3
                                       bg-red-500
                                       hover:bg-red-600
                                       text-white
                                       text-xs sm:text-sm
                                       font-semibold
                                       rounded-xl
                                       transition duration-200"
                                onclick="return confirm('Voulez-vous vraiment supprimer cette caisse ?')">

                            <i class="fas fa-trash mr-1.5"></i>

                            Supprimer

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
                        lg:col-span-3
                        xl:col-span-4">

                <div class="bg-white
                            border-2 border-dashed
                            border-blue-200
                            rounded-2xl
                            p-8 sm:p-12
                            text-center">

                    <div class="w-16 h-16
                                mx-auto
                                bg-blue-50
                                border border-blue-100
                                rounded-2xl
                                flex items-center
                                justify-center
                                mb-4">

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
                              mb-5">

                        Vous n'avez encore créé aucune caisse.

                    </p>

                    <a href="{{ route('caisses.create') }}"
                       class="inline-flex
                              items-center
                              justify-center
                              min-h-[44px]
                              px-5
                              bg-blue-600
                              hover:bg-blue-700
                              text-white
                              text-sm
                              font-semibold
                              rounded-xl
                              transition duration-200">

                        <i class="fas fa-plus mr-2"></i>

                        Créer une caisse

                    </a>

                </div>

            </div>


        @endforelse

    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #caisseCreatePage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    #caisseCreatePage input {
        font-family: inherit;
    }
</style>


<div id="caisseCreatePage"
     class="container mx-auto px-3 sm:px-4 lg:px-6 py-6 sm:py-8">

    <div class="max-w-2xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="mb-6 sm:mb-8">

            <div class="flex items-center gap-3 mb-2">

                <div class="w-11 h-11 sm:w-12 sm:h-12
                            bg-blue-600
                            rounded-xl
                            flex items-center justify-center
                            shadow-sm
                            shrink-0">

                    <i class="fas fa-cash-register
                              text-white
                              text-lg"></i>

                </div>

                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl
                               font-bold
                               text-gray-800
                               tracking-tight">

                        Nouvelle Caisse

                    </h1>

                    <p class="text-sm sm:text-base
                              text-gray-500
                              mt-1">

                        Créez une nouvelle caisse et définissez son solde initial.

                    </p>
                </div>

            </div>

        </div>


        {{-- =====================================================
             FORMULAIRE
        ====================================================== --}}
        <form action="{{ route('caisses.store') }}"
              method="POST"
              class="bg-white
                     border-2 border-blue-500
                     rounded-2xl
                     shadow-lg
                     overflow-hidden">

            @csrf


            {{-- =================================================
                 EN-TÊTE DU FORMULAIRE
            ================================================== --}}
            <div class="bg-blue-50
                        border-b border-blue-100
                        px-4 sm:px-6 lg:px-8
                        py-4 sm:py-5">

                <h2 class="text-base sm:text-lg
                           font-bold
                           text-gray-800">

                    Informations de la caisse

                </h2>

                <p class="text-xs sm:text-sm
                          text-gray-500
                          mt-1">

                    Remplissez les informations ci-dessous.

                </p>

            </div>


            {{-- =================================================
                 CHAMPS
            ================================================== --}}
            <div class="p-4 sm:p-6 lg:p-8">

                {{-- Nom --}}
                <div class="mb-5">

                    <label for="nom"
                           class="block
                                  text-sm sm:text-base
                                  font-semibold
                                  text-gray-700
                                  mb-2">

                        Nom de la caisse

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0
                                    flex items-center
                                    pl-3
                                    pointer-events-none">

                            <i class="fas fa-wallet text-blue-500"></i>

                        </div>

                        <input type="text"
                               name="nom"
                               id="nom"
                               value="{{ old('nom') }}"
                               placeholder="Ex : Caisse principale"
                               class="w-full
                                      min-h-[46px]
                                      pl-10 pr-3
                                      border-2
                                      rounded-xl
                                      bg-white
                                      text-gray-800
                                      text-sm sm:text-base
                                      outline-none
                                      transition duration-200
                                      focus:border-blue-500
                                      focus:ring-2
                                      focus:ring-blue-100
                                      @error('nom')
                                          border-red-500
                                      @else
                                          border-blue-100
                                      @enderror"
                               required>

                    </div>

                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Solde --}}
                <div class="mb-6">

                    <label for="solde"
                           class="block
                                  text-sm sm:text-base
                                  font-semibold
                                  text-gray-700
                                  mb-2">

                        Solde initial (GNF)

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0
                                    flex items-center
                                    pl-3
                                    pointer-events-none">

                            <i class="fas fa-money-bill-wave
                                      text-blue-500"></i>

                        </div>

                        <input type="number"
                               name="solde"
                               id="solde"
                               step="0.01"
                               min="0"
                               value="{{ old('solde', 0) }}"
                               placeholder="0.00"
                               class="w-full
                                      min-h-[46px]
                                      pl-10 pr-16
                                      border-2
                                      rounded-xl
                                      bg-white
                                      text-gray-800
                                      text-sm sm:text-base
                                      outline-none
                                      transition duration-200
                                      focus:border-blue-500
                                      focus:ring-2
                                      focus:ring-blue-100
                                      @error('solde')
                                          border-red-500
                                      @else
                                          border-blue-100
                                      @enderror"
                               required>

                        <span class="absolute
                                     inset-y-0 right-0
                                     flex items-center
                                     pr-3
                                     text-xs sm:text-sm
                                     font-semibold
                                     text-gray-400">

                            GNF

                        </span>

                    </div>

                    @error('solde')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}
                <div class="flex flex-col-reverse
                            sm:flex-row
                            gap-3
                            pt-5
                            border-t border-gray-100">

                    {{-- Annuler --}}
                    <a href="{{ route('caisses.index') }}"
                       class="inline-flex
                              items-center
                              justify-center
                              min-h-[46px]
                              w-full sm:w-auto
                              px-5
                              bg-gray-500
                              hover:bg-gray-600
                              text-white
                              text-sm sm:text-base
                              font-semibold
                              rounded-xl
                              shadow-sm
                              transition duration-200">

                        <i class="fas fa-times mr-2"></i>

                        Annuler

                    </a>


                    {{-- Enregistrer --}}
                    <button type="submit"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   min-h-[46px]
                                   w-full sm:w-auto
                                   px-6
                                   bg-blue-600
                                   hover:bg-blue-700
                                   text-white
                                   text-sm sm:text-base
                                   font-bold
                                   rounded-xl
                                   shadow-sm
                                   transition duration-200">

                        <i class="fas fa-save mr-2"></i>

                        Enregistrer

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #clientDetailsPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }
</style>


<div id="clientDetailsPage"
     class="container mx-auto px-3 sm:px-4 lg:px-6 py-6 sm:py-8">

    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row
                sm:items-center sm:justify-between
                gap-4 mb-6 sm:mb-8">

        <div>

            <h1 class="text-xl sm:text-2xl lg:text-3xl
                       font-bold
                       text-gray-800
                       tracking-tight">

                Détails du Client

            </h1>

            <p class="text-sm sm:text-base
                      text-gray-500
                      mt-1">

                Informations détaillées du client.

            </p>

        </div>


        {{-- Retour --}}
        <a href="{{ route('clients.index') }}"
           class="inline-flex items-center
                  justify-center
                  w-full sm:w-auto
                  min-h-[44px]
                  px-5 py-2.5
                  bg-gray-600
                  hover:bg-gray-700
                  text-white
                  text-sm sm:text-base
                  font-semibold
                  rounded-xl
                  shadow-sm
                  transition duration-200">

            <i class="fas fa-arrow-left mr-2"></i>

            Retour à la liste

        </a>

    </div>


    {{-- =====================================================
         CARTE PRINCIPALE
    ====================================================== --}}
    <div class="bg-white
                border-2 border-blue-500
                rounded-2xl
                shadow-lg
                overflow-hidden">


        {{-- =================================================
             EN-TÊTE DE LA CARTE
        ================================================== --}}
        <div class="bg-blue-50
                    border-b border-blue-100
                    px-4 sm:px-6 lg:px-8
                    py-5">

            <div class="flex items-center gap-4">

                {{-- Icône --}}
                <div class="w-12 h-12 sm:w-14 sm:h-14
                            rounded-xl
                            bg-blue-600
                            flex items-center justify-center
                            shrink-0
                            shadow-sm">

                    <i class="fas fa-user
                              text-white
                              text-lg sm:text-xl"></i>

                </div>


                <div class="min-w-0">

                    <h2 class="text-lg sm:text-xl
                               font-bold
                               text-gray-800
                               break-words">

                        {{ $client->nom_client }}

                    </h2>

                    <p class="text-sm
                              text-gray-500
                              mt-0.5">

                        Informations du client

                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
             INFORMATIONS
        ================================================== --}}
        <div class="p-4 sm:p-6 lg:p-8">

            <div class="grid grid-cols-1
                        md:grid-cols-2
                        gap-4 sm:gap-5">


                {{-- =================================================
                     NOM
                ================================================== --}}
                <div class="border-2
                            border-blue-100
                            hover:border-blue-300
                            rounded-xl
                            p-4
                            transition duration-200">

                    <div class="flex items-start gap-3">

                        <div class="w-10 h-10
                                    rounded-lg
                                    bg-blue-50
                                    flex items-center justify-center
                                    shrink-0">

                            <i class="fas fa-user
                                      text-blue-600"></i>

                        </div>


                        <div class="min-w-0">

                            <p class="text-xs sm:text-sm
                                      font-medium
                                      text-gray-400
                                      mb-1">

                                Nom du client

                            </p>

                            <p class="text-sm sm:text-base
                                      font-bold
                                      text-gray-800
                                      break-words">

                                {{ $client->nom_client }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     CONTACT
                ================================================== --}}
                <div class="border-2
                            border-blue-100
                            hover:border-blue-300
                            rounded-xl
                            p-4
                            transition duration-200">

                    <div class="flex items-start gap-3">

                        <div class="w-10 h-10
                                    rounded-lg
                                    bg-blue-50
                                    flex items-center justify-center
                                    shrink-0">

                            <i class="fas fa-phone
                                      text-blue-600"></i>

                        </div>


                        <div class="min-w-0">

                            <p class="text-xs sm:text-sm
                                      font-medium
                                      text-gray-400
                                      mb-1">

                                Contact

                            </p>

                            <p class="text-sm sm:text-base
                                      font-bold
                                      text-gray-800
                                      break-words">

                                {{ $client->contact_client ?? '-' }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     ADRESSE
                ================================================== --}}
                <div class="md:col-span-2
                            border-2
                            border-blue-100
                            hover:border-blue-300
                            rounded-xl
                            p-4
                            transition duration-200">

                    <div class="flex items-start gap-3">

                        <div class="w-10 h-10
                                    rounded-lg
                                    bg-blue-50
                                    flex items-center justify-center
                                    shrink-0">

                            <i class="fas fa-map-marker-alt
                                      text-blue-600"></i>

                        </div>


                        <div class="min-w-0">

                            <p class="text-xs sm:text-sm
                                      font-medium
                                      text-gray-400
                                      mb-1">

                                Adresse

                            </p>

                            <p class="text-sm sm:text-base
                                      font-bold
                                      text-gray-800
                                      break-words">

                                {{ $client->adresse_client ?? '-' }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 ACTIONS
            ================================================== --}}
            <div class="flex flex-col
                        sm:flex-row
                        gap-3
                        mt-6 sm:mt-8
                        pt-5 sm:pt-6
                        border-t border-gray-100">


                {{-- Retour --}}
                <a href="{{ route('clients.index') }}"
                   class="inline-flex items-center
                          justify-center
                          min-h-[44px]
                          w-full sm:w-auto
                          px-5
                          bg-gray-500
                          hover:bg-gray-600
                          text-white
                          text-sm sm:text-base
                          font-semibold
                          rounded-xl
                          transition duration-200">

                    <i class="fas fa-arrow-left mr-2"></i>

                    Retour à la liste

                </a>


                {{-- Modifier --}}
                <a href="{{ route('clients.edit', $client->id) }}"
                   class="inline-flex items-center
                          justify-center
                          min-h-[44px]
                          w-full sm:w-auto
                          px-5
                          bg-yellow-500
                          hover:bg-yellow-600
                          text-white
                          text-sm sm:text-base
                          font-semibold
                          rounded-xl
                          transition duration-200">

                    <i class="fas fa-edit mr-2"></i>

                    Modifier

                </a>

            </div>

        </div>

    </div>

</div>

@endsection
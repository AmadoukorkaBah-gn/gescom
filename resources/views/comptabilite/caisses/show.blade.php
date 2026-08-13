@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    #caisse-show-page {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
    }
</style>

<div id="caisse-show-page" class="min-h-screen bg-gray-50">

    <div class="container mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-7 lg:py-8">

        <!-- =====================================================
             EN-TÊTE
        ====================================================== -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div class="min-w-0">
                <p class="text-xs sm:text-sm font-semibold text-blue-600 uppercase tracking-wide mb-1">
                    Gestion financière
                </p>

                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 break-words">
                    Caisse : {{ $caisse->nom }}
                </h1>
            </div>

            <a href="{{ route('caisses.index') }}"
               class="inline-flex items-center justify-center w-full sm:w-auto
                      bg-gray-600 hover:bg-gray-700
                      text-white font-semibold
                      px-4 py-2.5 rounded-lg
                      shadow-sm transition duration-200
                      text-sm sm:text-base">

                <span class="mr-2">←</span>
                Retour
            </a>

        </div>


        <!-- =====================================================
             SOLDE ACTUEL
        ====================================================== -->
        <div class="bg-white rounded-xl shadow-sm
                    border border-blue-200
                    overflow-hidden mb-6">

            <div class="p-5 sm:p-6 lg:p-8">

                <div class="text-center">

                    <p class="text-sm sm:text-base font-semibold text-gray-500 mb-3">
                        Solde actuel
                    </p>

                    <p class="text-3xl sm:text-4xl lg:text-5xl font-extrabold
                              {{ $caisse->solde >= 0 ? 'text-green-600' : 'text-red-600' }}
                              break-words">

                        {{ number_format($caisse->solde, 2) }}

                        <span class="text-lg sm:text-xl lg:text-2xl font-bold">
                            GNF
                        </span>

                    </p>

                </div>

            </div>

        </div>


        <!-- =====================================================
             RECETTES / DÉPENSES
        ====================================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6">


            <!-- =================================================
                 DERNIÈRES RECETTES
            ================================================== -->
            <div class="bg-white rounded-xl shadow-sm
                        border border-blue-200
                        overflow-hidden">

                <!-- En-tête -->
                <div class="flex items-center justify-between
                            px-4 sm:px-6 py-4
                            border-b border-blue-100
                            bg-blue-50">

                    <h2 class="text-base sm:text-lg font-bold text-gray-900 flex items-center">

                        <span class="flex items-center justify-center
                                     w-9 h-9 rounded-lg
                                     bg-green-100 text-green-600
                                     mr-3 text-lg">
                            📈
                        </span>

                        Dernières Recettes

                    </h2>

                </div>


                <!-- Liste -->
                <div class="p-4 sm:p-6">

                    @forelse($caisse->recettes as $recette)

                        <div class="flex flex-col sm:flex-row
                                    sm:items-center sm:justify-between
                                    gap-3
                                    py-4
                                    border-b border-gray-100
                                    last:border-b-0">

                            <!-- Informations -->
                            <div class="min-w-0">

                                <p class="font-semibold text-gray-900
                                          text-sm sm:text-base
                                          break-words">

                                    {{ $recette->libelle }}

                                </p>

                                <p class="text-xs sm:text-sm text-gray-500 mt-1">

                                    {{ $recette->date_recette->format('d/m/Y à H:i') }}

                                </p>

                            </div>


                            <!-- Montant -->
                            <span class="self-start sm:self-center
                                         inline-flex items-center
                                         whitespace-nowrap
                                         px-3 py-1.5
                                         rounded-full
                                         bg-green-100
                                         text-green-700
                                         font-bold
                                         text-sm">

                                +{{ number_format($recette->montant, 2) }} GNF

                            </span>

                        </div>

                    @empty

                        <div class="text-center py-8">

                            <div class="text-3xl mb-2">
                                📭
                            </div>

                            <p class="text-sm sm:text-base text-gray-500">
                                Aucune recette
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            <!-- =================================================
                 DERNIÈRES DÉPENSES
            ================================================== -->
            <div class="bg-white rounded-xl shadow-sm
                        border border-blue-200
                        overflow-hidden">

                <!-- En-tête -->
                <div class="flex items-center justify-between
                            px-4 sm:px-6 py-4
                            border-b border-blue-100
                            bg-blue-50">

                    <h2 class="text-base sm:text-lg font-bold text-gray-900 flex items-center">

                        <span class="flex items-center justify-center
                                     w-9 h-9 rounded-lg
                                     bg-red-100 text-red-600
                                     mr-3 text-lg">
                            📉
                        </span>

                        Dernières Dépenses

                    </h2>

                </div>


                <!-- Liste -->
                <div class="p-4 sm:p-6">

                    @forelse($caisse->depenses as $depense)

                        <div class="flex flex-col sm:flex-row
                                    sm:items-center sm:justify-between
                                    gap-3
                                    py-4
                                    border-b border-gray-100
                                    last:border-b-0">

                            <!-- Informations -->
                            <div class="min-w-0">

                                <p class="font-semibold text-gray-900
                                          text-sm sm:text-base
                                          break-words">

                                    {{ $depense->libelle }}

                                </p>

                                <p class="text-xs sm:text-sm text-gray-500 mt-1">

                                    {{ $depense->date_depense->format('d/m/Y à H:i') }}

                                </p>

                            </div>


                            <!-- Montant -->
                            <span class="self-start sm:self-center
                                         inline-flex items-center
                                         whitespace-nowrap
                                         px-3 py-1.5
                                         rounded-full
                                         bg-red-100
                                         text-red-700
                                         font-bold
                                         text-sm">

                                -{{ number_format($depense->montant, 2) }} GNF

                            </span>

                        </div>

                    @empty

                        <div class="text-center py-8">

                            <div class="text-3xl mb-2">
                                📭
                            </div>

                            <p class="text-sm sm:text-base text-gray-500">
                                Aucune dépense
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
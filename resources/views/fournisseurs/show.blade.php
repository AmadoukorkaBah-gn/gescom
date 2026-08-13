@extends('layouts.app')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-5 sm:py-8">

    <!-- En-tête -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 tracking-tight">
                    Détails du Fournisseur
                </h1>

                <p class="mt-1 text-sm sm:text-base text-gray-500">
                    Informations détaillées sur ce fournisseur
                </p>
            </div>

            <a href="{{ route('fournisseurs.index') }}"
               class="inline-flex items-center justify-center gap-2
                      w-full sm:w-auto
                      px-4 py-2.5
                      bg-gray-600 hover:bg-gray-700
                      text-white font-semibold
                      rounded-xl shadow-sm
                      transition duration-200
                      focus:outline-none focus:ring-2 focus:ring-gray-400">

                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>

        </div>
    </div>


    <!-- Carte principale -->
    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <!-- Bandeau -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-5 sm:px-7 py-5">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 sm:w-14 sm:h-14
                                rounded-full bg-white/20
                                flex items-center justify-center
                                flex-shrink-0">

                        <i class="fas fa-truck text-white text-xl sm:text-2xl"></i>

                    </div>

                    <div class="min-w-0">
                        <h2 class="text-lg sm:text-xl font-bold text-white truncate">
                            {{ $fournisseur->nom_fournisseur }}
                        </h2>

                        <p class="text-orange-100 text-sm">
                            Informations du fournisseur
                        </p>
                    </div>

                </div>

            </div>


            <!-- Informations -->
            <div class="p-5 sm:p-7">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">

                    <!-- Nom -->
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                        <div class="flex items-center gap-3 mb-2">

                            <div class="w-9 h-9 rounded-lg bg-orange-100
                                        flex items-center justify-center">
                                <i class="fas fa-user text-orange-600"></i>
                            </div>

                            <span class="text-xs sm:text-sm font-semibold
                                         text-gray-500 uppercase tracking-wide">
                                Nom
                            </span>

                        </div>

                        <p class="text-base sm:text-lg font-bold text-gray-800 break-words">
                            {{ $fournisseur->nom_fournisseur }}
                        </p>

                    </div>


                    <!-- Email -->
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                        <div class="flex items-center gap-3 mb-2">

                            <div class="w-9 h-9 rounded-lg bg-blue-100
                                        flex items-center justify-center">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>

                            <span class="text-xs sm:text-sm font-semibold
                                         text-gray-500 uppercase tracking-wide">
                                Email
                            </span>

                        </div>

                        <p class="text-base sm:text-lg font-semibold text-gray-800 break-words">
                            {{ $fournisseur->email ?? 'Non renseigné' }}
                        </p>

                    </div>


                    <!-- Téléphone -->
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                        <div class="flex items-center gap-3 mb-2">

                            <div class="w-9 h-9 rounded-lg bg-green-100
                                        flex items-center justify-center">
                                <i class="fas fa-phone text-green-600"></i>
                            </div>

                            <span class="text-xs sm:text-sm font-semibold
                                         text-gray-500 uppercase tracking-wide">
                                Téléphone
                            </span>

                        </div>

                        <p class="text-base sm:text-lg font-semibold text-gray-800 break-words">
                            {{ $fournisseur->contact_fournisseur ?? 'Non renseigné' }}
                        </p>

                    </div>


                    <!-- Adresse -->
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                        <div class="flex items-center gap-3 mb-2">

                            <div class="w-9 h-9 rounded-lg bg-purple-100
                                        flex items-center justify-center">
                                <i class="fas fa-location-dot text-purple-600"></i>
                            </div>

                            <span class="text-xs sm:text-sm font-semibold
                                         text-gray-500 uppercase tracking-wide">
                                Adresse
                            </span>

                        </div>

                        <p class="text-base sm:text-lg font-semibold text-gray-800 break-words">
                            {{ $fournisseur->adresse_fournisseur ?? 'Non renseigné' }}
                        </p>

                    </div>

                </div>


                <!-- Actions -->
                <div class="mt-7 pt-6 border-t border-gray-100">

                    <div class="flex flex-col sm:flex-row gap-3">

                        <a href="{{ route('fournisseurs.edit', $fournisseur->id) }}"
                           class="inline-flex items-center justify-center gap-2
                                  w-full sm:w-auto
                                  px-5 py-2.5
                                  bg-yellow-500 hover:bg-yellow-600
                                  text-white font-bold
                                  rounded-xl shadow-sm
                                  transition duration-200
                                  focus:outline-none focus:ring-2 focus:ring-yellow-400">

                            <i class="fas fa-edit"></i>
                            Modifier
                        </a>

                        <a href="{{ route('fournisseurs.index') }}"
                           class="inline-flex items-center justify-center gap-2
                                  w-full sm:w-auto
                                  px-5 py-2.5
                                  bg-gray-100 hover:bg-gray-200
                                  text-gray-700 font-semibold
                                  rounded-xl
                                  transition duration-200">

                            <i class="fas fa-list"></i>
                            Liste des fournisseurs
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection
@extends('layouts.app')

@section('content')

<div class="w-full max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-7 lg:py-8">

    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 tracking-tight">
                Liste des Recettes
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Gestion des entrées de caisse
            </p>
        </div>

        <a href="{{ route('recettes.create') }}"
           class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                  bg-green-600 hover:bg-green-700 active:bg-green-800
                  text-white font-semibold
                  px-4 sm:px-5 py-2.5
                  rounded-xl shadow-sm hover:shadow
                  transition duration-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>

            <span>Nouvelle Recette</span>
        </a>
    </div>


    {{-- =====================================================
         MESSAGE SUCCÈS
    ====================================================== --}}
    @if(session('success'))

        <div class="mb-5 flex items-start gap-3
                    bg-green-50 border border-green-200
                    text-green-800
                    px-4 py-3
                    rounded-xl shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5 flex-shrink-0 mt-0.5 text-green-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <span class="text-sm sm:text-base font-medium">
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         MESSAGE ERREUR
    ====================================================== --}}
    @if(session('error'))

        <div class="mb-5 flex items-start gap-3
                    bg-red-50 border border-red-200
                    text-red-800
                    px-4 py-3
                    rounded-xl shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.48 0z"/>
            </svg>

            <span class="text-sm sm:text-base font-medium">
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         TABLEAU
    ====================================================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Titre mobile --}}
        <div class="px-4 sm:px-5 py-4 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl
                            bg-green-100
                            flex items-center justify-center
                            flex-shrink-0">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-green-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10V4m0 16v-2m8-6a8 8 0 11-16 0 8 8 0 0116 0z"/>
                    </svg>

                </div>

                <div>
                    <h2 class="font-bold text-gray-800 text-base sm:text-lg">
                        Recettes enregistrées
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500">
                        Historique des entrées financières
                    </p>
                </div>

            </div>

        </div>


        {{-- =================================================
             CONTENEUR RESPONSIVE
        ================================================== --}}
        <div class="overflow-x-auto">

            <table class="min-w-[760px] w-full divide-y divide-gray-200">

                {{-- EN-TÊTE --}}
                <thead class="bg-green-600">

                    <tr>

                        <th class="px-4 sm:px-5 py-3.5
                                   text-left
                                   text-xs font-bold text-white
                                   uppercase tracking-wider">
                            Date
                        </th>

                        <th class="px-4 sm:px-5 py-3.5
                                   text-left
                                   text-xs font-bold text-white
                                   uppercase tracking-wider">
                            Libellé
                        </th>

                        <th class="px-4 sm:px-5 py-3.5
                                   text-left
                                   text-xs font-bold text-white
                                   uppercase tracking-wider">
                            Caisse
                        </th>

                        <th class="px-4 sm:px-5 py-3.5
                                   text-right
                                   text-xs font-bold text-white
                                   uppercase tracking-wider">
                            Montant
                        </th>

                        <th class="px-4 sm:px-5 py-3.5
                                   text-left
                                   text-xs font-bold text-white
                                   uppercase tracking-wider">
                            Actions
                        </th>

                    </tr>

                </thead>


                {{-- CORPS --}}
                <tbody class="bg-white divide-y divide-gray-100">

                    @forelse($recettes as $recette)

                    <tr class="hover:bg-green-50/40 transition duration-150">

                        {{-- DATE --}}
                        <td class="px-4 sm:px-5 py-4 whitespace-nowrap">

                            <div class="flex items-center gap-2">

                                <div class="w-8 h-8 rounded-lg
                                            bg-gray-100
                                            flex items-center justify-center
                                            flex-shrink-0">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4 text-gray-500"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>

                                </div>

                                <span class="text-sm text-gray-700 font-medium">
                                    {{ $recette->date_recette->format('d/m/Y à H:i') }}
                                </span>

                            </div>

                        </td>


                        {{-- LIBELLÉ --}}
                        <td class="px-4 sm:px-5 py-4">

                            <span class="text-sm font-semibold text-gray-800">
                                {{ $recette->libelle }}
                            </span>

                        </td>


                        {{-- CAISSE --}}
                        <td class="px-4 sm:px-5 py-4">

                            <span class="inline-flex items-center
                                         px-2.5 py-1
                                         rounded-lg
                                         bg-gray-100
                                         text-gray-700
                                         text-sm font-medium">

                                {{ $recette->caisse->nom ?? '-' }}

                            </span>

                        </td>


                        {{-- MONTANT --}}
                        <td class="px-4 sm:px-5 py-4 text-right whitespace-nowrap">

                            <span class="inline-flex items-center
                                         px-3 py-1.5
                                         rounded-lg
                                         bg-green-50
                                         text-green-700
                                         text-sm font-bold">

                                +{{ number_format($recette->montant, 2) }} GNF

                            </span>

                        </td>


                        {{-- ACTIONS --}}
                        <td class="px-4 sm:px-5 py-4">

                            <div class="flex flex-wrap items-center gap-2">

                                <a href="{{ route('recettes.edit', $recette->id) }}"
                                   class="inline-flex items-center gap-1.5
                                          bg-yellow-500 hover:bg-yellow-600
                                          text-white
                                          px-3 py-2
                                          rounded-lg
                                          text-xs sm:text-sm
                                          font-semibold
                                          transition duration-200">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-8.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"/>

                                    </svg>

                                    Modifier

                                </a>


                                <form action="{{ route('recettes.destroy', $recette->id) }}"
                                      method="POST"
                                      class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5
                                                   bg-red-500 hover:bg-red-600
                                                   text-white
                                                   px-3 py-2
                                                   rounded-lg
                                                   text-xs sm:text-sm
                                                   font-semibold
                                                   transition duration-200"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cette recette ?')">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-4 h-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-3a1 1 0 00-1 1v3m-4 0h12"/>

                                        </svg>

                                        Supprimer

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="px-4 py-12 text-center">

                            <div class="flex flex-col items-center justify-center">

                                <div class="w-14 h-14 rounded-full
                                            bg-gray-100
                                            flex items-center justify-center
                                            mb-3">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-7 h-7 text-gray-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10V4m0 16v-2m8-6a8 8 0 11-16 0 8 8 0 0116 0z"/>

                                    </svg>

                                </div>

                                <p class="text-gray-600 font-semibold">
                                    Aucune recette trouvée
                                </p>

                                <p class="text-gray-400 text-sm mt-1">
                                    Les recettes enregistrées apparaîtront ici.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         PAGINATION
    ====================================================== --}}
    <div class="mt-5 flex justify-center sm:justify-end">
        {{ $recettes->links() }}
    </div>

</div>

@endsection
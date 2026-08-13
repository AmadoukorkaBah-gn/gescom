@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #fournisseursPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;

        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }
</style>


<div id="fournisseursPage"
     class="w-full max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-6 lg:py-8">


    {{-- =========================================================
     EN-TÊTE
========================================================== --}}

<div class="flex flex-col sm:flex-row
            sm:items-center
            sm:justify-between
            gap-4
            mb-6 sm:mb-8">

    <div class="min-w-0">

        <h1 class="text-xl sm:text-2xl lg:text-3xl
                   font-bold
                   text-gray-800
                   tracking-tight">

            Liste des Fournisseurs

        </h1>

        <p class="mt-1 text-xs sm:text-sm lg:text-base text-gray-500">

            Gestion de vos fournisseurs

        </p>

    </div>


    {{-- Ajouter --}}

    <a href="{{ route('fournisseurs.create') }}"
       class="w-full sm:w-auto
              inline-flex items-center justify-center gap-2
              min-h-[44px]
              px-4 sm:px-5
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

        <span>Ajouter un fournisseur</span>

    </a>

</div>



{{-- =========================================================
     MESSAGE DE SUCCÈS
========================================================== --}}

@if(session('success'))

    <div class="mb-5
                flex items-start gap-3
                bg-green-50
                border border-green-200
                text-green-800
                px-4 py-3.5
                rounded-xl
                shadow-sm">

        <div class="flex-shrink-0
                    w-7 h-7
                    rounded-full
                    bg-green-100
                    flex items-center
                    justify-center">

            <i class="fas fa-check text-green-600 text-xs"></i>

        </div>

        <p class="text-sm sm:text-base font-medium pt-1">

            {{ session('success') }}

        </p>

    </div>

@endif



{{-- =========================================================
     CONTENEUR PRINCIPAL
========================================================== --}}

<div class="bg-white
            rounded-2xl
            shadow-sm
            border border-gray-200
            overflow-hidden">


    {{-- =====================================================
         BARRE SUPÉRIEURE
    ====================================================== --}}

    <div class="px-4 sm:px-5 lg:px-6
                py-4 sm:py-5
                border-b border-gray-100
                bg-gray-50/80">

        <div class="flex items-center justify-between gap-3">

            <div class="flex items-center gap-3 min-w-0">

                <div class="w-10 h-10
                            rounded-xl
                            bg-orange-100
                            flex items-center justify-center
                            flex-shrink-0">

                    <i class="fas fa-truck
                              text-orange-600
                              text-base"></i>

                </div>


                <div class="min-w-0">

                    <h2 class="text-base sm:text-lg
                               font-bold
                               text-gray-800">

                        Fournisseurs

                    </h2>

                    <p class="text-xs sm:text-sm
                              text-gray-500
                              mt-0.5">

                        Liste des fournisseurs enregistrés

                    </p>

                </div>

            </div>


            {{-- Nombre --}}

            <div class="hidden sm:flex
                        items-center justify-center
                        px-3 py-1.5
                        rounded-lg
                        bg-white
                        border border-gray-200
                        text-xs
                        font-semibold
                        text-gray-500
                        whitespace-nowrap">

                {{ $fournisseurs->total() ?? $fournisseurs->count() }}
                fournisseur(s)

            </div>

        </div>

    </div>



    {{-- =====================================================
         TABLEAU RESPONSIVE
    ====================================================== --}}

    <div class="overflow-x-auto">

        <table class="w-full min-w-[900px] divide-y divide-gray-100">


            {{-- =================================================
                 EN-TÊTE DU TABLEAU
            ================================================== --}}

            <thead class="bg-gray-50">

                <tr>

                    <th class="w-16
                               px-4 sm:px-5
                               py-3.5
                               text-left
                               text-[11px] sm:text-xs
                               font-bold
                               text-gray-500
                               uppercase
                               tracking-wider
                               whitespace-nowrap">

                        N°

                    </th>


                    <th class="px-4 sm:px-5
                               py-3.5
                               text-left
                               text-[11px] sm:text-xs
                               font-bold
                               text-gray-500
                               uppercase
                               tracking-wider
                               whitespace-nowrap">

                        Nom

                    </th>


                    <th class="px-4 sm:px-5
                               py-3.5
                               text-left
                               text-[11px] sm:text-xs
                               font-bold
                               text-gray-500
                               uppercase
                               tracking-wider
                               whitespace-nowrap">

                        Email

                    </th>


                    <th class="px-4 sm:px-5
                               py-3.5
                               text-left
                               text-[11px] sm:text-xs
                               font-bold
                               text-gray-500
                               uppercase
                               tracking-wider
                               whitespace-nowrap">

                        Téléphone

                    </th>


                    <th class="px-4 sm:px-5
                               py-3.5
                               text-left
                               text-[11px] sm:text-xs
                               font-bold
                               text-gray-500
                               uppercase
                               tracking-wider
                               whitespace-nowrap">

                        Adresse

                    </th>


                    <th class="w-36
                               px-4 sm:px-5
                               py-3.5
                               text-center
                               text-[11px] sm:text-xs
                               font-bold
                               text-gray-500
                               uppercase
                               tracking-wider
                               whitespace-nowrap">

                        Actions

                    </th>

                </tr>

            </thead>



            {{-- =================================================
                 CORPS
            ================================================== --}}

            <tbody class="bg-white divide-y divide-gray-100">

                @forelse($fournisseurs as $fournisseur)

                    <tr class="group
                               hover:bg-gray-50/70
                               transition duration-150">


                        {{-- N° --}}

                        <td class="px-4 sm:px-5
                                   py-4
                                   text-sm
                                   font-semibold
                                   text-gray-500
                                   whitespace-nowrap">

                            {{ $loop->iteration }}

                        </td>



                        {{-- NOM --}}

                        <td class="px-4 sm:px-5
                                   py-4
                                   text-sm
                                   font-semibold
                                   text-gray-800
                                   whitespace-nowrap">

                            {{ $fournisseur->nom_fournisseur }}

                        </td>



                        {{-- EMAIL --}}

                        <td class="px-4 sm:px-5
                                   py-4
                                   text-sm
                                   text-gray-600
                                   whitespace-nowrap">

                            {{ $fournisseur->email ?: '-' }}

                        </td>



                        {{-- TÉLÉPHONE --}}

                        <td class="px-4 sm:px-5
                                   py-4
                                   text-sm
                                   text-gray-700
                                   whitespace-nowrap">

                            {{ $fournisseur->contact_fournisseur ?: '-' }}

                        </td>



                        {{-- ADRESSE --}}

                        <td class="px-4 sm:px-5
                                   py-4
                                   text-sm
                                   text-gray-600">

                            <div class="max-w-xs
                                        truncate"
                                 title="{{ $fournisseur->adresse_fournisseur }}">

                                {{ $fournisseur->adresse_fournisseur ?: '-' }}

                            </div>

                        </td>



                        {{-- =================================================
                             ACTIONS
                        ================================================== --}}

                        <td class="px-4 sm:px-5 py-4">

                            <div class="flex
                                        items-center
                                        justify-center
                                        gap-2.5">


                                {{-- =========================
                                     VOIR
                                ========================== --}}

                                <a href="{{ route('fournisseurs.show', $fournisseur->id) }}"
                                   title="Voir le fournisseur"
                                   aria-label="Voir le fournisseur"

                                   class="action-icon action-view">

                                    <i class="fas fa-eye"></i>

                                </a>



                                {{-- =========================
                                     MODIFIER
                                ========================== --}}

                                <a href="{{ route('fournisseurs.edit', $fournisseur->id) }}"
                                   title="Modifier le fournisseur"
                                   aria-label="Modifier le fournisseur"

                                   class="action-icon action-edit">

                                    <i class="fas fa-pen"></i>

                                </a>



                                {{-- =========================
                                     SUPPRIMER
                                ========================== --}}

                                <form
                                    action="{{ route('fournisseurs.destroy', $fournisseur->id) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        title="Supprimer le fournisseur"
                                        aria-label="Supprimer le fournisseur"

                                        class="action-icon action-delete"

                                        onclick="return confirm('Voulez-vous vraiment supprimer ce fournisseur ?')">

                                        <i class="fas fa-trash-alt"></i>

                                    </button>

                                </form>


                            </div>

                        </td>

                    </tr>


                @empty


                    {{-- =================================================
                         AUCUN FOURNISSEUR
                    ================================================== --}}

                    <tr>

                        <td colspan="6"
                            class="px-4 py-16 text-center">

                            <div class="flex
                                        flex-col
                                        items-center
                                        justify-center">


                                <div class="w-16 h-16
                                            rounded-2xl
                                            bg-gray-100
                                            flex items-center
                                            justify-center
                                            mb-4">

                                    <i class="fas fa-truck
                                              text-gray-400
                                              text-2xl"></i>

                                </div>


                                <p class="text-base sm:text-lg
                                          font-semibold
                                          text-gray-700">

                                    Aucun fournisseur trouvé

                                </p>


                                <p class="text-xs sm:text-sm
                                          text-gray-400
                                          mt-1">

                                    Commencez par ajouter un fournisseur.

                                </p>


                                <a
                                    href="{{ route('fournisseurs.create') }}"
                                    class="mt-5
                                           inline-flex
                                           items-center
                                           justify-center
                                           gap-2
                                           min-h-[42px]
                                           px-4
                                           bg-blue-600
                                           hover:bg-blue-700
                                           text-white
                                           text-sm
                                           font-semibold
                                           rounded-xl
                                           shadow-sm
                                           transition">

                                    <i class="fas fa-plus text-xs"></i>

                                    Ajouter un fournisseur

                                </a>

                            </div>

                        </td>

                    </tr>


                @endforelse

            </tbody>

        </table>

    </div>



    {{-- =========================================================
         PAGINATION
    ========================================================== --}}

    @if($fournisseurs->hasPages())

        <div class="px-4 sm:px-6
                    py-4
                    border-t border-gray-100
                    bg-gray-50/70
                    overflow-x-auto">

            {{ $fournisseurs->links() }}

        </div>

    @endif


</div>

</div>

@endsection
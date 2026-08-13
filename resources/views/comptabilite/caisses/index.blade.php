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
     class="w-full max-w-7xl mx-auto px-3 sm:px-5 lg:px-8 py-5 sm:py-6 lg:py-8">


    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}

    <div class="flex flex-col sm:flex-row
                sm:items-center
                sm:justify-between
                gap-4
                mb-6">

        <div class="flex items-center gap-3 min-w-0">

            {{-- Icône --}}
            <div class="w-11 h-11 sm:w-12 sm:h-12
                        bg-blue-600
                        rounded-xl
                        flex items-center justify-center
                        shadow-sm
                        shrink-0">

                <i class="fas fa-wallet text-white text-lg"></i>

            </div>


            {{-- Titre --}}
            <div class="min-w-0">

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
                  min-h-[44px]
                  w-full sm:w-auto
                  px-5
                  bg-blue-600
                  hover:bg-blue-700
                  active:bg-blue-800
                  text-white
                  text-sm
                  font-semibold
                  rounded-xl
                  shadow-sm
                  transition
                  duration-200">

            <i class="fas fa-plus mr-2"></i>

            Nouvelle caisse

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

            <i class="fas fa-check-circle mt-0.5 text-green-600"></i>

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

            <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         CONTENEUR PRINCIPAL
    ====================================================== --}}

    <div class="bg-white
                border border-gray-200
                rounded-2xl
                shadow-sm
                overflow-hidden">


        {{-- =================================================
             EN-TÊTE DU TABLEAU
        ================================================== --}}

        <div class="px-4 sm:px-6 py-4
                    border-b border-gray-100
                    bg-gray-50/70">

            <div class="flex items-center justify-between gap-3">

                <div class="flex items-center gap-3">

                    <div class="w-9 h-9
                                rounded-lg
                                bg-blue-50
                                text-blue-600
                                flex items-center justify-center">

                        <i class="fas fa-wallet"></i>

                    </div>

                    <div>

                        <h2 class="text-base sm:text-lg
                                   font-semibold
                                   text-gray-800">

                            Liste des caisses

                        </h2>

                        <p class="text-xs sm:text-sm
                                  text-gray-500
                                  mt-0.5">

                            Caisses disponibles et soldes actuels

                        </p>

                    </div>

                </div>


                {{-- Nombre de caisses --}}
                <div class="hidden sm:flex
                            items-center
                            gap-2
                            px-3 py-1.5
                            bg-white
                            border border-gray-200
                            rounded-lg">

                    <i class="fas fa-layer-group
                              text-gray-400
                              text-xs"></i>

                    <span class="text-xs
                                 font-semibold
                                 text-gray-600">

                        {{ $caisses->count() }}

                        caisse{{ $caisses->count() > 1 ? 's' : '' }}

                    </span>

                </div>

            </div>

        </div>


        {{-- =====================================================
             AFFICHAGE DESKTOP
        ====================================================== --}}

        <div class="hidden md:block overflow-x-auto">

            <table class="w-full min-w-[760px]">

                {{-- En-tête --}}
                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>

                        <th class="px-5 py-3.5
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-500
                                   uppercase
                                   tracking-wide
                                   whitespace-nowrap">

                            N°

                        </th>


                        <th class="px-5 py-3.5
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-500
                                   uppercase
                                   tracking-wide
                                   whitespace-nowrap">

                            Caisse

                        </th>


                        <th class="px-5 py-3.5
                                   text-right
                                   text-xs
                                   font-semibold
                                   text-gray-500
                                   uppercase
                                   tracking-wide
                                   whitespace-nowrap">

                            Solde

                        </th>


                        <th class="px-5 py-3.5
                                   text-center
                                   text-xs
                                   font-semibold
                                   text-gray-500
                                   uppercase
                                   tracking-wide
                                   whitespace-nowrap">

                            État

                        </th>


                        <th class="px-5 py-3.5
                                   text-right
                                   text-xs
                                   font-semibold
                                   text-gray-500
                                   uppercase
                                   tracking-wide
                                   whitespace-nowrap">

                            Actions

                        </th>

                    </tr>

                </thead>


                {{-- Corps --}}
                <tbody class="divide-y divide-gray-100">

                    @forelse($caisses as $caisse)

                        <tr class="hover:bg-gray-50/70
                                   transition-colors
                                   duration-150">


                            {{-- N° --}}
                            <td class="px-5 py-4
                                       text-sm
                                       text-gray-500
                                       whitespace-nowrap">

                                {{ $loop->iteration }}

                            </td>


                            {{-- CAISSE --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10
                                                rounded-xl
                                                bg-blue-50
                                                border border-blue-100
                                                flex items-center
                                                justify-center
                                                shrink-0">

                                        <i class="fas fa-wallet
                                                  text-blue-600"></i>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-sm
                                                  font-semibold
                                                  text-gray-800
                                                  truncate">

                                            {{ $caisse->nom }}

                                        </p>

                                        <p class="text-xs
                                                  text-gray-400
                                                  mt-0.5">

                                            Caisse

                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- SOLDE --}}
                            <td class="px-5 py-4
                                       text-right
                                       whitespace-nowrap">

                                <span class="text-sm
                                             font-bold
                                             {{ $caisse->solde >= 0
                                                 ? 'text-green-600'
                                                 : 'text-red-600' }}">

                                    {{ number_format($caisse->solde, 2) }}

                                </span>

                                <span class="text-xs
                                             font-semibold
                                             text-gray-400
                                             ml-1">

                                    GNF

                                </span>

                            </td>


                            {{-- ÉTAT --}}
                            <td class="px-5 py-4
                                       text-center
                                       whitespace-nowrap">

                                @if($caisse->solde >= 0)

                                    <span class="inline-flex
                                                 items-center
                                                 gap-1.5
                                                 px-2.5 py-1.5
                                                 rounded-full
                                                 bg-green-50
                                                 text-green-700
                                                 text-xs
                                                 font-semibold">

                                        <span class="w-1.5 h-1.5
                                                     rounded-full
                                                     bg-green-500"></span>

                                        Solde positif

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 items-center
                                                 gap-1.5
                                                 px-2.5 py-1.5
                                                 rounded-full
                                                 bg-red-50
                                                 text-red-700
                                                 text-xs
                                                 font-semibold">

                                        <span class="w-1.5 h-1.5
                                                     rounded-full
                                                     bg-red-500"></span>

                                        Solde négatif

                                    </span>

                                @endif

                            </td>


                            {{-- ACTIONS --}}
                            <td class="px-5 py-4">

                                <div class="flex
                                            items-center
                                            justify-end
                                            gap-1.5">


                                    {{-- VOIR --}}
                                    <a href="{{ route('caisses.show', $caisse) }}"
                                       title="Voir les détails"
                                       aria-label="Voir les détails"
                                       class="w-9 h-9
                                              inline-flex
                                              items-center
                                              justify-center
                                              rounded-lg
                                              text-blue-600
                                              hover:bg-blue-50
                                              active:bg-blue-100
                                              transition">

                                        <i class="fas fa-eye text-sm"></i>

                                    </a>


                                    {{-- MODIFIER --}}
                                    <a href="{{ route('caisses.edit', $caisse) }}"
                                       title="Modifier"
                                       aria-label="Modifier"
                                       class="w-9 h-9
                                              inline-flex
                                              items-center
                                              justify-center
                                              rounded-lg
                                              text-yellow-600
                                              hover:bg-yellow-50
                                              active:bg-yellow-100
                                              transition">

                                        <i class="fas fa-edit text-sm"></i>

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
                                                class="w-9 h-9
                                                       inline-flex
                                                       items-center
                                                       justify-center
                                                       rounded-lg
                                                       text-red-600
                                                       hover:bg-red-50
                                                       active:bg-red-100
                                                       transition"
                                                onclick="return confirm('Voulez-vous vraiment supprimer cette caisse ?')">

                                            <i class="fas fa-trash text-sm"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-5 py-14
                                       text-center">

                                <div class="flex flex-col
                                            items-center
                                            justify-center">

                                    <div class="w-14 h-14
                                                rounded-full
                                                bg-gray-100
                                                flex items-center
                                                justify-center
                                                mb-4">

                                        <i class="fas fa-wallet
                                                  text-gray-400
                                                  text-xl"></i>

                                    </div>

                                    <p class="text-sm sm:text-base
                                              font-semibold
                                              text-gray-600">

                                        Aucune caisse trouvée

                                    </p>

                                    <p class="text-xs sm:text-sm
                                              text-gray-400
                                              mt-1">

                                        Vous n'avez encore créé aucune caisse.

                                    </p>

                                    <a href="{{ route('caisses.create') }}"
                                       class="mt-4
                                              inline-flex
                                              items-center
                                              gap-2
                                              bg-blue-600
                                              hover:bg-blue-700
                                              text-white
                                              text-sm
                                              font-semibold
                                              px-4 py-2.5
                                              rounded-lg
                                              transition">

                                        <i class="fas fa-plus"></i>

                                        Créer une caisse

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             AFFICHAGE MOBILE / TABLETTE
        ====================================================== --}}

        <div class="md:hidden divide-y divide-gray-100">

            @forelse($caisses as $caisse)

                <div class="p-4 sm:p-5">


                    {{-- En-tête --}}
                    <div class="flex items-start
                                justify-between
                                gap-3
                                mb-4">

                        <div class="flex items-center
                                    gap-3
                                    min-w-0">

                            <div class="w-10 h-10
                                        rounded-xl
                                        bg-blue-50
                                        border border-blue-100
                                        flex items-center
                                        justify-center
                                        shrink-0">

                                <i class="fas fa-wallet
                                          text-blue-600"></i>

                            </div>

                            <div class="min-w-0">

                                <h3 class="text-sm sm:text-base
                                           font-semibold
                                           text-gray-800
                                           truncate">

                                    {{ $caisse->nom }}

                                </h3>

                                <p class="text-xs
                                          text-gray-400
                                          mt-0.5">

                                    Caisse #{{ $loop->iteration }}

                                </p>

                            </div>

                        </div>


                        {{-- Solde --}}
                        <div class="text-right
                                    shrink-0">

                            <p class="text-sm sm:text-base
                                      font-bold
                                      {{ $caisse->solde >= 0
                                          ? 'text-green-600'
                                          : 'text-red-600' }}">

                                {{ number_format($caisse->solde, 2) }}

                            </p>

                            <p class="text-xs
                                      font-semibold
                                      text-gray-400">

                                GNF

                            </p>

                        </div>

                    </div>


                    {{-- Informations --}}
                    <div class="flex items-center
                                justify-between
                                gap-3
                                bg-gray-50
                                border border-gray-100
                                rounded-xl
                                px-3 py-2.5
                                mb-4">

                        <span class="text-xs
                                     text-gray-500">

                            Solde disponible

                        </span>


                        @if($caisse->solde >= 0)

                            <span class="inline-flex
                                         items-center
                                         gap-1.5
                                         text-xs
                                         font-semibold
                                         text-green-700">

                                <span class="w-1.5 h-1.5
                                             rounded-full
                                             bg-green-500"></span>

                                Positif

                            </span>

                        @else

                            <span class="inline-flex
                                         items-center
                                         gap-1.5
                                         text-xs
                                         font-semibold
                                         text-red-700">

                                <span class="w-1.5 h-1.5
                                             rounded-full
                                             bg-red-500"></span>

                                Négatif

                            </span>

                        @endif

                    </div>


                    {{-- Actions --}}
                    <div class="flex
                                items-center
                                justify-end
                                gap-1.5">


                        {{-- VOIR --}}
                        <a href="{{ route('caisses.show', $caisse) }}"
                           title="Voir les détails"
                           aria-label="Voir les détails"
                           class="w-10 h-10
                                  inline-flex
                                  items-center
                                  justify-center
                                  rounded-lg
                                  text-blue-600
                                  hover:bg-blue-50
                                  active:bg-blue-100
                                  transition">

                            <i class="fas fa-eye"></i>

                        </a>


                        {{-- MODIFIER --}}
                        <a href="{{ route('caisses.edit', $caisse) }}"
                           title="Modifier"
                           aria-label="Modifier"
                           class="w-10 h-10
                                  inline-flex
                                  items-center
                                  justify-center
                                  rounded-lg
                                  text-yellow-600
                                  hover:bg-yellow-50
                                  active:bg-yellow-100
                                  transition">

                            <i class="fas fa-edit"></i>

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
                                    class="w-10 h-10
                                           inline-flex
                                           items-center
                                           justify-center
                                           rounded-lg
                                           text-red-600
                                           hover:bg-red-50
                                           active:bg-red-100
                                           transition"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette caisse ?')">

                                <i class="fas fa-trash"></i>

                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="px-4 py-12 text-center">

                    <div class="w-14 h-14
                                mx-auto
                                rounded-full
                                bg-gray-100
                                flex items-center
                                justify-center
                                mb-4">

                        <i class="fas fa-wallet
                                  text-gray-400
                                  text-xl"></i>

                    </div>

                    <p class="text-sm
                              font-semibold
                              text-gray-600">

                        Aucune caisse trouvée

                    </p>

                    <p class="text-xs
                              text-gray-400
                              mt-1">

                        Vous n'avez encore créé aucune caisse.

                    </p>

                    <a href="{{ route('caisses.create') }}"
                       class="mt-4
                              inline-flex
                              items-center
                              gap-2
                              bg-blue-600
                              hover:bg-blue-700
                              text-white
                              text-sm
                              font-semibold
                              px-4 py-2.5
                              rounded-lg
                              transition">

                        <i class="fas fa-plus"></i>

                        Créer une caisse

                    </a>

                </div>

            @endforelse

        </div>


        {{-- =====================================================
             PAGINATION
        ====================================================== --}}

        @if(method_exists($caisses, 'links'))

            <div class="px-4 sm:px-6 py-4
                        border-t border-gray-100
                        bg-gray-50/50
                        overflow-x-auto">

                {{ $caisses->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
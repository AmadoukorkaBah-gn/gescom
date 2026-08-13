@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #clientsListPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    #clientsListPage table,
    #clientsListPage input,
    #clientsListPage button,
    #clientsListPage a {
        font-family: inherit;
    }
</style>


<div id="clientsListPage"
     class="container mx-auto px-3 sm:px-4 lg:px-6 py-6 sm:py-8">

    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row
                sm:items-center sm:justify-between
                gap-4 mb-6 sm:mb-8">

        <div>

            <h1 class="text-xl sm:text-2xl lg:text-3xl
                       font-bold text-gray-800 tracking-tight">
                Liste des Clients
            </h1>

            <p class="text-sm sm:text-base text-gray-500 mt-1">
                Consultez et gérez vos clients.
            </p>

        </div>


        <a href="{{ route('clients.create') }}"
           class="inline-flex items-center justify-center
                  w-full sm:w-auto
                  min-h-[46px]
                  px-5 py-2.5
                  bg-blue-600
                  hover:bg-blue-700
                  text-white
                  text-sm sm:text-base
                  font-semibold
                  rounded-xl
                  shadow-sm
                  transition duration-200">

            <i class="fas fa-user-plus mr-2"></i>

            Ajouter un Client

        </a>

    </div>


    {{-- =====================================================
         MESSAGE SUCCESS
    ====================================================== --}}
    @if(session('success'))

        <div class="mb-5
                    bg-green-50
                    border border-green-200
                    text-green-700
                    px-4 py-3
                    rounded-xl
                    text-sm sm:text-base">

            <div class="flex items-center gap-2">

                <i class="fas fa-check-circle"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        </div>

    @endif


    {{-- =====================================================
         CONTENEUR PRINCIPAL
    ====================================================== --}}
    <div class="bg-white
                border-2 border-blue-500
                rounded-2xl
                shadow-lg
                overflow-hidden">


        {{-- =================================================
             PETIT EN-TÊTE DU TABLEAU
        ================================================== --}}
        <div class="bg-blue-50
                    border-b border-blue-100
                    px-4 sm:px-6
                    py-4">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10
                            rounded-xl
                            bg-blue-600
                            flex items-center justify-center
                            shrink-0">

                    <i class="fas fa-users text-white"></i>

                </div>

                <div>

                    <h2 class="font-semibold
                               text-gray-800
                               text-base sm:text-lg">

                        Clients

                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500">

                        Liste des clients enregistrés

                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
             VUE MOBILE : CARTES
        ====================================================== --}}
        <div class="md:hidden p-3 sm:p-4 space-y-3">

            @forelse($clients as $client)

                <div class="border-2 border-blue-100
                            rounded-xl
                            p-4
                            bg-white
                            shadow-sm
                            hover:border-blue-300
                            transition duration-200">

                    {{-- Nom + numéro --}}
                    <div class="flex items-start
                                justify-between
                                gap-3 mb-4">

                        <div class="min-w-0">

                            <p class="text-xs
                                      font-semibold
                                      text-gray-400
                                      mb-1">

                                CLIENT #{{ $loop->iteration }}

                            </p>

                            <h3 class="text-base sm:text-lg
                                       font-bold
                                       text-gray-800
                                       break-words">

                                {{ $client->nom_client }}

                            </h3>

                        </div>


                        <div class="w-9 h-9
                                    rounded-lg
                                    bg-blue-50
                                    flex items-center justify-center
                                    shrink-0">

                            <i class="fas fa-user text-blue-600"></i>

                        </div>

                    </div>


                    {{-- Informations --}}
                    <div class="space-y-3
                                border-t
                                border-gray-100
                                pt-3">

                        {{-- Contact --}}
                        <div class="flex items-start gap-3">

                            <div class="w-8 h-8
                                        rounded-lg
                                        bg-blue-50
                                        flex items-center justify-center
                                        shrink-0">

                                <i class="fas fa-phone text-blue-600 text-xs"></i>

                            </div>

                            <div class="min-w-0">

                                <p class="text-xs text-gray-400">
                                    Contact
                                </p>

                                <p class="text-sm
                                          font-semibold
                                          text-gray-800
                                          break-words">

                                    {{ $client->contact_client ?: '-' }}

                                </p>

                            </div>

                        </div>


                        {{-- Adresse --}}
                        <div class="flex items-start gap-3">

                            <div class="w-8 h-8
                                        rounded-lg
                                        bg-blue-50
                                        flex items-center justify-center
                                        shrink-0">

                                <i class="fas fa-map-marker-alt text-blue-600 text-xs"></i>

                            </div>

                            <div class="min-w-0">

                                <p class="text-xs text-gray-400">
                                    Adresse
                                </p>

                                <p class="text-sm
                                          font-semibold
                                          text-gray-800
                                          break-words">

                                    {{ $client->adresse_client ?: '-' }}

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="grid grid-cols-1
                                sm:grid-cols-3
                                gap-2
                                mt-4 pt-4
                                border-t border-gray-100">


                        {{-- Voir --}}
                        <a href="{{ route('clients.show', $client->id) }}"
                           class="inline-flex items-center
                                  justify-center
                                  min-h-[42px]
                                  px-3
                                  rounded-lg
                                  bg-indigo-500
                                  hover:bg-indigo-600
                                  text-white
                                  text-sm
                                  font-semibold
                                  transition">

                            <i class="fas fa-eye mr-2"></i>

                            Voir

                        </a>


                        {{-- Modifier --}}
                        <a href="{{ route('clients.edit', $client->id) }}"
                           class="inline-flex items-center
                                  justify-center
                                  min-h-[42px]
                                  px-3
                                  rounded-lg
                                  bg-yellow-500
                                  hover:bg-yellow-600
                                  text-white
                                  text-sm
                                  font-semibold
                                  transition">

                            <i class="fas fa-edit mr-2"></i>

                            Éditer

                        </a>


                        {{-- Supprimer --}}
                        <form action="{{ route('clients.destroy', $client->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="w-full
                                           inline-flex items-center
                                           justify-center
                                           min-h-[42px]
                                           px-3
                                           rounded-lg
                                           bg-red-500
                                           hover:bg-red-600
                                           text-white
                                           text-sm
                                           font-semibold
                                           transition"
                                    onclick="return confirm('Voulez-vous vraiment supprimer ce client ?')">

                                <i class="fas fa-trash mr-2"></i>

                                Supprimer

                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="py-10 text-center">

                    <div class="w-14 h-14
                                mx-auto mb-3
                                rounded-full
                                bg-gray-100
                                flex items-center justify-center">

                        <i class="fas fa-users text-gray-400 text-xl"></i>

                    </div>

                    <p class="text-sm sm:text-base
                              font-medium
                              text-gray-500">

                        Aucun client trouvé

                    </p>

                </div>

            @endforelse


            {{-- Pagination mobile --}}
            @if($clients->count())

                <div class="pt-3">
                    {{ $clients->links() }}
                </div>

            @endif

        </div>


        {{-- =====================================================
             VUE TABLEAU : TABLETTE / DESKTOP
        ====================================================== --}}
        <div class="hidden md:block overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                {{-- EN-TÊTE --}}
                <thead class="bg-orange-500">

                    <tr>

                        <th class="px-3 lg:px-4 py-3
                                   text-left
                                   text-xs
                                   font-bold
                                   text-white
                                   uppercase
                                   tracking-wider
                                   whitespace-nowrap">

                            N°

                        </th>

                        <th class="px-3 lg:px-4 py-3
                                   text-left
                                   text-xs
                                   font-bold
                                   text-white
                                   uppercase
                                   tracking-wider">

                            Nom

                        </th>

                        <th class="px-3 lg:px-4 py-3
                                   text-left
                                   text-xs
                                   font-bold
                                   text-white
                                   uppercase
                                   tracking-wider">

                            Contact

                        </th>

                        <th class="px-3 lg:px-4 py-3
                                   text-left
                                   text-xs
                                   font-bold
                                   text-white
                                   uppercase
                                   tracking-wider">

                            Adresse

                        </th>

                        <th class="px-3 lg:px-4 py-3
                                   text-left
                                   text-xs
                                   font-bold
                                   text-white
                                   uppercase
                                   tracking-wider
                                   whitespace-nowrap">

                            Actions

                        </th>

                    </tr>

                </thead>


                {{-- CORPS --}}
                <tbody class="bg-white
                               divide-y divide-gray-200
                               text-gray-800">

                    @forelse($clients as $client)

                        <tr class="hover:bg-blue-50/50
                                   transition duration-150">


                            {{-- N° --}}
                            <td class="px-3 lg:px-4 py-3
                                       text-sm
                                       font-semibold
                                       text-gray-600">

                                {{ $loop->iteration }}

                            </td>


                            {{-- NOM --}}
                            <td class="px-3 lg:px-4 py-3
                                       text-sm
                                       font-semibold
                                       text-gray-900">

                                <div class="flex items-center gap-2">

                                    <div class="w-8 h-8
                                                rounded-lg
                                                bg-blue-50
                                                flex items-center justify-center
                                                shrink-0">

                                        <i class="fas fa-user
                                                  text-blue-600
                                                  text-xs"></i>

                                    </div>

                                    <span>
                                        {{ $client->nom_client }}
                                    </span>

                                </div>

                            </td>


                            {{-- CONTACT --}}
                            <td class="px-3 lg:px-4 py-3
                                       text-sm
                                       font-medium
                                       text-gray-700">

                                {{ $client->contact_client ?: '-' }}

                            </td>


                            {{-- ADRESSE --}}
                            <td class="px-3 lg:px-4 py-3
                                       text-sm
                                       text-gray-700
                                       max-w-xs">

                                <span class="break-words">

                                    {{ $client->adresse_client ?: '-' }}

                                </span>

                            </td>


                            {{-- ACTIONS --}}
                            <td class="px-3 lg:px-4 py-3">

                                <div class="flex flex-wrap gap-1.5">


                                    {{-- Voir --}}
                                    <a href="{{ route('clients.show', $client->id) }}"
                                       class="inline-flex items-center
                                              bg-indigo-500
                                              hover:bg-indigo-600
                                              text-white
                                              px-3 py-1.5
                                              rounded-lg
                                              text-xs
                                              font-semibold
                                              transition">

                                        <i class="fas fa-eye mr-1"></i>

                                        Voir

                                    </a>


                                    {{-- Éditer --}}
                                    <a href="{{ route('clients.edit', $client->id) }}"
                                       class="inline-flex items-center
                                              bg-yellow-500
                                              hover:bg-yellow-600
                                              text-white
                                              px-3 py-1.5
                                              rounded-lg
                                              text-xs
                                              font-semibold
                                              transition">

                                        <i class="fas fa-edit mr-1"></i>

                                        Éditer

                                    </a>


                                    {{-- Supprimer --}}
                                    <form action="{{ route('clients.destroy', $client->id) }}"
                                          method="POST"
                                          class="inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex items-center
                                                       bg-red-500
                                                       hover:bg-red-600
                                                       text-white
                                                       px-3 py-1.5
                                                       rounded-lg
                                                       text-xs
                                                       font-semibold
                                                       transition"
                                                onclick="return confirm('Voulez-vous vraiment supprimer ce client ?')">

                                            <i class="fas fa-trash mr-1"></i>

                                            Supprimer

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-4 py-10
                                       text-center
                                       text-sm
                                       text-gray-500">

                                <div class="flex flex-col
                                            items-center
                                            justify-center">

                                    <div class="w-14 h-14
                                                rounded-full
                                                bg-gray-100
                                                flex items-center justify-center
                                                mb-3">

                                        <i class="fas fa-users
                                                  text-gray-400
                                                  text-xl"></i>

                                    </div>

                                    <span class="font-medium">
                                        Aucun client trouvé
                                    </span>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             PAGINATION DESKTOP
        ====================================================== --}}
        @if($clients->count())

            <div class="hidden md:block
                        px-4 sm:px-6
                        py-4
                        border-t border-gray-100">

                {{ $clients->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
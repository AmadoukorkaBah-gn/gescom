@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #categorieIndexPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    #categorieIndexPage button,
    #categorieIndexPage a {
        font-family: inherit;
    }
</style>


<div id="categorieIndexPage"
     class="container mx-auto px-3 sm:px-4 lg:px-6 py-6 sm:py-8">

    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row
                sm:items-center
                sm:justify-between
                gap-4
                mb-6 sm:mb-8">

        <div>

            <h1 class="text-xl sm:text-2xl lg:text-3xl
                       font-bold text-gray-800 tracking-tight">

                Liste des catégories

            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Gérez les catégories de vos produits.
            </p>

        </div>


        <a href="{{ route('categorie.create') }}"
           class="inline-flex items-center justify-center
                  w-full sm:w-auto
                  min-h-[46px]
                  px-5 py-2.5
                  rounded-xl
                  bg-blue-600
                  border-2 border-blue-600
                  text-white
                  text-sm sm:text-base
                  font-semibold
                  shadow-sm
                  hover:bg-blue-700
                  hover:border-blue-700
                  transition duration-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5 mr-2"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 4v16m8-8H4"/>

            </svg>

            Nouvelle catégorie

        </a>

    </div>


    {{-- =====================================================
         MESSAGE DE SUCCÈS
    ====================================================== --}}
    @if(session('success'))

        <div class="mb-5
                    bg-green-50
                    border border-green-200
                    rounded-xl
                    px-4 py-3">

            <div class="flex items-center gap-3">

                <div class="w-8 h-8
                            rounded-full
                            bg-green-100
                            flex items-center justify-center
                            shrink-0">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-green-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 13l4 4L19 7"/>

                    </svg>

                </div>

                <p class="text-sm sm:text-base
                          font-medium text-green-700">

                    {{ session('success') }}

                </p>

            </div>

        </div>

    @endif


    @if($categories->count())

        {{-- =================================================
             VUE MOBILE
        ================================================== --}}
        <div class="md:hidden space-y-3">

            @foreach($categories as $categorie)

                <div class="bg-white
                            rounded-2xl
                            border-2 border-blue-100
                            shadow-sm
                            overflow-hidden">

                    {{-- En-tête carte --}}
                    <div class="flex items-center
                                justify-between
                                gap-3
                                px-4 py-4
                                bg-blue-50
                                border-b border-blue-100">

                        <div class="flex items-center gap-3 min-w-0">

                            <div class="w-10 h-10
                                        rounded-xl
                                        bg-blue-600
                                        text-white
                                        flex items-center justify-center
                                        font-bold
                                        shrink-0">

                                {{ $categorie->id }}

                            </div>

                            <div class="min-w-0">

                                <p class="text-xs
                                          text-gray-500
                                          font-medium">

                                    Catégorie

                                </p>

                                <h2 class="text-base
                                           font-semibold
                                           text-gray-800
                                           break-words">

                                    {{ $categorie->nom_categorie }}

                                </h2>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="p-4">

                        <div class="grid grid-cols-1
                                    sm:grid-cols-3
                                    gap-2">

                            <a href="{{ route('categorie.show', $categorie) }}"
                               class="inline-flex items-center
                                      justify-center
                                      min-h-[44px]
                                      px-3 py-2
                                      rounded-lg
                                      bg-blue-50
                                      border border-blue-200
                                      text-blue-700
                                      text-sm
                                      font-semibold
                                      hover:bg-blue-100
                                      transition">

                                Voir

                            </a>


                            <a href="{{ route('categorie.edit', $categorie) }}"
                               class="inline-flex items-center
                                      justify-center
                                      min-h-[44px]
                                      px-3 py-2
                                      rounded-lg
                                      bg-yellow-50
                                      border border-yellow-200
                                      text-yellow-700
                                      text-sm
                                      font-semibold
                                      hover:bg-yellow-100
                                      transition">

                                Modifier

                            </a>


                            <form action="{{ route('categorie.destroy', $categorie) }}"
                                  method="POST"
                                  onsubmit="return confirm('Supprimer cette catégorie ?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="w-full
                                               inline-flex items-center
                                               justify-center
                                               min-h-[44px]
                                               px-3 py-2
                                               rounded-lg
                                               bg-red-50
                                               border border-red-200
                                               text-red-700
                                               text-sm
                                               font-semibold
                                               hover:bg-red-100
                                               transition">

                                    Supprimer

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach


            {{-- Pagination mobile --}}
            <div class="pt-3">
                {{ $categories->links() }}
            </div>

        </div>


        {{-- =================================================
             VUE TABLEAU
             TABLETTE / ORDINATEUR
        ================================================== --}}
        <div class="hidden md:block">

            <div class="bg-white
                        rounded-2xl
                        border-2 border-blue-500
                        shadow-lg
                        overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[650px]">

                        {{-- En-tête --}}
                        <thead>

                            <tr class="bg-blue-600">

                                <th class="px-5 py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           text-white
                                           uppercase
                                           tracking-wider">

                                    #

                                </th>

                                <th class="px-5 py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           text-white
                                           uppercase
                                           tracking-wider">

                                    Nom

                                </th>

                                <th class="px-5 py-4
                                           text-right
                                           text-xs
                                           font-bold
                                           text-white
                                           uppercase
                                           tracking-wider">

                                    Actions

                                </th>

                            </tr>

                        </thead>


                        {{-- Corps --}}
                        <tbody class="divide-y divide-blue-100">

                            @foreach($categories as $categorie)

                                <tr class="hover:bg-blue-50/60
                                           transition duration-150">

                                    {{-- ID --}}
                                    <td class="px-5 py-4">

                                        <span class="inline-flex
                                                     items-center
                                                     justify-center
                                                     w-9 h-9
                                                     rounded-lg
                                                     bg-blue-50
                                                     border border-blue-200
                                                     text-blue-700
                                                     text-sm
                                                     font-bold">

                                            {{ $categorie->id }}

                                        </span>

                                    </td>


                                    {{-- Nom --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="w-10 h-10
                                                        rounded-xl
                                                        bg-blue-100
                                                        flex items-center
                                                        justify-center
                                                        shrink-0">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="w-5 h-5 text-blue-600"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="2">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M7 7h.01M7 3h5l9 9-5 5-9-9V3z"/>

                                                </svg>

                                            </div>

                                            <div>

                                                <p class="text-sm
                                                          font-semibold
                                                          text-gray-800">

                                                    {{ $categorie->nom_categorie }}

                                                </p>

                                                <p class="text-xs
                                                          text-gray-400">

                                                    Catégorie #{{ $categorie->id }}

                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-5 py-4">

                                        <div class="flex
                                                    items-center
                                                    justify-end
                                                    gap-2">

                                            <a href="{{ route('categorie.show', $categorie) }}"
                                               class="inline-flex items-center
                                                      justify-center
                                                      min-h-[38px]
                                                      px-4 py-2
                                                      rounded-lg
                                                      bg-blue-50
                                                      border border-blue-200
                                                      text-blue-700
                                                      text-xs
                                                      font-semibold
                                                      hover:bg-blue-100
                                                      transition">

                                                Voir

                                            </a>


                                            <a href="{{ route('categorie.edit', $categorie) }}"
                                               class="inline-flex items-center
                                                      justify-center
                                                      min-h-[38px]
                                                      px-4 py-2
                                                      rounded-lg
                                                      bg-yellow-50
                                                      border border-yellow-200
                                                      text-yellow-700
                                                      text-xs
                                                      font-semibold
                                                      hover:bg-yellow-100
                                                      transition">

                                                Modifier

                                            </a>


                                            <form action="{{ route('categorie.destroy', $categorie) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Supprimer cette catégorie ?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="inline-flex items-center
                                                               justify-center
                                                               min-h-[38px]
                                                               px-4 py-2
                                                               rounded-lg
                                                               bg-red-50
                                                               border border-red-200
                                                               text-red-700
                                                               text-xs
                                                               font-semibold
                                                               hover:bg-red-100
                                                               transition">

                                                    Supprimer

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                <div class="px-5 py-4
                            border-t border-blue-100">

                    {{ $categories->links() }}

                </div>

            </div>

        </div>


    @else

        {{-- =================================================
             AUCUNE CATÉGORIE
        ================================================== --}}
        <div class="bg-white
                    rounded-2xl
                    border-2 border-blue-200
                    shadow-md
                    p-8 sm:p-12
                    text-center">

            <div class="mx-auto
                        w-16 h-16
                        rounded-2xl
                        bg-blue-50
                        border border-blue-100
                        flex items-center
                        justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-8 h-8 text-blue-500"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M7 7h.01M7 3h5l9 9-5 5-9-9V3z"/>

                </svg>

            </div>

            <h2 class="mt-4
                       text-lg sm:text-xl
                       font-semibold text-gray-800">

                Aucune catégorie trouvée

            </h2>

            <p class="mt-1
                      text-sm text-gray-500">

                Commencez par créer votre première catégorie.

            </p>

            <a href="{{ route('categorie.create') }}"
               class="mt-5
                      inline-flex items-center
                      justify-center
                      min-h-[44px]
                      px-5 py-2.5
                      rounded-xl
                      bg-blue-600
                      text-white
                      text-sm
                      font-semibold
                      hover:bg-blue-700
                      transition">

                Nouvelle catégorie

            </a>

        </div>

    @endif

</div>

@endsection
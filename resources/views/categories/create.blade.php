
@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #categorieCreatePage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    #categorieCreatePage input,
    #categorieCreatePage button {
        font-family: inherit;
    }
</style>


<div id="categorieCreatePage"
     class="container mx-auto px-3 sm:px-4 lg:px-6 py-6 sm:py-10">

    <div class="max-w-2xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="mb-6 sm:mb-8">

            <h1 class="text-xl sm:text-2xl lg:text-3xl
                       font-bold text-gray-800 tracking-tight">
                Créer une catégorie
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Ajoutez une nouvelle catégorie à votre catalogue.
            </p>

        </div>


        {{-- =====================================================
             ERREURS DE VALIDATION
        ====================================================== --}}
        @if ($errors->any())

            <div class="mb-5
                        bg-red-50
                        border border-red-200
                        rounded-xl
                        p-4">

                <div class="flex items-start gap-3">

                    <div class="shrink-0
                                w-8 h-8
                                rounded-full
                                bg-red-100
                                flex items-center justify-center">

                        <span class="text-red-600 font-bold">
                            !
                        </span>

                    </div>

                    <div class="min-w-0">

                        <p class="text-sm font-semibold text-red-800 mb-1">
                            Impossible d'enregistrer la catégorie
                        </p>

                        <ul class="text-sm text-red-700 space-y-1">

                            @foreach ($errors->all() as $error)

                                <li>
                                    • {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- =====================================================
             FORMULAIRE
        ====================================================== --}}
        <form action="{{ route('categorie.store') }}"
              method="POST"
              class="bg-white
                     rounded-2xl
                     border-2 border-blue-500
                     shadow-lg
                     overflow-hidden">

            @csrf


            {{-- =================================================
                 EN-TÊTE DU FORMULAIRE
            ================================================== --}}
            <div class="bg-blue-50
                        border-b border-blue-100
                        px-4 sm:px-6
                        py-4 sm:py-5">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10
                                sm:w-11 sm:h-11
                                rounded-xl
                                bg-blue-600
                                flex items-center justify-center
                                shadow-sm">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 sm:w-6 sm:h-6 text-white"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M4 6h16M4 12h16M4 18h16"/>

                        </svg>

                    </div>

                    <div>

                        <h2 class="text-base sm:text-lg
                                   font-semibold text-gray-800">
                            Informations de la catégorie
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                            Renseignez le nom de la nouvelle catégorie.
                        </p>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 CORPS DU FORMULAIRE
            ================================================== --}}
            <div class="p-4 sm:p-6 lg:p-7">

                <div class="mb-6">

                    <label for="nom_categorie"
                           class="block text-sm sm:text-base
                                  font-semibold text-gray-700 mb-2">

                        Nom de la catégorie

                        <span class="text-red-500">*</span>

                    </label>


                    <input type="text"
                           name="nom_categorie"
                           id="nom_categorie"
                           value="{{ old('nom_categorie') }}"
                           placeholder="Ex. Boissons, Médicaments, Alimentaire..."
                           required
                           autocomplete="off"
                           class="block w-full
                                  min-h-[48px]
                                  border-2 border-blue-200
                                  rounded-xl
                                  px-4 py-3
                                  text-sm sm:text-base
                                  text-gray-800
                                  bg-white
                                  placeholder-gray-400
                                  shadow-sm
                                  outline-none
                                  transition duration-200
                                  focus:border-blue-600
                                  focus:ring-4
                                  focus:ring-blue-100
                                  @error('nom_categorie')
                                      border-red-400
                                      focus:border-red-500
                                      focus:ring-red-100
                                  @enderror">


                    @error('nom_categorie')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @else

                        <p class="mt-2 text-xs sm:text-sm text-gray-500">
                            Choisissez un nom simple et facile à identifier.
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}
                <div class="flex flex-col-reverse sm:flex-row
                            gap-3
                            pt-5
                            border-t border-gray-100">

                    <a href="{{ route('categorie.index') }}"
                       class="inline-flex items-center
                              justify-center
                              w-full sm:w-auto
                              min-h-[46px]
                              px-5 py-2.5
                              rounded-xl
                              border-2 border-gray-300
                              bg-white
                              text-gray-700
                              text-sm sm:text-base
                              font-semibold
                              hover:bg-gray-50
                              hover:border-gray-400
                              transition duration-200">

                        Annuler

                    </a>


                    <button type="submit"
                            class="inline-flex items-center
                                   justify-center
                                   w-full sm:w-auto
                                   min-h-[46px]
                                   px-6 py-2.5
                                   rounded-xl
                                   bg-blue-600
                                   border-2 border-blue-600
                                   text-white
                                   text-sm sm:text-base
                                   font-semibold
                                   shadow-sm
                                   hover:bg-blue-700
                                   hover:border-blue-700
                                   active:bg-blue-800
                                   transition duration-200">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 mr-2"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                        Enregistrer

                    </button>

                </div>

            </div>

        </form>


        {{-- =====================================================
             PETIT RAPPEL
        ====================================================== --}}
        <div class="mt-4
                    px-4 py-3
                    rounded-xl
                    bg-blue-50
                    border border-blue-100">

            <p class="text-xs sm:text-sm text-blue-700">
                <span class="font-semibold">Astuce :</span>
                utilisez des noms de catégories courts et explicites
                pour faciliter la recherche des produits.
            </p>

        </div>

    </div>

</div>

@endsection


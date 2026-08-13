@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #clientEditPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    #clientEditPage input,
    #clientEditPage textarea,
    #clientEditPage button,
    #clientEditPage a {
        font-family: inherit;
    }
</style>


<div id="clientEditPage"
     class="container mx-auto px-3 sm:px-4 lg:px-6 py-6 sm:py-8">

    <div class="max-w-4xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="mb-6 sm:mb-8">

            <h1 class="text-xl sm:text-2xl lg:text-3xl
                       font-bold text-gray-800 tracking-tight">

                Modifier le Client

            </h1>

            <p class="text-sm sm:text-base text-gray-500 mt-1">
                Modifiez les informations du client puis enregistrez les changements.
            </p>

        </div>


        {{-- =====================================================
             ERREURS GÉNÉRALES
        ====================================================== --}}
        @if ($errors->any())

            <div class="mb-5
                        bg-red-50
                        border border-red-200
                        rounded-xl
                        p-4">

                <div class="flex items-start gap-3">

                    <div class="w-8 h-8
                                rounded-full
                                bg-red-100
                                flex items-center justify-center
                                shrink-0">

                        <span class="font-bold text-red-600">
                            !
                        </span>

                    </div>

                    <div>

                        <p class="text-sm font-semibold text-red-800 mb-1">
                            Veuillez corriger les erreurs suivantes :
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
        <form action="{{ route('clients.update', $client->id) }}"
              method="POST"
              class="bg-white
                     rounded-2xl
                     border-2 border-blue-500
                     shadow-lg
                     overflow-hidden">

            @csrf
            @method('PUT')


            {{-- =================================================
                 EN-TÊTE DU FORMULAIRE
            ================================================== --}}
            <div class="bg-blue-50
                        border-b border-blue-100
                        px-4 sm:px-6 lg:px-7
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
                                  d="M15 19a3 3 0 01-6 0"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 14a4 4 0 100-8 4 4 0 000 8z"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M19 21a7 7 0 00-14 0"/>

                        </svg>

                    </div>

                    <div>

                        <h2 class="text-base sm:text-lg
                                   font-semibold text-gray-800">

                            Informations du client

                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Mettez à jour les informations ci-dessous.
                        </p>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 CORPS DU FORMULAIRE
            ================================================== --}}
            <div class="p-4 sm:p-6 lg:p-7">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">


                    {{-- =================================================
                         NOM DU CLIENT
                    ================================================== --}}
                    <div>

                        <label for="nom_client"
                               class="block text-sm sm:text-base
                                      font-semibold text-gray-700 mb-2">

                            Nom du client

                            <span class="text-red-500">*</span>

                        </label>


                        <input type="text"
                               name="nom_client"
                               id="nom_client"
                               value="{{ old('nom_client', $client->nom_client) }}"
                               required
                               autocomplete="name"
                               placeholder="Ex : Amadou Bah"
                               class="block w-full
                                      min-h-[48px]
                                      border-2 border-blue-200
                                      rounded-xl
                                      px-4 py-3
                                      text-sm sm:text-base
                                      text-gray-800
                                      placeholder-gray-400
                                      bg-white
                                      shadow-sm
                                      outline-none
                                      transition duration-200
                                      focus:border-blue-600
                                      focus:ring-4
                                      focus:ring-blue-100
                                      @error('nom_client')
                                          border-red-400
                                          focus:border-red-500
                                          focus:ring-red-100
                                      @enderror">


                        @error('nom_client')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         CONTACT
                    ================================================== --}}
                    <div>

                        <label for="contact_client"
                               class="block text-sm sm:text-base
                                      font-semibold text-gray-700 mb-2">

                            Contact

                        </label>


                        <input type="text"
                               name="contact_client"
                               id="contact_client"
                               value="{{ old('contact_client', $client->contact_client) }}"
                               autocomplete="tel"
                               placeholder="Ex : 620 00 00 00"
                               class="block w-full
                                      min-h-[48px]
                                      border-2 border-blue-200
                                      rounded-xl
                                      px-4 py-3
                                      text-sm sm:text-base
                                      text-gray-800
                                      placeholder-gray-400
                                      bg-white
                                      shadow-sm
                                      outline-none
                                      transition duration-200
                                      focus:border-blue-600
                                      focus:ring-4
                                      focus:ring-blue-100
                                      @error('contact_client')
                                          border-red-400
                                          focus:border-red-500
                                          focus:ring-red-100
                                      @enderror">


                        @error('contact_client')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         ADRESSE
                    ================================================== --}}
                    <div class="md:col-span-2">

                        <label for="adresse_client"
                               class="block text-sm sm:text-base
                                      font-semibold text-gray-700 mb-2">

                            Adresse

                        </label>


                        <textarea name="adresse_client"
                                  id="adresse_client"
                                  rows="4"
                                  placeholder="Adresse du client..."
                                  class="block w-full
                                         border-2 border-blue-200
                                         rounded-xl
                                         px-4 py-3
                                         text-sm sm:text-base
                                         text-gray-800
                                         placeholder-gray-400
                                         bg-white
                                         shadow-sm
                                         outline-none
                                         resize-y
                                         transition duration-200
                                         focus:border-blue-600
                                         focus:ring-4
                                         focus:ring-blue-100
                                         @error('adresse_client')
                                             border-red-400
                                             focus:border-red-500
                                             focus:ring-red-100
                                         @enderror">{{ old('adresse_client', $client->adresse_client) }}</textarea>


                        @error('adresse_client')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                     BOUTONS
                ================================================== --}}
                <div class="flex flex-col-reverse sm:flex-row
                            gap-3
                            mt-7 pt-5
                            border-t border-gray-100">

                    {{-- ANNULER --}}
                    <a href="{{ route('clients.index') }}"
                       class="inline-flex items-center
                              justify-center
                              w-full sm:w-auto
                              min-h-[46px]
                              px-6 py-2.5
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


                    {{-- METTRE À JOUR --}}
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

                        Mettre à jour

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                    Ajouter un Fournisseur
                </h1>

                <p class="mt-1 text-sm sm:text-base text-gray-500">
                    Enregistrez les informations du nouveau fournisseur.
                </p>
            </div>

            <a href="{{ route('fournisseurs.index') }}"
               class="inline-flex items-center justify-center gap-2
                      w-full sm:w-auto
                      px-4 py-2.5
                      bg-gray-100 hover:bg-gray-200
                      text-gray-700 font-semibold
                      rounded-xl
                      transition duration-200">

                <i class="fas fa-arrow-left"></i>
                Retour
            </a>

        </div>
    </div>


    {{-- =========================================================
         MESSAGES D'ERREUR
    ========================================================== --}}
    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 sm:p-5">

            <div class="flex items-start gap-3">

                <div class="flex-shrink-0 mt-0.5">
                    <div class="w-9 h-9 rounded-full bg-red-100
                                flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                </div>

                <div class="min-w-0">
                    <h3 class="font-bold text-red-800 text-sm sm:text-base">
                        Vérifiez les informations saisies
                    </h3>

                    <ul class="mt-2 list-disc pl-5 space-y-1 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    @endif


    {{-- =========================================================
         FORMULAIRE
    ========================================================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- En-tête du formulaire --}}
        <div class="px-5 sm:px-6 lg:px-8 py-5 border-b border-gray-100 bg-gray-50">

            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-green-100
                            flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-truck text-green-600 text-lg"></i>
                </div>

                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800">
                        Informations du fournisseur
                    </h2>

                    <p class="text-sm text-gray-500 mt-0.5">
                        Renseignez les coordonnées du fournisseur.
                    </p>
                </div>

            </div>

        </div>


        <form action="{{ route('fournisseurs.store') }}"
              method="POST"
              class="p-5 sm:p-6 lg:p-8">

            @csrf


            {{-- =================================================
                 NOM
            ================================================== --}}
            <div class="mb-5">

                <label for="nom_fournisseur"
                       class="block text-sm font-semibold text-gray-700 mb-2">

                    Nom du fournisseur
                    <span class="text-red-500">*</span>

                </label>

                <div class="relative">

                    <div class="absolute inset-y-0 left-0 pl-3
                                flex items-center pointer-events-none">

                        <i class="fas fa-user text-gray-400"></i>

                    </div>

                    <input
                        type="text"
                        id="nom_fournisseur"
                        name="nom_fournisseur"
                        value="{{ old('nom_fournisseur') }}"
                        required
                        placeholder="Ex : Société ABC"
                        class="w-full
                               pl-10 pr-4 py-3
                               border border-gray-300
                               rounded-xl
                               text-sm sm:text-base
                               text-gray-800
                               placeholder-gray-400
                               focus:outline-none
                               focus:ring-2
                               focus:ring-green-500
                               focus:border-green-500
                               transition duration-200
                               @error('nom_fournisseur') border-red-500 @enderror">

                </div>

                @error('nom_fournisseur')
                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- =================================================
                 EMAIL + TELEPHONE
            ================================================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                {{-- EMAIL --}}
                <div>

                    <label for="email"
                           class="block text-sm font-semibold text-gray-700 mb-2">

                        Email

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3
                                    flex items-center pointer-events-none">

                            <i class="fas fa-envelope text-gray-400"></i>

                        </div>

                        <input
                            type="text"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="exemple@email.com"
                            class="w-full
                                   pl-10 pr-4 py-3
                                   border border-gray-300
                                   rounded-xl
                                   text-sm sm:text-base
                                   text-gray-800
                                   placeholder-gray-400
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-green-500
                                   focus:border-green-500
                                   transition duration-200">

                    </div>

                </div>


                {{-- TELEPHONE --}}
                <div>

                    <label for="contact_fournisseur"
                           class="block text-sm font-semibold text-gray-700 mb-2">

                        Téléphone

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3
                                    flex items-center pointer-events-none">

                            <i class="fas fa-phone text-gray-400"></i>

                        </div>

                        <input
                            type="text"
                            id="contact_fournisseur"
                            name="contact_fournisseur"
                            value="{{ old('contact_fournisseur') }}"
                            placeholder="Ex : 620 00 00 00"
                            class="w-full
                                   pl-10 pr-4 py-3
                                   border border-gray-300
                                   rounded-xl
                                   text-sm sm:text-base
                                   text-gray-800
                                   placeholder-gray-400
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-green-500
                                   focus:border-green-500
                                   transition duration-200">

                    </div>

                </div>

            </div>


            {{-- =================================================
                 ADRESSE
            ================================================== --}}
            <div class="mb-7">

                <label for="adresse"
                       class="block text-sm font-semibold text-gray-700 mb-2">

                    Adresse

                </label>

                <div class="relative">

                    <div class="absolute top-3 left-0 pl-3
                                flex items-center pointer-events-none">

                        <i class="fas fa-map-marker-alt text-gray-400"></i>

                    </div>

                    <input
                        type="text"
                        id="adresse"
                        name="adresse_fournisseur"
                        value="{{ old('adresse_fournisseur') }}"
                        placeholder="Ex : Conakry, Kaloum"
                        class="w-full
                               pl-10 pr-4 py-3
                               border border-gray-300
                               rounded-xl
                               text-sm sm:text-base
                               text-gray-800
                               placeholder-gray-400
                               focus:outline-none
                               focus:ring-2
                               focus:ring-green-500
                               focus:border-green-500
                               transition duration-200">

                </div>

            </div>


            {{-- =================================================
                 BOUTONS
            ================================================== --}}
            <div class="pt-5 border-t border-gray-100">

                <div class="flex flex-col-reverse sm:flex-row
                            sm:justify-end
                            gap-3">

                    <a href="{{ route('fournisseurs.index') }}"
                       class="w-full sm:w-auto
                              inline-flex items-center justify-center gap-2
                              px-5 py-3
                              bg-gray-100 hover:bg-gray-200
                              text-gray-700
                              font-semibold
                              rounded-xl
                              transition duration-200">

                        <i class="fas fa-times"></i>
                        Annuler

                    </a>


                    <button
                        type="submit"
                        class="w-full sm:w-auto
                               inline-flex items-center justify-center gap-2
                               px-5 py-3
                               bg-green-600 hover:bg-green-700
                               active:bg-green-800
                               text-white
                               font-semibold
                               rounded-xl
                               shadow-sm hover:shadow
                               transition duration-200">

                        <i class="fas fa-save"></i>
                        Enregistrer

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
@endsection
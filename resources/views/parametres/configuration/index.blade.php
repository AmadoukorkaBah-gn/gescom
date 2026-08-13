@extends('layouts.app')

@section('content')
<div class="w-full px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">

    <div class="max-w-5xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 tracking-tight">
                Configuration de l'entreprise
            </h1>

            <p class="mt-1 text-sm sm:text-base text-gray-500">
                Gérez les informations générales et le logo de votre entreprise.
            </p>
        </div>


        {{-- =====================================================
             MESSAGE SUCCÈS
        ====================================================== --}}
        @if(session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 shadow-sm">
                <div class="flex items-start gap-3">

                    <div class="flex-shrink-0 mt-0.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-green-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <p class="font-semibold text-green-800">
                            Opération réussie
                        </p>

                        <p class="mt-0.5 text-sm text-green-700">
                            {{ session('success') }}
                        </p>
                    </div>

                </div>
            </div>
        @endif


        {{-- =====================================================
             MESSAGES D'ERREURS
        ====================================================== --}}
        @if($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex-shrink-0 mt-0.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-red-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="min-w-0">
                        <p class="font-semibold text-red-800">
                            Veuillez corriger les erreurs suivantes :
                        </p>

                        <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endif


        {{-- =====================================================
             FORMULAIRE
        ====================================================== --}}
        <form method="POST"
              action="{{ route('configuration.update') }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')


            {{-- =================================================
                 INFORMATIONS ENTREPRISE
            ================================================== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                {{-- En-tête section --}}
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200 bg-gray-50">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-blue-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-2 0h-4m-4 0H5m4 0v-4h6v4M9 7h6M9 11h6"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-gray-800">
                                Informations de l'entreprise
                            </h2>

                            <p class="text-xs sm:text-sm text-gray-500">
                                Coordonnées et informations générales
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Contenu --}}
                <div class="p-4 sm:p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

                        {{-- Nom --}}
                        <div>
                            <label for="nom_entreprise"
                                   class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom de l'entreprise
                            </label>

                            <input
                                type="text"
                                name="nom_entreprise"
                                id="nom_entreprise"
                                value="{{ old('nom_entreprise', $config->nom_entreprise) }}"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm sm:text-base text-gray-800 shadow-sm transition
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                placeholder="Nom de votre entreprise"
                            >
                        </div>


                        {{-- Contact --}}
                        <div>
                            <label for="contact"
                                   class="block text-sm font-semibold text-gray-700 mb-2">
                                Contact / Téléphone
                            </label>

                            <input
                                type="text"
                                name="contact"
                                id="contact"
                                value="{{ old('contact', $config->contact) }}"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm sm:text-base text-gray-800 shadow-sm transition
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                placeholder="Ex : 620 00 00 00"
                            >
                        </div>


                        {{-- Email --}}
                        <div>
                            <label for="email_entreprise"
                                   class="block text-sm font-semibold text-gray-700 mb-2">
                                Adresse e-mail
                            </label>

                            <input
                                type="email"
                                name="email_entreprise"
                                id="email_entreprise"
                                value="{{ old('email_entreprise', $config->email_entreprise) }}"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm sm:text-base text-gray-800 shadow-sm transition
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                placeholder="exemple@entreprise.com"
                            >
                        </div>


                        {{-- Adresse --}}
                        <div>
                            <label for="adresse"
                                   class="block text-sm font-semibold text-gray-700 mb-2">
                                Adresse / Localisation
                            </label>

                            <input
                                type="text"
                                name="adresse"
                                id="adresse"
                                value="{{ old('adresse', $config->adresse) }}"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm sm:text-base text-gray-800 shadow-sm transition
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                placeholder="Adresse ou localisation"
                            >
                        </div>

                    </div>


                    {{-- =================================================
                         LOGO
                    ================================================== --}}
                    <div class="mt-7 pt-6 border-t border-gray-200">

                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700">
                                Logo de l'entreprise
                            </label>

                            <p class="mt-1 text-xs sm:text-sm text-gray-500">
                                Ajoutez le logo qui sera utilisé dans votre application.
                            </p>
                        </div>


                        <div class="flex flex-col sm:flex-row sm:items-center gap-5">

                            {{-- Logo actuel --}}
                            @if($config->logo && file_exists(public_path('storage/' . $config->logo)))

                                <div class="relative flex-shrink-0">

                                    <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-2xl border-2 border-gray-200 bg-gray-50 p-2 shadow-sm flex items-center justify-center">

                                        <img
                                            src="{{ asset('storage/' . $config->logo) }}"
                                            alt="Logo de l'entreprise"
                                            class="max-h-full max-w-full object-contain rounded-xl"
                                        >

                                    </div>


                                    {{-- Supprimer logo --}}
                                    <a href="#"
                                       class="absolute -top-2 -right-2 flex h-8 w-8 items-center justify-center rounded-full bg-red-500 text-white shadow-md transition hover:bg-red-600 hover:scale-105"
                                       onclick="event.preventDefault(); if(confirm('Supprimer le logo ?')) { document.getElementById('delete-logo-form').submit(); }"
                                       title="Supprimer le logo">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"/>
                                        </svg>

                                    </a>

                                </div>

                            @else

                                {{-- Aucun logo --}}
                                <div class="h-28 w-28 sm:h-32 sm:w-32 flex-shrink-0 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 flex flex-col items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-8 w-8 text-gray-400 mb-2"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>

                                    <span class="text-xs text-gray-500 text-center px-2">
                                        Aucun logo
                                    </span>

                                </div>

                            @endif


                            {{-- Upload --}}
                            <div class="flex-1 min-w-0">

                                <label for="logo"
                                       class="block text-sm font-medium text-gray-700 mb-2">
                                    Choisir un nouveau logo
                                </label>

                                <input
                                    type="file"
                                    name="logo"
                                    id="logo"
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-600
                                           file:mr-3
                                           file:rounded-lg
                                           file:border-0
                                           file:bg-blue-50
                                           file:px-4
                                           file:py-2
                                           file:text-sm
                                           file:font-semibold
                                           file:text-blue-700
                                           hover:file:bg-blue-100
                                           cursor-pointer"
                                >

                                <div class="mt-2 flex items-start gap-2 text-xs text-gray-500">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4 flex-shrink-0 mt-0.5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                                    </svg>

                                    <span>
                                        Formats acceptés : JPEG, PNG, GIF. Taille maximale : 2 Mo.
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 BOUTON ENREGISTRER
            ================================================== --}}
            <div class="mt-5 sm:mt-6 flex justify-stretch sm:justify-end">

                <button
                    type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 sm:px-6 py-3 text-sm sm:text-base font-semibold text-white shadow-sm transition
                           hover:bg-blue-700
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                           active:scale-[0.98]">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>

                    Enregistrer la configuration

                </button>

            </div>

        </form>

    </div>
</div>


{{-- =========================================================
     FORMULAIRE CACHÉ POUR SUPPRIMER LE LOGO
========================================================= --}}
<form
    id="delete-logo-form"
    method="POST"
    action="{{ route('configuration.delete-logo') }}"
    style="display: none;"
>
    @csrf
    @method('DELETE')
</form>

@endsection
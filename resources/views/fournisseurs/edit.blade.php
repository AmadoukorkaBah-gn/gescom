@extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- En-tête -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 flex-shrink-0">
                <i class="fas fa-truck text-lg sm:text-xl"></i>
            </div>

            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 tracking-tight">
                    Ajouter un Fournisseur
                </h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1">
                    Enregistrez les informations du nouveau fournisseur
                </p>
            </div>
        </div>
    </div>

    <!-- Erreurs -->
    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 text-red-600 mt-0.5">
                    <i class="fas fa-exclamation-circle"></i>
                </div>

                <div>
                    <h3 class="font-semibold text-red-800 mb-2">
                        Veuillez corriger les erreurs suivantes :
                    </h3>

                    <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulaire -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-5 sm:px-6 lg:px-8 py-5 border-b border-gray-100 bg-gray-50/70">
            <h2 class="text-base sm:text-lg font-bold text-gray-800">
                Informations du fournisseur
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Remplissez les informations ci-dessous.
            </p>
        </div>

        <form action="{{ route('fournisseurs.store') }}" method="POST"
              class="p-5 sm:p-6 lg:p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Nom -->
                <div class="md:col-span-2">
                    <label for="nom_fournisseur"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom du fournisseur
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>

                        <input
                            type="text"
                            id="nom_fournisseur"
                            name="nom_fournisseur"
                            value="{{ old('nom_fournisseur') }}"
                            required
                            placeholder="Ex : Société ABC"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300
                                   text-sm sm:text-base text-gray-800
                                   placeholder-gray-400
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                                   outline-none transition
                                   @error('nom_fournisseur') border-red-500 @enderror"
                        >
                    </div>

                    @error('nom_fournisseur')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="exemple@email.com"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300
                                   text-sm sm:text-base text-gray-800
                                   placeholder-gray-400
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                                   outline-none transition
                                   @error('email') border-red-500 @enderror"
                        >
                    </div>

                    @error('email')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="contact_fournisseur"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Téléphone
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                            <i class="fas fa-phone"></i>
                        </span>

                        <input
                            type="text"
                            id="contact_fournisseur"
                            name="contact_fournisseur"
                            value="{{ old('contact_fournisseur') }}"
                            placeholder="Ex : 622 00 00 00"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300
                                   text-sm sm:text-base text-gray-800
                                   placeholder-gray-400
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                                   outline-none transition
                                   @error('contact_fournisseur') border-red-500 @enderror"
                        >
                    </div>

                    @error('contact_fournisseur')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Adresse -->
                <div class="md:col-span-2">
                    <label for="adresse_fournisseur"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Adresse
                    </label>

                    <div class="relative">
                        <span class="absolute top-3.5 left-0 flex items-center pl-3.5 text-gray-400">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>

                        <textarea
                            id="adresse_fournisseur"
                            name="adresse_fournisseur"
                            rows="4"
                            placeholder="Adresse du fournisseur..."
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300
                                   text-sm sm:text-base text-gray-800
                                   placeholder-gray-400 resize-none
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                                   outline-none transition
                                   @error('adresse_fournisseur') border-red-500 @enderror"
                        >{{ old('adresse_fournisseur') }}</textarea>
                    </div>

                    @error('adresse_fournisseur')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <!-- Boutons -->
            <div class="mt-8 pt-6 border-t border-gray-100
                        flex flex-col-reverse sm:flex-row
                        sm:justify-end gap-3">

                <a href="{{ route('fournisseurs.index') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                          px-5 py-3 rounded-xl
                          bg-gray-100 hover:bg-gray-200
                          text-gray-700 font-semibold text-sm
                          transition">
                    <i class="fas fa-arrow-left"></i>
                    Annuler
                </a>

                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                               px-5 py-3 rounded-xl
                               bg-blue-600 hover:bg-blue-700
                               text-white font-semibold text-sm
                               shadow-sm hover:shadow
                               transition">
                    <i class="fas fa-save"></i>
                    Enregistrer
                </button>

            </div>

        </form>
    </div>
</div>
@endsection
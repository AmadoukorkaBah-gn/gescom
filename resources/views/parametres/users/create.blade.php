@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 px-3 py-4 sm:px-5 sm:py-6 lg:px-8">

    <div class="max-w-3xl mx-auto">

        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 tracking-tight">
                    Ajouter un utilisateur
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Créez un nouveau compte utilisateur et définissez son rôle.
                </p>
            </div>

            <a
                href="{{ route('users.index') }}"
                class="inline-flex items-center justify-center gap-2
                       w-full sm:w-auto
                       px-4 py-2.5
                       rounded-xl
                       bg-white
                       border border-gray-200
                       text-sm font-semibold text-gray-700
                       shadow-sm
                       hover:bg-gray-50
                       hover:border-gray-300
                       transition duration-200"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Retour à la liste
            </a>

        </div>


        {{-- =========================================================
             ERREURS
        ========================================================== --}}
        @if($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex-shrink-0">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-red-100">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-red-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v3.75m0 3.75h.007M12 3a9 9 0 100 18 9 9 0 000-18z"
                                />
                            </svg>
                        </div>
                    </div>

                    <div class="min-w-0">

                        <h3 class="text-sm font-bold text-red-800">
                            Vérifiez les informations saisies
                        </h3>

                        <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-red-700">
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
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            {{-- En-tête du formulaire --}}
            <div class="border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white px-4 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM3 20.25a6.75 6.75 0 0113.5 0"
                            />
                        </svg>

                    </div>

                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-800">
                            Informations du compte
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Renseignez les informations du nouvel utilisateur.
                        </p>
                    </div>

                </div>

            </div>


            <form method="POST" action="{{ route('users.store') }}" class="p-4 sm:p-6 lg:p-8">

                @csrf


                {{-- =====================================================
                     NOM
                ====================================================== --}}
                <div class="mb-5">

                    <label
                        for="name"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Nom complet
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        placeholder="Ex : Amadou Bah"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3
                               text-sm text-gray-800
                               placeholder-gray-400
                               shadow-sm
                               outline-none
                               transition
                               focus:border-blue-500
                               focus:ring-4 focus:ring-blue-100"
                    >

                    @error('name')
                        <p class="mt-1.5 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =====================================================
                     EMAIL
                ====================================================== --}}
                <div class="mb-5">

                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Adresse email
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="exemple@email.com"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3
                               text-sm text-gray-800
                               placeholder-gray-400
                               shadow-sm
                               outline-none
                               transition
                               focus:border-blue-500
                               focus:ring-4 focus:ring-blue-100"
                    >

                    @error('email')
                        <p class="mt-1.5 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =====================================================
                     RÔLE
                ====================================================== --}}
                <div class="mb-5">

                    <label
                        for="role"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Rôle
                    </label>

                    <select
                        name="role"
                        id="role"
                        required
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3
                               text-sm text-gray-800
                               shadow-sm
                               outline-none
                               transition
                               focus:border-blue-500
                               focus:ring-4 focus:ring-blue-100"
                    >

                        <option value="">
                            -- Sélectionner un rôle --
                        </option>

                        @if(auth()->user()->isSuperAdmin())

                            <option
                                value="admin"
                                {{ old('role') === 'admin' ? 'selected' : '' }}
                            >
                                Administrateur
                            </option>

                        @endif

                        <option
                            value="vendeur"
                            {{ old('role') === 'vendeur' ? 'selected' : '' }}
                        >
                            Vendeur
                        </option>

                        <option
                            value="gestionnaire"
                            {{ old('role') === 'gestionnaire' ? 'selected' : '' }}
                        >
                            Gestionnaire
                        </option>

                    </select>


                    {{-- Description des rôles --}}
                    <div class="mt-3 rounded-xl border border-gray-200 bg-gray-50 p-4">

                        <p class="mb-2 text-xs font-bold uppercase tracking-wide text-gray-500">
                            Permissions
                        </p>

                        <div class="space-y-2 text-xs sm:text-sm text-gray-600">

                            @if(auth()->user()->isSuperAdmin())

                                <div class="flex items-start gap-2">

                                    <span class="mt-0.5 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                        ✓
                                    </span>

                                    <span>
                                        <strong class="text-gray-800">
                                            Administrateur :
                                        </strong>
                                        Accès complet à toutes les fonctionnalités
                                    </span>

                                </div>

                            @endif


                            <div class="flex items-start gap-2">

                                <span class="mt-0.5 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600">
                                    ✓
                                </span>

                                <span>
                                    <strong class="text-gray-800">
                                        Vendeur :
                                    </strong>
                                    Accès aux ventes et clients uniquement
                                </span>

                            </div>


                            <div class="flex items-start gap-2">

                                <span class="mt-0.5 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-purple-100 text-purple-600">
                                    ✓
                                </span>

                                <span>
                                    <strong class="text-gray-800">
                                        Gestionnaire :
                                    </strong>
                                    Accès aux ventes, produits, achats, clients et rapports
                                </span>

                            </div>

                        </div>

                    </div>


                    @error('role')
                        <p class="mt-1.5 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =====================================================
                     MOT DE PASSE
                ====================================================== --}}
                <div class="mb-5">

                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Mot de passe
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3
                               text-sm text-gray-800
                               placeholder-gray-400
                               shadow-sm
                               outline-none
                               transition
                               focus:border-blue-500
                               focus:ring-4 focus:ring-blue-100"
                    >

                    @error('password')
                        <p class="mt-1.5 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =====================================================
                     CONFIRMATION MOT DE PASSE
                ====================================================== --}}
                <div class="mb-8">

                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Confirmer le mot de passe
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3
                               text-sm text-gray-800
                               placeholder-gray-400
                               shadow-sm
                               outline-none
                               transition
                               focus:border-blue-500
                               focus:ring-4 focus:ring-blue-100"
                    >

                </div>


                {{-- =====================================================
                     BOUTONS
                ====================================================== --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('users.index') }}"
                        class="inline-flex w-full items-center justify-center
                               rounded-xl border border-gray-300
                               bg-white px-5 py-3
                               text-sm font-semibold text-gray-700
                               shadow-sm
                               transition duration-200
                               hover:bg-gray-50
                               sm:w-auto"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2
                               rounded-xl
                               bg-blue-600
                               px-5 py-3
                               text-sm font-semibold text-white
                               shadow-sm
                               transition duration-200
                               hover:bg-blue-700
                               focus:outline-none
                               focus:ring-4
                               focus:ring-blue-200
                               sm:w-auto"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>

                        Créer l'utilisateur

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
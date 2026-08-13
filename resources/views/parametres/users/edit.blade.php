@extends('layouts.app')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <div class="max-w-2xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                    Modifier l'Utilisateur
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Modifiez les informations du compte utilisateur
                </p>
            </div>

            <a href="{{ route('users.index') }}"
               class="inline-flex items-center justify-center gap-2
                      w-full sm:w-auto
                      px-4 py-2.5
                      bg-gray-100 hover:bg-gray-200
                      text-gray-700 font-semibold
                      rounded-lg
                      transition duration-200
                      border border-gray-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>

                Retour à la liste
            </a>

        </div>


        {{-- =====================================================
             ERREURS
        ====================================================== --}}
        @if($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 sm:p-5">

                <div class="flex items-start gap-3">

                    <div class="flex-shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 text-red-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.53 20h14.94a2 2 0 001.74-3.14l-7.5-13a2 2 0 00-3.42 0z" />

                        </svg>
                    </div>

                    <div>
                        <h3 class="font-bold text-red-800 text-sm sm:text-base">
                            Impossible de mettre à jour l'utilisateur
                        </h3>

                        <ul class="list-disc list-inside mt-2 space-y-1 text-sm text-red-700">

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
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">

            {{-- En-tête du formulaire --}}
            <div class="px-5 sm:px-6 py-5 border-b border-gray-100 bg-gray-50">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 sm:w-11 sm:h-11
                                rounded-xl
                                bg-blue-100
                                text-blue-600
                                flex items-center justify-center
                                flex-shrink-0">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 sm:w-6 sm:h-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                        </svg>

                    </div>

                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-800">
                            Informations du compte
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Mettez à jour les informations de cet utilisateur.
                        </p>
                    </div>

                </div>

            </div>


            <form method="POST" action="{{ route('users.update', $user) }}">

                @csrf
                @method('PUT')


                <div class="p-5 sm:p-6 space-y-5">


                    {{-- =================================================
                         NOM
                    ================================================== --}}
                    <div>

                        <label for="name"
                               class="block text-sm font-semibold text-gray-700 mb-2">

                            Nom complet

                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            autocomplete="name"
                            class="w-full
                                   h-11 sm:h-12
                                   border border-gray-300
                                   rounded-xl
                                   px-4
                                   text-sm sm:text-base
                                   text-gray-800
                                   bg-white
                                   placeholder-gray-400
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100">

                    </div>


                    {{-- =================================================
                         EMAIL
                    ================================================== --}}
                    <div>

                        <label for="email"
                               class="block text-sm font-semibold text-gray-700 mb-2">

                            Email

                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            autocomplete="email"
                            class="w-full
                                   h-11 sm:h-12
                                   border border-gray-300
                                   rounded-xl
                                   px-4
                                   text-sm sm:text-base
                                   text-gray-800
                                   bg-white
                                   placeholder-gray-400
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100">

                    </div>


                    {{-- =================================================
                         RÔLE
                    ================================================== --}}
                    <div>

                        <label for="role"
                               class="block text-sm font-semibold text-gray-700 mb-2">

                            Rôle

                        </label>

                        <select
                            name="role"
                            id="role"
                            required
                            class="w-full
                                   h-11 sm:h-12
                                   border border-gray-300
                                   rounded-xl
                                   px-4
                                   text-sm sm:text-base
                                   text-gray-800
                                   bg-white
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100"
                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>

                            <option value="admin"
                                {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>

                            <option value="vendeur"
                                {{ old('role', $user->role) === 'vendeur' ? 'selected' : '' }}>
                                Vendeur
                            </option>

                            <option value="gestionnaire"
                                {{ old('role', $user->role) === 'gestionnaire' ? 'selected' : '' }}>
                                Gestionnaire
                            </option>

                        </select>


                        @if($user->id === auth()->id())

                            <input type="hidden"
                                   name="role"
                                   value="{{ $user->role }}">

                            <div class="flex items-start gap-2 mt-2">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-4 h-4 text-gray-500 flex-shrink-0 mt-0.5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-8h.01M12 22a10 10 0 110-20 10 10 0 010 20z" />

                                </svg>

                                <p class="text-xs sm:text-sm text-gray-500">
                                    Vous ne pouvez pas modifier votre propre rôle.
                                </p>

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                         NOUVEAU MOT DE PASSE
                    ================================================== --}}
                    <div>

                        <label for="password"
                               class="block text-sm font-semibold text-gray-700 mb-2">

                            Nouveau mot de passe

                        </label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="new-password"
                            class="w-full
                                   h-11 sm:h-12
                                   border border-gray-300
                                   rounded-xl
                                   px-4
                                   text-sm sm:text-base
                                   text-gray-800
                                   bg-white
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100">

                        <p class="text-xs sm:text-sm text-gray-500 mt-2">
                            Laissez ce champ vide pour conserver le mot de passe actuel.
                        </p>

                    </div>


                    {{-- =================================================
                         CONFIRMATION MOT DE PASSE
                    ================================================== --}}
                    <div>

                        <label for="password_confirmation"
                               class="block text-sm font-semibold text-gray-700 mb-2">

                            Confirmer le nouveau mot de passe

                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            autocomplete="new-password"
                            class="w-full
                                   h-11 sm:h-12
                                   border border-gray-300
                                   rounded-xl
                                   px-4
                                   text-sm sm:text-base
                                   text-gray-800
                                   bg-white
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100">

                    </div>

                </div>


                {{-- =====================================================
                     BOUTONS
                ====================================================== --}}
                <div class="px-5 sm:px-6 py-5
                            bg-gray-50
                            border-t border-gray-100">

                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                        <a href="{{ route('users.index') }}"
                           class="w-full sm:w-auto
                                  inline-flex items-center justify-center
                                  px-5 py-2.5
                                  border border-gray-300
                                  rounded-xl
                                  text-gray-700
                                  text-sm sm:text-base
                                  font-semibold
                                  bg-white
                                  hover:bg-gray-100
                                  transition duration-200">

                            Annuler

                        </a>

                        <button
                            type="submit"
                            class="w-full sm:w-auto
                                   inline-flex items-center justify-center gap-2
                                   px-5 py-2.5
                                   bg-blue-600
                                   hover:bg-blue-700
                                   text-white
                                   rounded-xl
                                   text-sm sm:text-base
                                   font-semibold
                                   shadow-sm
                                   hover:shadow-md
                                   transition duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7" />

                            </svg>

                            Mettre à jour

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection
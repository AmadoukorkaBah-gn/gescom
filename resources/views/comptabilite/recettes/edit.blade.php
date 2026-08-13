@extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto px-3 sm:px-5 lg:px-8 py-5 sm:py-8">

    <!-- En-tête -->
    <div class="mb-6">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-blue-100 border border-blue-200">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-blue-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">
                    Modifier la Recette
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Modifiez les informations de cette recette
                </p>
            </div>
        </div>
    </div>


    <!-- Formulaire -->
    <div class="bg-white rounded-2xl shadow-lg border border-blue-200 overflow-hidden">

        <!-- Barre supérieure bleue -->
        <div class="h-1.5 bg-blue-600"></div>

        <form action="{{ route('recettes.update', $recette->id) }}"
              method="POST"
              class="p-4 sm:p-6 lg:p-8">

            @csrf
            @method('PUT')


            <!-- Libellé -->
            <div class="mb-5">
                <label for="libelle"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Libellé
                </label>

                <input
                    type="text"
                    name="libelle"
                    id="libelle"
                    value="{{ old('libelle', $recette->libelle) }}"
                    class="w-full px-4 py-3 rounded-xl
                           border-2 border-blue-200
                           bg-white text-gray-800
                           placeholder-gray-400
                           shadow-sm
                           focus:outline-none
                           focus:border-blue-500
                           focus:ring-4 focus:ring-blue-100
                           transition duration-200
                           @error('libelle') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                    required
                >

                @error('libelle')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <!-- Montant -->
            <div class="mb-5">
                <label for="montant"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Montant (GNF)
                </label>

                <div class="relative">
                    <input
                        type="number"
                        name="montant"
                        id="montant"
                        step="0.01"
                        min="0.01"
                        value="{{ old('montant', $recette->montant) }}"
                        class="w-full px-4 py-3 rounded-xl
                               border-2 border-blue-200
                               bg-white text-gray-800
                               shadow-sm
                               focus:outline-none
                               focus:border-blue-500
                               focus:ring-4 focus:ring-blue-100
                               transition duration-200
                               @error('montant') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                        required
                    >
                </div>

                @error('montant')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <!-- Date -->
            <div class="mb-5">
                <label for="date_recette"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Date
                </label>

                <input
                    type="date"
                    name="date_recette"
                    id="date_recette"
                    value="{{ old('date_recette', $recette->date_recette->format('Y-m-d')) }}"
                    class="w-full px-4 py-3 rounded-xl
                           border-2 border-blue-200
                           bg-white text-gray-800
                           shadow-sm
                           focus:outline-none
                           focus:border-blue-500
                           focus:ring-4 focus:ring-blue-100
                           transition duration-200
                           @error('date_recette') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                    required
                >

                @error('date_recette')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <!-- Caisse -->
            <div class="mb-7">
                <label for="caisse_id"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Caisse
                </label>

                <select
                    name="caisse_id"
                    id="caisse_id"
                    class="w-full px-4 py-3 rounded-xl
                           border-2 border-blue-200
                           bg-white text-gray-800
                           shadow-sm
                           focus:outline-none
                           focus:border-blue-500
                           focus:ring-4 focus:ring-blue-100
                           transition duration-200
                           @error('caisse_id') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                    required
                >

                    @foreach($caisses as $caisse)

                        <option
                            value="{{ $caisse->id }}"
                            {{ old('caisse_id', $recette->caisse_id) == $caisse->id ? 'selected' : '' }}
                        >
                            {{ $caisse->nom }}
                            ({{ number_format($caisse->solde, 2) }} GNF)
                        </option>

                    @endforeach

                </select>

                @error('caisse_id')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <!-- Boutons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">

                <a
                    href="{{ route('recettes.index') }}"
                    class="w-full sm:w-auto
                           inline-flex items-center justify-center
                           gap-2
                           px-5 py-3
                           rounded-xl
                           border-2 border-gray-300
                           bg-white
                           text-gray-700
                           font-semibold
                           hover:bg-gray-50
                           hover:border-gray-400
                           transition duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>

                    Annuler
                </a>


                <button
                    type="submit"
                    class="w-full sm:w-auto
                           inline-flex items-center justify-center
                           gap-2
                           px-6 py-3
                           rounded-xl
                           bg-blue-600
                           hover:bg-blue-700
                           text-white
                           font-semibold
                           shadow-md
                           hover:shadow-lg
                           focus:outline-none
                           focus:ring-4 focus:ring-blue-200
                           transition duration-200"
                >
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

        </form>
    </div>

</div>
@endsection
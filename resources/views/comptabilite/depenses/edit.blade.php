@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-3 sm:px-5 lg:px-8 py-5 sm:py-8">

    <div class="max-w-2xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>
                    <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">
                        Gestion financière
                    </p>

                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">
                        Modifier la dépense
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Modifiez les informations de cette dépense.
                    </p>
                </div>

                <a href="{{ route('depenses.index') }}"
                   class="inline-flex items-center justify-center gap-2
                          px-4 py-2.5
                          bg-white text-gray-700
                          border border-blue-200
                          rounded-xl
                          font-semibold text-sm
                          shadow-sm
                          hover:bg-blue-50 hover:border-blue-400
                          transition duration-200">

                    <i class="fas fa-arrow-left"></i>
                    Retour
                </a>

            </div>
        </div>


        {{-- =====================================================
             MESSAGE D'ERREUR
        ====================================================== --}}
        @if(session('error'))
            <div class="mb-5 flex items-start gap-3
                        bg-red-50
                        border border-red-200
                        text-red-700
                        rounded-xl
                        p-4 shadow-sm">

                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                </div>

                <div>
                    <p class="font-semibold text-sm">
                        Une erreur est survenue
                    </p>

                    <p class="text-sm mt-1">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        @endif


        {{-- =====================================================
             FORMULAIRE
        ====================================================== --}}
        <form action="{{ route('depenses.update', $depense->id) }}"
              method="POST"
              class="bg-white rounded-2xl shadow-sm
                     border border-blue-100
                     overflow-hidden">

            @csrf
            @method('PUT')


            {{-- En-tête du formulaire --}}
            <div class="px-5 sm:px-7 py-5
                        border-b border-blue-100
                        bg-gradient-to-r from-blue-50 to-white">

                <div class="flex items-center gap-3">

                    <div class="w-11 h-11
                                rounded-xl
                                bg-blue-600
                                text-white
                                flex items-center justify-center
                                shadow-md">

                        <i class="fas fa-edit text-lg"></i>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Informations de la dépense
                        </h2>

                        <p class="text-sm text-gray-500">
                            Vérifiez les informations avant de mettre à jour.
                        </p>
                    </div>

                </div>
            </div>


            {{-- Corps --}}
            <div class="p-5 sm:p-7 space-y-5">


                {{-- =================================================
                     LIBELLÉ
                ================================================== --}}
                <div>
                    <label for="libelle"
                           class="block text-sm font-semibold text-gray-700 mb-2">

                        Libellé

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3
                                    flex items-center pointer-events-none">

                            <i class="fas fa-file-invoice text-blue-400"></i>

                        </div>

                        <input
                            type="text"
                            name="libelle"
                            id="libelle"
                            value="{{ old('libelle', $depense->libelle) }}"
                            class="w-full
                                   pl-10 pr-4 py-3
                                   bg-white
                                   border-2
                                   rounded-xl
                                   text-gray-800
                                   placeholder-gray-400
                                   outline-none
                                   transition duration-200

                                   @error('libelle')
                                       border-red-400
                                       focus:border-red-500
                                   @else
                                       border-blue-100
                                       focus:border-blue-500
                                   @enderror"
                            placeholder="Ex : Loyer, Électricité, Salaires..."
                            required
                        >

                    </div>

                    @error('libelle')
                        <p class="flex items-center gap-1 text-red-500 text-sm mt-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- =================================================
                     MONTANT
                ================================================== --}}
                <div>
                    <label for="montant"
                           class="block text-sm font-semibold text-gray-700 mb-2">

                        Montant (GNF)

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3
                                    flex items-center pointer-events-none">

                            <i class="fas fa-money-bill-wave text-blue-400"></i>

                        </div>

                        <input
                            type="number"
                            name="montant"
                            id="montant"
                            step="0.01"
                            min="0.01"
                            value="{{ old('montant', $depense->montant) }}"
                            class="w-full
                                   pl-10 pr-16 py-3
                                   bg-white
                                   border-2
                                   rounded-xl
                                   text-gray-800
                                   font-semibold
                                   outline-none
                                   transition duration-200

                                   @error('montant')
                                       border-red-400
                                       focus:border-red-500
                                   @else
                                       border-blue-100
                                       focus:border-blue-500
                                   @enderror"
                            placeholder="0.00"
                            required
                        >

                        <span class="absolute inset-y-0 right-0 pr-4
                                     flex items-center
                                     text-xs font-bold text-gray-400">
                            GNF
                        </span>

                    </div>

                    @error('montant')
                        <p class="flex items-center gap-1 text-red-500 text-sm mt-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- =================================================
                     DATE
                ================================================== --}}
                <div>
                    <label for="date_depense"
                           class="block text-sm font-semibold text-gray-700 mb-2">

                        Date

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3
                                    flex items-center pointer-events-none">

                            <i class="fas fa-calendar-alt text-blue-400"></i>

                        </div>

                        <input
                            type="date"
                            name="date_depense"
                            id="date_depense"
                            value="{{ old('date_depense', $depense->date_depense->format('Y-m-d')) }}"
                            class="w-full
                                   pl-10 pr-4 py-3
                                   bg-white
                                   border-2
                                   rounded-xl
                                   text-gray-800
                                   outline-none
                                   transition duration-200

                                   @error('date_depense')
                                       border-red-400
                                       focus:border-red-500
                                   @else
                                       border-blue-100
                                       focus:border-blue-500
                                   @enderror"
                            required
                        >

                    </div>

                    @error('date_depense')
                        <p class="flex items-center gap-1 text-red-500 text-sm mt-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- =================================================
                     CAISSE
                ================================================== --}}
                <div>
                    <label for="caisse_id"
                           class="block text-sm font-semibold text-gray-700 mb-2">

                        Caisse

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3
                                    flex items-center pointer-events-none
                                    z-10">

                            <i class="fas fa-wallet text-blue-400"></i>

                        </div>

                        <select
                            name="caisse_id"
                            id="caisse_id"
                            class="w-full
                                   pl-10 pr-4 py-3
                                   bg-white
                                   border-2
                                   rounded-xl
                                   text-gray-800
                                   outline-none
                                   transition duration-200

                                   @error('caisse_id')
                                       border-red-400
                                       focus:border-red-500
                                   @else
                                       border-blue-100
                                       focus:border-blue-500
                                   @enderror"
                            required
                        >

                            @foreach($caisses as $caisse)

                                <option
                                    value="{{ $caisse->id }}"
                                    {{ old('caisse_id', $depense->caisse_id) == $caisse->id ? 'selected' : '' }}
                                >

                                    {{ $caisse->nom }}
                                    ({{ number_format($caisse->solde, 2) }} GNF)

                                </option>

                            @endforeach

                        </select>

                    </div>

                    @error('caisse_id')
                        <p class="flex items-center gap-1 text-red-500 text-sm mt-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>


            </div>


            {{-- =====================================================
                 FOOTER / BOUTONS
            ====================================================== --}}
            <div class="px-5 sm:px-7 py-5
                        bg-gray-50
                        border-t border-blue-100">

                <div class="flex flex-col-reverse sm:flex-row
                            sm:justify-end
                            gap-3">

                    <a href="{{ route('depenses.index') }}"
                       class="w-full sm:w-auto
                              inline-flex items-center justify-center gap-2
                              px-5 py-3
                              bg-white
                              text-gray-700
                              border-2 border-gray-200
                              rounded-xl
                              font-semibold
                              hover:bg-gray-100
                              transition duration-200">

                        <i class="fas fa-times"></i>
                        Annuler

                    </a>


                    <button
                        type="submit"
                        class="w-full sm:w-auto
                               inline-flex items-center justify-center gap-2
                               px-5 py-3
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               rounded-xl
                               font-semibold
                               shadow-md
                               hover:shadow-lg
                               transition duration-200">

                        <i class="fas fa-save"></i>
                        Mettre à jour

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
@endsection
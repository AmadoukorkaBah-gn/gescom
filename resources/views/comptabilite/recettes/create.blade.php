@extends('layouts.app')

@section('content')
<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-8">

    <!-- =========================================================
         EN-TÊTE
    ========================================================== -->
    <div class="max-w-3xl mx-auto mb-6">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-blue-600 flex items-center justify-center shadow-md flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 sm:w-7 sm:h-7 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 6v12m6-6H6"/>
                </svg>
            </div>

            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">
                    Nouvelle Recette
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Enregistrer une nouvelle recette
                </p>
            </div>
        </div>
    </div>


    <!-- =========================================================
         CONTENU
    ========================================================== -->
    <div class="max-w-3xl mx-auto">

        <!-- MESSAGE D'ERREUR -->
        @if(session('error'))
            <div class="mb-5 p-4 rounded-xl border border-red-200 bg-red-50 text-red-700 shadow-sm">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 mt-0.5 flex-shrink-0"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14A2 2 0 003.82 21h16.36a2 2 0 001.71-3.14l-8.18-14a2 2 0 00-3.42 0z"/>
                    </svg>

                    <span class="text-sm font-medium">
                        {{ session('error') }}
                    </span>
                </div>
            </div>
        @endif


        <!-- =====================================================
             FORMULAIRE
        ====================================================== -->
        <form action="{{ route('recettes.store') }}"
              method="POST"
              class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">

            @csrf

            <!-- Barre supérieure bleue -->
            <div class="h-1.5 bg-blue-600"></div>

            <div class="p-4 sm:p-6 lg:p-8">


                <!-- =================================================
                     INFORMATIONS VENTE
                ================================================== -->
                @if(isset($vente))

                    <input type="hidden" name="vente_id" value="{{ $vente->id }}">

                    <div class="mb-6 rounded-xl border-2 border-blue-200 bg-blue-50/60 overflow-hidden">

                        <div class="px-4 py-3 bg-blue-100 border-b border-blue-200">
                            <div class="flex items-center gap-2">

                                <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-5 h-5 text-white"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 14l6-6m2-5h2a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h2"/>
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="font-bold text-blue-900">
                                        Paiement pour la vente N°{{ $vente->id }}
                                    </h3>

                                    <p class="text-xs text-blue-700">
                                        Informations sur la vente
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">

                                <div class="font-semibold text-gray-600">
                                    Client
                                </div>

                                <div class="font-bold text-gray-900 sm:text-right">
                                    {{ $vente->client->nom_client ?? '-' }}
                                </div>


                                <div class="font-semibold text-gray-600">
                                    Total vente
                                </div>

                                <div class="font-bold text-gray-900 sm:text-right">
                                    {{ number_format($vente->montant_total, 2) }} GNF
                                </div>


                                <div class="font-semibold text-gray-600">
                                    Déjà payé
                                </div>

                                <div class="font-bold text-green-600 sm:text-right">
                                    {{ number_format($vente->paiements->sum('montant_paye'), 2) }} GNF
                                </div>


                                <div class="font-semibold text-gray-600">
                                    Reste à payer
                                </div>

                                <div class="font-bold text-red-600 sm:text-right">
                                    {{ number_format($vente->montant_total - $vente->paiements->sum('montant_paye'), 2) }} GNF
                                </div>

                            </div>
                        </div>

                    </div>

                @endif


                <!-- =================================================
                     LIBELLÉ
                ================================================== -->
                <div class="mb-5">

                    <label for="libelle"
                           class="block text-sm font-bold text-gray-700 mb-2">
                        Libellé
                    </label>

                    <input
                        type="text"
                        name="libelle"
                        id="libelle"
                        value="{{ old('libelle', isset($vente) ? 'Paiement vente #' . $vente->id : '') }}"
                        class="w-full rounded-xl border-2 border-blue-200 bg-white px-4 py-3 text-gray-800 text-sm sm:text-base outline-none transition duration-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-100 hover:border-blue-400 @error('libelle') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                        placeholder="Ex : Vente au comptant, Remboursement..."
                        required
                    >

                    @error('libelle')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- =================================================
                     MONTANT
                ================================================== -->
                <div class="mb-5">

                    <label for="montant"
                           class="block text-sm font-bold text-gray-700 mb-2">
                        Montant (GNF)
                    </label>

                    <div class="relative">

                        <input
                            type="number"
                            name="montant"
                            id="montant"
                            step="0.01"
                            min="0.01"
                            value="{{ old('montant', isset($vente) ? $vente->montant_total - $vente->paiements->sum('montant_paye') : '') }}"
                            class="w-full rounded-xl border-2 border-blue-200 bg-white px-4 py-3 pr-16 text-gray-800 text-sm sm:text-base font-semibold outline-none transition duration-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-100 hover:border-blue-400 @error('montant') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                            required
                        >

                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs sm:text-sm font-bold text-blue-600">
                            GNF
                        </span>

                    </div>

                    @error('montant')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- =================================================
                     MODE DE PAIEMENT
                ================================================== -->
                @if(isset($vente))

                    <div class="mb-5">

                        <label for="mode"
                               class="block text-sm font-bold text-gray-700 mb-2">
                            Mode de paiement
                        </label>

                        <select
                            name="mode"
                            id="mode"
                            class="w-full rounded-xl border-2 border-blue-200 bg-white px-4 py-3 text-gray-800 text-sm sm:text-base outline-none transition duration-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-100 hover:border-blue-400"
                            required
                        >
                            <option value="especes">Espèces</option>
                            <option value="mobile_money">Mobile Money</option>
                            <option value="cheque">Chèque</option>
                            <option value="virement">Virement</option>
                            <option value="autre">Autre</option>
                        </select>

                    </div>

                @endif


                <!-- =================================================
                     DATE
                ================================================== -->
                <div class="mb-5">

                    <label for="date_recette"
                           class="block text-sm font-bold text-gray-700 mb-2">
                        Date
                    </label>

                    <input
                        type="date"
                        name="date_recette"
                        id="date_recette"
                        value="{{ old('date_recette', now()->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-xl border-2 border-blue-200 bg-white px-4 py-3 text-gray-800 text-sm sm:text-base outline-none transition duration-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-100 hover:border-blue-400 @error('date_recette') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                        required
                    >

                    @error('date_recette')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- =================================================
                     CAISSE
                ================================================== -->
                <div class="mb-7">

                    <label for="caisse_id"
                           class="block text-sm font-bold text-gray-700 mb-2">
                        Caisse
                    </label>

                    <select
                        name="caisse_id"
                        id="caisse_id"
                        class="w-full rounded-xl border-2 border-blue-200 bg-white px-4 py-3 text-gray-800 text-sm sm:text-base outline-none transition duration-200 focus:border-blue-600 focus:ring-4 focus:ring-blue-100 hover:border-blue-400 @error('caisse_id') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                        required
                    >

                        <option value="">
                            -- Sélectionner une caisse --
                        </option>

                        @foreach($caisses as $caisse)

                            <option
                                value="{{ $caisse->id }}"
                                {{ old('caisse_id') == $caisse->id ? 'selected' : '' }}
                            >
                                {{ $caisse->nom }} ({{ number_format($caisse->solde, 2) }} GNF)
                            </option>

                        @endforeach

                    </select>

                    @error('caisse_id')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- =================================================
                     BOUTONS
                ================================================== -->
                <div class="pt-5 border-t border-blue-100">

                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                        <a
                            href="{{ route('recettes.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-700 font-semibold text-sm hover:bg-gray-50 hover:border-gray-300 transition duration-200"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>

                            Annuler
                        </a>


                        <button
                            type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md hover:shadow-lg transition duration-200"
                        >

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>

                            Enregistrer la recette

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
@endsection
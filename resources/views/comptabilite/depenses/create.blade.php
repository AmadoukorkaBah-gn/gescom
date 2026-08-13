@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #depensePage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    #depensePage input,
    #depensePage select,
    #depensePage textarea,
    #depensePage button,
    #depensePage a {
        font-family: inherit;
    }
</style>

<div id="depensePage" class="min-h-screen bg-gray-50">

    <div class="container mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-8">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="max-w-3xl mx-auto mb-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <p class="text-sm font-semibold text-blue-600 mb-1">
                        Gestion financière
                    </p>

                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 tracking-tight">
                        Nouvelle Dépense
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Enregistrez une nouvelle dépense dans votre caisse.
                    </p>
                </div>

            </div>

        </div>


        {{-- =====================================================
             MESSAGE D'ERREUR
        ====================================================== --}}
        @if(session('error'))
            <div class="max-w-3xl mx-auto mb-5">

                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 shadow-sm">

                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600">
                            !
                        </span>
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

            </div>
        @endif


        {{-- =====================================================
             FORMULAIRE
        ====================================================== --}}
        <div class="max-w-3xl mx-auto">

            <form
                action="{{ route('depenses.store') }}"
                method="POST"
                class="bg-white border border-blue-100 shadow-lg shadow-blue-100/40 rounded-2xl overflow-hidden"
            >

                @csrf


                {{-- =================================================
                     EN-TÊTE DU FORMULAIRE
                ================================================== --}}
                <div class="px-4 sm:px-6 lg:px-8 py-5 border-b border-blue-100 bg-blue-50/40">

                    <div class="flex items-center gap-3">

                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M17 9V7a5 5 0 00-10 0v2m-2 0h14l1 11H4L5 9z"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-gray-800">
                                Informations de la dépense
                            </h2>

                            <p class="text-xs sm:text-sm text-gray-500">
                                Remplissez les informations ci-dessous.
                            </p>
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     CONTENU
                ================================================== --}}
                <div class="p-4 sm:p-6 lg:p-8">


                    {{-- =================================================
                         INFORMATIONS ACHAT
                    ================================================== --}}
                    @if(isset($achat))

                        <input type="hidden" name="achat_id" value="{{ $achat->id }}">

                        <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50/60 overflow-hidden">

                            <div class="px-4 py-3 border-b border-blue-200">

                                <h3 class="font-bold text-gray-800 text-sm sm:text-base">
                                    Paiement pour l'achat N°{{ $achat->id }}
                                </h3>

                            </div>

                            <div class="p-4">

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                                    <div>
                                        <p class="text-gray-500 text-xs mb-1">
                                            Fournisseur
                                        </p>

                                        <p class="font-semibold text-gray-800 break-words">
                                            {{ $achat->fournisseur->nom_fournisseur ?? '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-gray-500 text-xs mb-1">
                                            Total achat
                                        </p>

                                        <p class="font-semibold text-gray-800">
                                            {{ number_format($achat->total, 2) }} GNF
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-gray-500 text-xs mb-1">
                                            Déjà payé
                                        </p>

                                        <p class="font-semibold text-green-600">
                                            {{ number_format($achat->montant_paye, 2) }} GNF
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-gray-500 text-xs mb-1">
                                            Reste à payer
                                        </p>

                                        <p class="font-bold text-red-600">
                                            {{ number_format($achat->reste_a_payer, 2) }} GNF
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                         LIBELLÉ
                    ================================================== --}}
                    <div class="mb-5">

                        <label
                            for="libelle"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Libellé
                        </label>

                        <input
                            type="text"
                            name="libelle"
                            id="libelle"
                            value="{{ old('libelle', isset($achat) ? 'Paiement achat #' . $achat->id : '') }}"
                            class="w-full min-h-[46px] border-2 border-blue-100 rounded-xl px-4 py-2.5 text-sm sm:text-base text-gray-800 bg-white outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('libelle') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                            placeholder="Ex : Loyer, Électricité, Salaires..."
                            required
                        >

                        @error('libelle')
                            <p class="text-red-500 text-xs sm:text-sm mt-1.5">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- =================================================
                         MONTANT
                    ================================================== --}}
                    <div class="mb-5">

                        <label
                            for="montant"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Montant (GNF)
                        </label>

                        <div class="relative">

                            <input
                                type="number"
                                name="montant"
                                id="montant"
                                step="0.01"
                                min="0.01"
                                value="{{ old('montant', isset($achat) ? $achat->reste_a_payer : '') }}"
                                class="w-full min-h-[46px] border-2 border-blue-100 rounded-xl px-4 py-2.5 pr-16 text-sm sm:text-base text-gray-800 bg-white outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('montant') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                                placeholder="0.00"
                                required
                            >

                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs sm:text-sm font-semibold text-gray-400">
                                GNF
                            </span>

                        </div>

                        @error('montant')
                            <p class="text-red-500 text-xs sm:text-sm mt-1.5">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- =================================================
                         MODE DE PAIEMENT
                    ================================================== --}}
                    @if(isset($achat))

                        <div class="mb-5">

                            <label
                                for="mode"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Mode de paiement
                            </label>

                            <select
                                name="mode"
                                id="mode"
                                class="w-full min-h-[46px] border-2 border-blue-100 rounded-xl px-4 py-2.5 text-sm sm:text-base text-gray-800 bg-white outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                required
                            >
                                <option value="especes">
                                    Espèces
                                </option>

                                <option value="mobile_money">
                                    Mobile Money
                                </option>

                                <option value="cheque">
                                    Chèque
                                </option>

                                <option value="virement">
                                    Virement
                                </option>

                                <option value="autre">
                                    Autre
                                </option>
                            </select>

                        </div>


                        {{-- =================================================
                             NOTE
                        ================================================== --}}
                        <div class="mb-5">

                            <label
                                for="note"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Note
                                <span class="text-gray-400 font-normal">
                                    (optionnel)
                                </span>
                            </label>

                            <textarea
                                name="note"
                                id="note"
                                rows="3"
                                class="w-full border-2 border-blue-100 rounded-xl px-4 py-3 text-sm sm:text-base text-gray-800 bg-white outline-none transition resize-y focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                placeholder="Ajouter une remarque concernant cette dépense..."
                            >{{ old('note') }}</textarea>

                        </div>

                    @endif


                    {{-- =================================================
                         DATE
                    ================================================== --}}
                    <div class="mb-5">

                        <label
                            for="date_depense"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Date
                        </label>

                        <input
                            type="date"
                            name="date_depense"
                            id="date_depense"
                            value="{{ old('date_depense', now()->format('Y-m-d\TH:i')) }}"
                            class="w-full min-h-[46px] border-2 border-blue-100 rounded-xl px-4 py-2.5 text-sm sm:text-base text-gray-800 bg-white outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('date_depense') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                            required
                        >

                        @error('date_depense')
                            <p class="text-red-500 text-xs sm:text-sm mt-1.5">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- =================================================
                         CAISSE
                    ================================================== --}}
                    <div class="mb-2">

                        <label
                            for="caisse_id"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Caisse
                        </label>

                        <select
                            name="caisse_id"
                            id="caisse_id"
                            class="w-full min-h-[46px] border-2 border-blue-100 rounded-xl px-4 py-2.5 text-sm sm:text-base text-gray-800 bg-white outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('caisse_id') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
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
                                    {{ $caisse->nom }}
                                    ({{ number_format($caisse->solde, 2) }} GNF)
                                </option>

                            @endforeach

                        </select>

                        @error('caisse_id')
                            <p class="text-red-500 text-xs sm:text-sm mt-1.5">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- =================================================
                         ACTIONS
                    ================================================== --}}
                    <div class="mt-7 pt-5 border-t border-blue-100">

                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                            <a
                                href="{{ route('depenses.index') }}"
                                class="w-full sm:w-auto inline-flex justify-center items-center min-h-[46px] px-5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-700 font-semibold text-sm hover:bg-gray-50 hover:border-gray-300 transition"
                            >
                                Annuler
                            </a>

                            <button
                                type="submit"
                                class="w-full sm:w-auto inline-flex justify-center items-center min-h-[46px] px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-200 transition"
                            >
                                Enregistrer la dépense
                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
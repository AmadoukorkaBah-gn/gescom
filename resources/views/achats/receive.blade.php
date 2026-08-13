
@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #receptionAchatPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system,
                     BlinkMacSystemFont, "Segoe UI", sans-serif;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }

    #receptionAchatPage input,
    #receptionAchatPage select,
    #receptionAchatPage button {
        font-family: inherit;
    }
</style>


<div id="receptionAchatPage"
     class="container mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-8">

    <div class="max-w-3xl mx-auto">

        {{-- =====================================================
             TITRE
        ====================================================== --}}
        <div class="mb-5 sm:mb-6">

            <h1 class="text-xl sm:text-2xl lg:text-3xl
                       font-bold text-gray-800 tracking-tight">
                Réception de l'Achat #{{ $achat->id }}
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Vérifiez les informations avant de confirmer la réception.
            </p>

        </div>


        {{-- =====================================================
             MESSAGE D'ERREUR
        ====================================================== --}}
        @if(session('error'))

            <div class="bg-red-50 border border-red-200
                        text-red-800
                        px-4 py-3
                        rounded-lg
                        mb-5
                        text-sm">

                {{ session('error') }}

            </div>

        @endif


        {{-- =====================================================
             RÉCAPITULATIF DE L'ACHAT
        ====================================================== --}}
        <div class="bg-white
                    shadow-sm sm:shadow-md
                    rounded-xl
                    border border-gray-100
                    p-4 sm:p-6
                    mb-5 sm:mb-6">

            <div class="mb-5">

                <h2 class="text-base sm:text-lg
                           font-semibold text-gray-800">
                    Récapitulatif
                </h2>

            </div>


            {{-- Informations générales --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-5">

                {{-- Fournisseur --}}
                <div class="bg-gray-50 rounded-lg p-3 sm:p-4">

                    <p class="text-xs sm:text-sm text-gray-500 mb-1">
                        Fournisseur
                    </p>

                    <p class="text-sm sm:text-base
                              font-semibold text-gray-800
                              break-words">
                        {{ $achat->fournisseur->nom_fournisseur }}
                    </p>

                </div>


                {{-- Date --}}
                <div class="bg-gray-50 rounded-lg p-3 sm:p-4">

                    <p class="text-xs sm:text-sm text-gray-500 mb-1">
                        Date d'achat
                    </p>

                    <p class="text-sm sm:text-base
                              font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($achat->date_achat)->format('d/m/Y') }}
                    </p>

                </div>


                {{-- Facture --}}
                <div class="bg-gray-50 rounded-lg p-3 sm:p-4">

                    <p class="text-xs sm:text-sm text-gray-500 mb-1">
                        N° Facture
                    </p>

                    <p class="text-sm sm:text-base
                              font-semibold text-gray-800
                              break-words">
                        {{ $achat->numero_facture ?? '-' }}
                    </p>

                </div>


                {{-- Total --}}
                <div class="bg-red-50 rounded-lg p-3 sm:p-4">

                    <p class="text-xs sm:text-sm text-gray-500 mb-1">
                        Total à payer
                    </p>

                    <p class="text-lg sm:text-xl
                              font-bold text-red-600
                              break-words">
                        {{ number_format($achat->total, 2) }} GNF
                    </p>

                </div>

            </div>


            {{-- =================================================
                 PRODUITS
            ================================================== --}}
            <div>

                <h3 class="text-sm sm:text-base
                           font-semibold text-gray-800 mb-3">
                    Produits commandés
                </h3>


                {{-- ===============================
                     MOBILE : CARTES
                ================================ --}}
                <div class="md:hidden space-y-3">

                    @foreach($achat->details as $detail)

                        <div class="border border-gray-200
                                    rounded-xl
                                    bg-gray-50
                                    p-4">

                            <div class="mb-3">

                                <p class="text-xs text-gray-500 mb-1">
                                    Produit
                                </p>

                                <p class="text-sm font-bold
                                          text-gray-900
                                          break-words">
                                    {{ $detail->produit->nom_produit }}
                                </p>

                            </div>


                            <div class="grid grid-cols-2 gap-3
                                        border-t border-gray-200
                                        pt-3">

                                <div>

                                    <p class="text-xs text-gray-500">
                                        Quantité
                                    </p>

                                    <p class="text-sm font-semibold
                                              text-gray-800 mt-1">
                                        {{ $detail->quantite }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-gray-500">
                                        Prix unitaire
                                    </p>

                                    <p class="text-sm font-semibold
                                              text-gray-800 mt-1
                                              break-words">
                                        {{ number_format($detail->prix_unitaire, 2) }} GNF
                                    </p>

                                </div>


                                <div class="col-span-2">

                                    <p class="text-xs text-gray-500">
                                        Total
                                    </p>

                                    <p class="text-sm font-bold
                                              text-gray-900 mt-1
                                              break-words">
                                        {{ number_format($detail->quantite * $detail->prix_unitaire, 2) }} GNF
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- ===============================
                     DESKTOP : TABLEAU
                ================================ --}}
                <div class="hidden md:block
                            overflow-x-auto
                            border border-gray-200
                            rounded-lg">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-3 lg:px-4 py-3
                                           text-left text-xs
                                           font-semibold text-gray-500
                                           uppercase tracking-wider
                                           whitespace-nowrap">
                                    Produit
                                </th>

                                <th class="px-3 lg:px-4 py-3
                                           text-center text-xs
                                           font-semibold text-gray-500
                                           uppercase tracking-wider
                                           whitespace-nowrap">
                                    Qté
                                </th>

                                <th class="px-3 lg:px-4 py-3
                                           text-right text-xs
                                           font-semibold text-gray-500
                                           uppercase tracking-wider
                                           whitespace-nowrap">
                                    Prix Unit.
                                </th>

                                <th class="px-3 lg:px-4 py-3
                                           text-right text-xs
                                           font-semibold text-gray-500
                                           uppercase tracking-wider
                                           whitespace-nowrap">
                                    Total
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-200 bg-white">

                            @foreach($achat->details as $detail)

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-3 lg:px-4 py-3
                                               text-sm font-medium
                                               text-gray-900">
                                        {{ $detail->produit->nom_produit }}
                                    </td>

                                    <td class="px-3 lg:px-4 py-3
                                               text-sm text-center
                                               text-gray-700">
                                        {{ $detail->quantite }}
                                    </td>

                                    <td class="px-3 lg:px-4 py-3
                                               text-sm text-right
                                               text-gray-700
                                               whitespace-nowrap">
                                        {{ number_format($detail->prix_unitaire, 2) }}
                                    </td>

                                    <td class="px-3 lg:px-4 py-3
                                               text-sm text-right
                                               font-semibold
                                               text-gray-900
                                               whitespace-nowrap">
                                        {{ number_format($detail->quantite * $detail->prix_unitaire, 2) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- =====================================================
             FORMULAIRE DE RÉCEPTION
        ====================================================== --}}
        <form action="{{ route('achats.receive', $achat->id) }}"
              method="POST"
              class="bg-white
                     shadow-sm sm:shadow-md
                     rounded-xl
                     border border-gray-100
                     p-4 sm:p-6">

            @csrf


            <h2 class="text-base sm:text-lg
                       font-semibold text-gray-800 mb-5">
                Mode de paiement
            </h2>


            {{-- =================================================
                 TYPE DE PAIEMENT
            ================================================== --}}
            <div class="mb-5">

                <label class="block text-sm sm:text-base
                              text-gray-700
                              font-semibold mb-3">
                    Comment souhaitez-vous payer cet achat ?
                </label>


                <div class="space-y-3">

                    {{-- Comptant --}}
                    <label class="flex items-start
                                  gap-3
                                  p-3 sm:p-4
                                  border border-gray-200
                                  rounded-xl
                                  cursor-pointer
                                  hover:bg-gray-50
                                  transition">

                        <input type="radio"
                               name="type_paiement"
                               value="comptant"
                               class="mt-1 shrink-0"
                               {{ old('type_paiement', 'comptant') == 'comptant' ? 'checked' : '' }}
                               onchange="togglePaiementFields()">

                        <div class="min-w-0">

                            <span class="font-semibold
                                         text-green-600
                                         text-sm sm:text-base">
                                Paiement comptant
                            </span>

                            <p class="text-xs sm:text-sm
                                      text-gray-500 mt-1">
                                Payer la totalité maintenant
                                ({{ number_format($achat->total, 2) }} GNF)
                            </p>

                        </div>

                    </label>


                    {{-- Partiel --}}
                    <label class="flex items-start
                                  gap-3
                                  p-3 sm:p-4
                                  border border-gray-200
                                  rounded-xl
                                  cursor-pointer
                                  hover:bg-gray-50
                                  transition">

                        <input type="radio"
                               name="type_paiement"
                               value="partiel"
                               class="mt-1 shrink-0"
                               {{ old('type_paiement') == 'partiel' ? 'checked' : '' }}
                               onchange="togglePaiementFields()">

                        <div class="min-w-0">

                            <span class="font-semibold
                                         text-orange-600
                                         text-sm sm:text-base">
                                Paiement partiel
                            </span>

                            <p class="text-xs sm:text-sm
                                      text-gray-500 mt-1">
                                Payer une partie maintenant,
                                le reste plus tard
                            </p>

                        </div>

                    </label>


                    {{-- Crédit --}}
                    <label class="flex items-start
                                  gap-3
                                  p-3 sm:p-4
                                  border border-gray-200
                                  rounded-xl
                                  cursor-pointer
                                  hover:bg-gray-50
                                  transition">

                        <input type="radio"
                               name="type_paiement"
                               value="credit"
                               class="mt-1 shrink-0"
                               {{ old('type_paiement') == 'credit' ? 'checked' : '' }}
                               onchange="togglePaiementFields()">

                        <div class="min-w-0">

                            <span class="font-semibold
                                         text-red-600
                                         text-sm sm:text-base">
                                Achat à crédit
                            </span>

                            <p class="text-xs sm:text-sm
                                      text-gray-500 mt-1">
                                Recevoir le stock sans payer maintenant
                            </p>

                        </div>

                    </label>

                </div>


                @error('type_paiement')

                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- =================================================
                 CHAMPS PAIEMENT
            ================================================== --}}
            <div id="paiement-fields"
                 class="space-y-4">

                {{-- Caisse --}}
                <div>

                    <label for="caisse_id"
                           class="block text-sm sm:text-base
                                  text-gray-700
                                  font-semibold mb-2">
                        Choisir la caisse
                    </label>

                    <select name="caisse_id"
                            id="caisse_id"
                            class="form-select
                                   w-full
                                   min-h-[46px]
                                   border border-gray-300
                                   rounded-lg
                                   px-3 py-2.5
                                   text-sm sm:text-base
                                   bg-white
                                   focus:ring-2
                                   focus:ring-green-500
                                   focus:border-green-500
                                   @error('caisse_id') border-red-500 @enderror">

                        <option value="">
                            -- Sélectionner une caisse --
                        </option>

                        @foreach($caisses as $caisse)

                            <option value="{{ $caisse->id }}"
                                    data-solde="{{ $caisse->solde }}"
                                    {{ old('caisse_id') == $caisse->id ? 'selected' : '' }}>

                                {{ $caisse->nom }}
                                - Solde:
                                {{ number_format($caisse->solde, 2) }} GNF

                            </option>

                        @endforeach

                    </select>


                    @error('caisse_id')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                     MONTANT PARTIEL
                ================================================== --}}
                <div id="montant-partiel"
                     class="mb-4 hidden">

                    <label for="montant_paye"
                           class="block text-sm sm:text-base
                                  text-gray-700
                                  font-semibold mb-2">
                        Montant à payer maintenant
                    </label>

                    <input type="number"
                           name="montant_paye"
                           id="montant_paye"
                           step="0.01"
                           min="0"
                           max="{{ $achat->total }}"
                           class="form-input
                                  w-full
                                  min-h-[46px]
                                  border border-gray-300
                                  rounded-lg
                                  px-3 py-2.5
                                  text-sm sm:text-base
                                  focus:ring-2
                                  focus:ring-orange-500
                                  focus:border-orange-500
                                  @error('montant_paye') border-red-500 @enderror"
                           value="{{ old('montant_paye') }}"
                           placeholder="0.00">


                    @error('montant_paye')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror


                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Maximum :
                        {{ number_format($achat->total, 2) }} GNF
                    </p>

                </div>

            </div>


            {{-- =================================================
                 BOUTONS
            ================================================== --}}
            <div class="flex flex-col-reverse sm:flex-row
                        gap-3
                        mt-6
                        pt-5
                        border-t border-gray-100">

                <a href="{{ route('achats.show', $achat->id) }}"
                   class="inline-flex items-center
                          justify-center
                          w-full sm:w-auto
                          min-h-[46px]
                          bg-gray-500
                          hover:bg-gray-600
                          active:bg-gray-700
                          text-white
                          font-semibold
                          py-2.5 px-5
                          rounded-lg
                          text-sm sm:text-base
                          shadow-sm
                          transition">

                    Annuler

                </a>


                <button type="submit"
                        class="inline-flex items-center
                               justify-center
                               w-full sm:w-auto
                               min-h-[46px]
                               bg-green-600
                               hover:bg-green-700
                               active:bg-green-800
                               text-white
                               font-semibold
                               py-2.5 px-5
                               rounded-lg
                               text-sm sm:text-base
                               shadow-sm
                               transition">

                    Confirmer la réception

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}
<script>
function togglePaiementFields() {

    const selectedType = document.querySelector(
        'input[name="type_paiement"]:checked'
    );

    if (!selectedType) {
        return;
    }

    const type = selectedType.value;

    const paiementFields =
        document.getElementById('paiement-fields');

    const montantPartiel =
        document.getElementById('montant-partiel');

    const caisseSelect =
        document.getElementById('caisse_id');


    if (type === 'credit') {

        paiementFields.classList.add('hidden');

        caisseSelect.removeAttribute('required');

    } else {

        paiementFields.classList.remove('hidden');

        caisseSelect.setAttribute('required', 'required');


        if (type === 'partiel') {

            montantPartiel.classList.remove('hidden');

        } else {

            montantPartiel.classList.add('hidden');

        }

    }
}


// Initialiser au chargement
document.addEventListener(
    'DOMContentLoaded',
    togglePaiementFields
);
</script>

@endsection


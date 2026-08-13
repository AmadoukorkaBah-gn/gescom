@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50">

    <div class="w-full max-w-7xl mx-auto px-3 sm:px-5 lg:px-8 py-5 sm:py-7 lg:py-8">

        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}

        <div class="mb-6 sm:mb-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 tracking-tight">
                        Nouvelle Vente
                    </h1>

                    <p class="text-sm sm:text-base text-gray-500 mt-1.5 leading-relaxed">
                        Enregistrez une vente comptant. Le paiement sera effectué
                        juste après l'enregistrement.
                    </p>
                </div>

            </div>

        </div>


        {{-- =========================================================
             ERREURS
        ========================================================== --}}

        @if ($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 sm:p-5 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex-shrink-0 text-lg">
                        ⚠️
                    </div>

                    <div class="min-w-0">

                        <div class="font-semibold mb-2">
                            Impossible d'enregistrer la vente :
                        </div>

                        <ul class="list-disc list-inside text-sm space-y-1 leading-relaxed">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- =========================================================
             MESSAGE ERREUR
        ========================================================== --}}

        @if(session('error'))

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 sm:p-5 shadow-sm">

                <div class="flex items-start gap-3">

                    <span class="text-lg flex-shrink-0">⚠️</span>

                    <span class="text-sm sm:text-base leading-relaxed">
                        {{ session('error') }}
                    </span>

                </div>

            </div>

        @endif


        {{-- =========================================================
             FORMULAIRE
        ========================================================== --}}

        <form
            action="{{ route('ventes.store') }}"
            method="POST"
            id="venteForm"
        >

            @csrf


            {{-- =====================================================
                 CLIENT + DATE
            ====================================================== --}}

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-4 sm:p-6 lg:p-7 mb-5 sm:mb-6">

                <div class="mb-5">

                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                        Informations de la vente
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Renseignez le client et la date de la vente.
                    </p>

                </div>


                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6">


                    {{-- CLIENT --}}

                    <div>

                        <label
                            for="client_id"
                            class="block text-sm font-semibold text-gray-700 mb-1.5"
                        >
                            Client
                        </label>

                        <select
                            name="client_id"
                            id="client_id"
                            class="block w-full min-h-[46px] px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm text-sm sm:text-base text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition"
                            required
                        >

                            <option value="">
                                Sélectionner un client
                            </option>

                            @foreach($clients as $c)

                                <option
                                    value="{{ $c->id }}"
                                    {{ old('client_id') == $c->id ? 'selected' : '' }}
                                >
                                    {{ $c->nom_client }}

                                    @if($c->contact_client)
                                        — {{ $c->contact_client }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                        @error('client_id')

                            <p class="text-xs text-red-600 mt-1.5">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- DATE --}}

                    <div>

                        <label
                            for="date_vente"
                            class="block text-sm font-semibold text-gray-700 mb-1.5"
                        >
                            Date de vente
                        </label>

                        <input
                            type="date"
                            name="date_vente"
                            id="date_vente"
                            value="{{ old('date_vente', date('Y-m-d')) }}"
                            class="block w-full min-h-[46px] px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm text-sm sm:text-base text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition"
                            required
                        >

                        @error('date_vente')

                            <p class="text-xs text-red-600 mt-1.5">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 PRODUITS
            ====================================================== --}}

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-4 sm:p-6 lg:p-7 mb-5 sm:mb-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">

                    <div>

                        <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                            Produits vendus
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Sélectionnez les produits et les quantités.
                        </p>

                    </div>

                    <button
                        type="button"
                        id="addItem"
                        class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white font-semibold py-2.5 px-4 rounded-xl shadow-sm transition text-sm sm:text-base"
                    >
                        <span class="text-lg leading-none">+</span>
                        Ajouter un produit
                    </button>

                </div>


                <div id="itemsContainer">

                    {{-- =================================================
                         PREMIÈRE LIGNE
                    ================================================== --}}

                    <div class="item-row border border-gray-200 bg-gray-50/50 rounded-2xl p-4 sm:p-5 mb-4">

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">


                            {{-- PRODUIT --}}

                            <div class="sm:col-span-2 lg:col-span-2">

                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Produit
                                </label>

                                <select
                                    name="items[0][produit_id]"
                                    class="produit-select block w-full min-h-[46px] px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                    required
                                >

                                    <option value="">
                                        Sélectionner un produit
                                    </option>

                                    @foreach($produits as $p)

                                        <option
                                            value="{{ $p->id }}"
                                            data-stock="{{ $p->stockActuel() }}"
                                            data-prix="{{ $p->prix_vente }}"
                                        >
                                            {{ $p->nom_produit }}
                                            — Stock : {{ $p->stockActuel() }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- QUANTITÉ --}}

                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Quantité
                                </label>

                                <input
                                    type="number"
                                    name="items[0][quantite]"
                                    min="1"
                                    value="{{ old('items.0.quantite', 1) }}"
                                    class="quantite-input block w-full min-h-[46px] px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                    required
                                >

                            </div>


                            {{-- PRIX --}}

                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Prix unitaire
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="items[0][prix_unitaire]"
                                    min="0"
                                    class="prix-input block w-full min-h-[46px] px-3.5 py-2.5 bg-gray-100 border border-gray-300 rounded-xl shadow-sm text-sm text-gray-700"
                                    readonly
                                    required
                                >

                            </div>


                            {{-- STOCK + SUPPRESSION --}}

                            <div class="sm:col-span-2 lg:col-span-1 flex flex-col sm:flex-row lg:flex-col xl:flex-row lg:items-end justify-between gap-3">

                                <div class="flex items-center min-h-[46px]">

                                    <span class="stock-info text-sm font-medium text-gray-600">
                                    </span>

                                </div>

                                <button
                                    type="button"
                                    class="remove-item w-full sm:w-auto bg-red-500 hover:bg-red-600 active:bg-red-700 text-white font-semibold py-2.5 px-3.5 rounded-xl transition text-sm"
                                    style="display:none;"
                                >
                                    Supprimer
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 REMISE
            ====================================================== --}}

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-4 sm:p-6 lg:p-7 mb-5 sm:mb-6">

                <div class="mb-5">

                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                        Remise
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Vous pouvez appliquer une remise fixe ou en pourcentage.
                    </p>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                    {{-- TYPE --}}

                    <div>

                        <label
                            for="type_remise"
                            class="block text-sm font-semibold text-gray-700 mb-1.5"
                        >
                            Type de remise
                        </label>

                        <select
                            name="type_remise"
                            id="type_remise"
                            class="block w-full min-h-[46px] px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm text-sm sm:text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                        >

                            <option value="">
                                Aucune remise
                            </option>

                            <option
                                value="fixe"
                                {{ old('type_remise') === 'fixe' ? 'selected' : '' }}
                            >
                                Montant fixe (GNF)
                            </option>

                            <option
                                value="pourcentage"
                                {{ old('type_remise') === 'pourcentage' ? 'selected' : '' }}
                            >
                                Pourcentage (%)
                            </option>

                        </select>

                    </div>


                    {{-- VALEUR --}}

                    <div>

                        <label
                            for="valeur_remise"
                            class="block text-sm font-semibold text-gray-700 mb-1.5"
                        >
                            Valeur de la remise
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="valeur_remise"
                            id="valeur_remise"
                            value="{{ old('valeur_remise', 0) }}"
                            class="block w-full min-h-[46px] px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm text-sm sm:text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                        >

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 TOTALS
            ====================================================== --}}

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-4 sm:p-6 lg:p-7 mb-5 sm:mb-6">

                <div class="w-full md:max-w-lg md:ml-auto">

                    <div class="space-y-3">

                        <div class="flex items-center justify-between gap-4 text-sm sm:text-base text-gray-600">

                            <span>
                                Sous-total :
                            </span>

                            <span
                                id="sousTotalDisplay"
                                class="font-semibold text-gray-800 text-right"
                            >
                                0 GNF
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-4 text-sm sm:text-base text-red-600">

                            <span>
                                Remise :
                            </span>

                            <span
                                id="remiseDisplay"
                                class="font-semibold text-right"
                            >
                                - 0 GNF
                            </span>

                        </div>


                        <div class="border-t border-gray-200 pt-4 mt-2 flex items-center justify-between gap-4">

                            <span class="text-base sm:text-lg font-bold text-gray-900">
                                Total à payer :
                            </span>

                            <span
                                id="totalDisplay"
                                class="font-bold text-lg sm:text-2xl text-blue-600 text-right"
                            >
                                0 GNF
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 INFORMATION PAIEMENT
            ====================================================== --}}

            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 sm:p-5 mb-5 sm:mb-6">

                <div class="flex items-start gap-3">

                    <div class="flex-shrink-0 flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 text-lg">
                        ℹ
                    </div>

                    <div class="min-w-0">

                        <p class="font-bold text-blue-800 text-sm sm:text-base">
                            Vente comptant
                        </p>

                        <p class="text-sm text-blue-700 mt-1 leading-relaxed">
                            Après l'enregistrement, le stock sera automatiquement
                            mis à jour et vous serez redirigé vers la page
                            de paiement pour choisir la caisse.
                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 ACTIONS
            ====================================================== --}}

            <div class="flex flex-col-reverse sm:flex-row gap-3 sm:justify-end">

                <a
                    href="{{ route('ventes.index') }}"
                    class="w-full sm:w-auto inline-flex justify-center items-center text-gray-700 hover:text-gray-900 bg-white border border-gray-300 hover:bg-gray-50 px-5 py-2.5 rounded-xl transition font-semibold text-sm sm:text-base"
                >
                    Annuler
                </a>


                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full sm:w-auto inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2.5 px-5 rounded-xl shadow-sm transition text-sm sm:text-base"
                >

                    <svg
                        class="w-5 h-5 mr-2 flex-shrink-0"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />

                    </svg>

                    Enregistrer la vente

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =============================================================
     JAVASCRIPT
     LOGIQUE CONSERVÉE
============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    let itemIndex = 1;


    /*
    |--------------------------------------------------------------------------
    | MISE À JOUR STOCK / PRIX
    |--------------------------------------------------------------------------
    */

    function updateStockInfo(row) {

        const select =
            row.querySelector('.produit-select');

        const stockInfo =
            row.querySelector('.stock-info');

        const prixInput =
            row.querySelector('.prix-input');

        const qtyInput =
            row.querySelector('.quantite-input');

        const selectedOption =
            select.options[select.selectedIndex];


        if (
            selectedOption &&
            selectedOption.value
        ) {

            const stock =
                parseFloat(
                    selectedOption.dataset.stock
                ) || 0;


            const prix =
                selectedOption.dataset.prix || 0;


            stockInfo.textContent =
                'Stock : ' + stock;


            qtyInput.max = stock;


            prixInput.value = prix;

        } else {

            stockInfo.textContent = '';

            prixInput.value = '';

            qtyInput.removeAttribute('max');
        }


        calculerTotaux();
    }


    /*
    |--------------------------------------------------------------------------
    | CALCUL DES TOTAUX
    |--------------------------------------------------------------------------
    */

    function calculerTotaux() {

        let sousTotal = 0;


        document
            .querySelectorAll('.item-row')
            .forEach(row => {

                const qte =
                    parseFloat(
                        row.querySelector('.quantite-input').value
                    ) || 0;


                const prix =
                    parseFloat(
                        row.querySelector('.prix-input').value
                    ) || 0;


                sousTotal +=
                    qte * prix;

            });


        const typeRemise =
            document.getElementById('type_remise').value;


        const valeurRemise =
            parseFloat(
                document.getElementById('valeur_remise').value
            ) || 0;


        let remise = 0;


        if (typeRemise === 'fixe') {

            remise =
                Math.min(
                    valeurRemise,
                    sousTotal
                );

        }


        else if (typeRemise === 'pourcentage') {

            remise =
                sousTotal *
                (
                    Math.min(
                        valeurRemise,
                        100
                    ) / 100
                );

        }


        const total =
            sousTotal - remise;


        document.getElementById(
            'sousTotalDisplay'
        ).textContent =
            sousTotal.toLocaleString('fr-FR')
            + ' GNF';


        document.getElementById(
            'remiseDisplay'
        ).textContent =
            '- '
            + remise.toLocaleString('fr-FR')
            + ' GNF';


        document.getElementById(
            'totalDisplay'
        ).textContent =
            total.toLocaleString('fr-FR')
            + ' GNF';
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT PRODUIT / REMISE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'change',
        function (e) {

            if (
                e.target.classList.contains(
                    'produit-select'
                )
            ) {

                updateStockInfo(
                    e.target.closest('.item-row')
                );
            }


            if (
                e.target.id === 'type_remise'
            ) {

                calculerTotaux();
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | SAISIE QUANTITÉ / REMISE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'input',
        function (e) {

            if (
                e.target.classList.contains(
                    'quantite-input'
                )
                ||
                e.target.classList.contains(
                    'prix-input'
                )
                ||
                e.target.id === 'valeur_remise'
            ) {

                calculerTotaux();
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | AJOUTER UN PRODUIT
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('addItem')
        .addEventListener(
            'click',
            function () {

                const container =
                    document.getElementById(
                        'itemsContainer'
                    );


                const newRow =
                    document.createElement('div');


                newRow.className =
                    'item-row border border-gray-200 bg-gray-50/50 rounded-2xl p-4 sm:p-5 mb-4';


                newRow.innerHTML = `

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                        <div class="sm:col-span-2 lg:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Produit
                            </label>

                            <select
                                name="items[${itemIndex}][produit_id]"
                                class="produit-select block w-full min-h-[46px] px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                required
                            >

                                <option value="">
                                    Sélectionner un produit
                                </option>

                                @foreach($produits as $p)

                                    <option
                                        value="{{ $p->id }}"
                                        data-stock="{{ $p->stockActuel() }}"
                                        data-prix="{{ $p->prix_vente }}"
                                    >
                                        {{ $p->nom_produit }}
                                        — Stock : {{ $p->stockActuel() }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Quantité
                            </label>

                            <input
                                type="number"
                                name="items[${itemIndex}][quantite]"
                                min="1"
                                value="1"
                                class="quantite-input block w-full min-h-[46px] px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                required
                            >

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Prix unitaire
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="items[${itemIndex}][prix_unitaire]"
                                min="0"
                                class="prix-input block w-full min-h-[46px] px-3.5 py-2.5 bg-gray-100 border border-gray-300 rounded-xl shadow-sm text-sm text-gray-700"
                                readonly
                                required
                            >

                        </div>


                        <div class="sm:col-span-2 lg:col-span-1 flex flex-col sm:flex-row lg:flex-col xl:flex-row lg:items-end justify-between gap-3">

                            <div class="flex items-center min-h-[46px]">

                                <span class="stock-info text-sm font-medium text-gray-600">
                                </span>

                            </div>

                            <button
                                type="button"
                                class="remove-item w-full sm:w-auto bg-red-500 hover:bg-red-600 active:bg-red-700 text-white font-semibold py-2.5 px-3.5 rounded-xl transition text-sm"
                            >
                                Supprimer
                            </button>

                        </div>

                    </div>

                `;


                container.appendChild(newRow);


                itemIndex++;


                document
                    .querySelectorAll('.remove-item')
                    .forEach(
                        btn => btn.style.display = 'block'
                    );


                updateStockInfo(newRow);
            }
        );


    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER UN PRODUIT
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (e) {

            if (
                e.target.classList.contains(
                    'remove-item'
                )
            ) {

                e.target
                    .closest('.item-row')
                    .remove();


                const rows =
                    document.querySelectorAll(
                        '.item-row'
                    );


                if (rows.length === 1) {

                    rows[0]
                        .querySelector('.remove-item')
                        .style.display = 'none';
                }


                calculerTotaux();
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ÉVITER DOUBLE CLIC
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('venteForm')
        .addEventListener(
            'submit',
            function () {

                const button =
                    document.getElementById(
                        'submitBtn'
                    );


                button.disabled = true;


                button.classList.add(
                    'opacity-60',
                    'cursor-not-allowed'
                );


                button.innerHTML = `

                    <svg
                        class="animate-spin w-5 h-5 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                    >

                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        ></path>

                    </svg>

                    Enregistrement...

                `;
            }
        );


    /*
    |--------------------------------------------------------------------------
    | INITIALISATION
    |--------------------------------------------------------------------------
    */

    const firstRow =
        document.querySelector('.item-row');


    if (firstRow) {

        updateStockInfo(firstRow);

    }

});

</script>

@endsection
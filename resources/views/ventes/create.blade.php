
@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
            Nouvelle Vente
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Enregistrez une vente comptant. Le paiement sera effectué
            juste après l'enregistrement.
        </p>
    </div>


    {{-- =========================================================
         ERREURS
    ========================================================== --}}

    @if ($errors->any())

        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4">

            <div class="font-semibold mb-2">
                Impossible d'enregistrer la vente :
            </div>

            <ul class="list-disc list-inside text-sm space-y-1">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================================
         MESSAGE ERREUR
    ========================================================== --}}

    @if(session('error'))

        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4">

            {{ session('error') }}

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

        <div class="bg-white shadow-md rounded-xl p-6 mb-6">

            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Informations de la vente
            </h2>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- CLIENT --}}

                <div>

                    <label
                        for="client_id"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Client
                    </label>

                    <select
                        name="client_id"
                        id="client_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
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

                        <p class="text-xs text-red-600 mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- DATE --}}

                <div>

                    <label
                        for="date_vente"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Date de vente
                    </label>

                    <input
                        type="date"
                        name="date_vente"
                        id="date_vente"
                        value="{{ old('date_vente', date('Y-m-d')) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                    @error('date_vente')

                        <p class="text-xs text-red-600 mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             PRODUITS
        ====================================================== --}}

        <div class="bg-white shadow-md rounded-xl p-6 mb-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">

                <div>

                    <h2 class="text-lg font-semibold text-gray-800">
                        Produits vendus
                    </h2>

                    <p class="text-sm text-gray-500">
                        Sélectionnez les produits et les quantités.
                    </p>

                </div>

                <button
                    type="button"
                    id="addItem"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition"
                >
                    + Ajouter un produit
                </button>

            </div>


            <div id="itemsContainer">


                {{-- =================================================
                     PREMIÈRE LIGNE
                ================================================== --}}

                <div class="item-row border border-gray-200 rounded-xl p-4 mb-4">

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">


                        {{-- PRODUIT --}}

                        <div class="md:col-span-2">

                            <label class="block text-sm font-medium text-gray-700">
                                Produit
                            </label>

                            <select
                                name="items[0][produit_id]"
                                class="produit-select mt-1 block w-full border-gray-300 rounded-md shadow-sm"
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

                            <label class="block text-sm font-medium text-gray-700">
                                Quantité
                            </label>

                            <input
                                type="number"
                                name="items[0][quantite]"
                                min="1"
                                value="{{ old('items.0.quantite', 1) }}"
                                class="quantite-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required
                            >

                        </div>


                        {{-- PRIX --}}

                        <div>

                            <label class="block text-sm font-medium text-gray-700">
                                Prix unitaire
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="items[0][prix_unitaire]"
                                min="0"
                                class="prix-input mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50"
                                readonly
                                required
                            >

                        </div>


                        {{-- STOCK + SUPPRESSION --}}

                        <div class="flex items-end justify-between gap-2">

                            <span class="stock-info text-sm text-gray-600 pb-2">
                            </span>

                            <button
                                type="button"
                                class="remove-item bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-3 rounded-lg"
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

        <div class="bg-white shadow-md rounded-xl p-6 mb-6">

            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Remise
            </h2>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- TYPE --}}

                <div>

                    <label
                        for="type_remise"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Type de remise
                    </label>

                    <select
                        name="type_remise"
                        id="type_remise"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
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
                        class="block text-sm font-medium text-gray-700"
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
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    >

                </div>

            </div>

        </div>


        {{-- =====================================================
             TOTALS
        ====================================================== --}}

        <div class="bg-white shadow-md rounded-xl p-6 mb-6">

            <div class="w-full md:w-1/2 ml-auto space-y-3">

                <div class="flex justify-between text-gray-600">

                    <span>
                        Sous-total :
                    </span>

                    <span
                        id="sousTotalDisplay"
                        class="font-medium"
                    >
                        0 GNF
                    </span>

                </div>


                <div class="flex justify-between text-red-600">

                    <span>
                        Remise :
                    </span>

                    <span
                        id="remiseDisplay"
                        class="font-medium"
                    >
                        - 0 GNF
                    </span>

                </div>


                <div class="border-t pt-3 flex justify-between">

                    <span class="text-gray-800 font-bold">
                        Total à payer :
                    </span>

                    <span
                        id="totalDisplay"
                        class="font-bold text-xl text-blue-600"
                    >
                        0 GNF
                    </span>

                </div>

            </div>

        </div>


        {{-- =====================================================
             INFORMATION PAIEMENT
        ====================================================== --}}

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">

            <div class="flex gap-3">

                <div class="text-blue-600 text-xl">
                    ℹ
                </div>

                <div>

                    <p class="font-semibold text-blue-800">
                        Vente comptant
                    </p>

                    <p class="text-sm text-blue-700 mt-1">
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

        <div class="flex flex-col sm:flex-row gap-3">

            <button
                type="submit"
                id="submitBtn"
                class="inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-lg transition"
            >

                <svg
                    class="w-5 h-5 mr-2"
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


            <a
                href="{{ route('ventes.index') }}"
                class="inline-flex justify-center items-center text-gray-600 hover:text-gray-800 border border-gray-300 px-5 py-2.5 rounded-lg transition"
            >
                Annuler
            </a>

        </div>

    </form>

</div>


{{-- =============================================================
     JAVASCRIPT
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
                    'item-row border border-gray-200 rounded-xl p-4 mb-4';


                newRow.innerHTML = `

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                        <div class="md:col-span-2">

                            <label class="block text-sm font-medium text-gray-700">
                                Produit
                            </label>

                            <select
                                name="items[${itemIndex}][produit_id]"
                                class="produit-select mt-1 block w-full border-gray-300 rounded-md shadow-sm"
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

                            <label class="block text-sm font-medium text-gray-700">
                                Quantité
                            </label>

                            <input
                                type="number"
                                name="items[${itemIndex}][quantite]"
                                min="1"
                                value="1"
                                class="quantite-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required
                            >

                        </div>


                        <div>

                            <label class="block text-sm font-medium text-gray-700">
                                Prix unitaire
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="items[${itemIndex}][prix_unitaire]"
                                min="0"
                                class="prix-input mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50"
                                readonly
                                required
                            >

                        </div>


                        <div class="flex items-end justify-between gap-2">

                            <span class="stock-info text-sm text-gray-600 pb-2">
                            </span>

                            <button
                                type="button"
                                class="remove-item bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-3 rounded-lg"
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


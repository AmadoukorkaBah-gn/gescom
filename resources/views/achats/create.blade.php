
@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">

    <!-- =====================================================
         TITRE
    ====================================================== -->

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Nouveau Achat
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Enregistrez votre achat puis recevez-le pour mettre le stock à jour.
            </p>
        </div>

        <a href="{{ route('achats.index') }}"
           class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium">
            ← Retour aux achats
        </a>

    </div>


    <!-- =====================================================
         FORMULAIRE ACHAT
    ====================================================== -->

    <form action="{{ route('achats.store') }}" method="POST" id="achatForm">
        @csrf


        <!-- =================================================
             INFORMATIONS ACHAT
        ================================================== -->

        <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-6">

            <div class="flex items-center gap-3 mb-5">

                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <span class="text-blue-600 text-xl">🧾</span>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Informations de l'achat
                    </h2>

                    <p class="text-sm text-gray-500">
                        Fournisseur et informations de facturation
                    </p>
                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- FOURNISSEUR -->

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Fournisseur
                    </label>

                    <div class="flex gap-2">

                        <select
                            name="fournisseur_id"
                            id="fournisseur_id"
                            class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required
                        >

                            <option value="">
                                Sélectionner un fournisseur
                            </option>

                            @foreach($fournisseurs as $f)
                                <option value="{{ $f->id }}">
                                    {{ $f->nom_fournisseur }}
                                </option>
                            @endforeach

                        </select>


                        <button
                            type="button"
                            onclick="ouvrirModal('modalFournisseur')"
                            class="px-3 rounded-lg bg-green-600 hover:bg-green-700 text-white font-bold"
                            title="Ajouter un fournisseur"
                        >
                            +
                        </button>

                    </div>

                </div>


                <!-- DATE -->

                <div>

                    <label
                        for="date_achat"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Date d'achat
                    </label>

                    <input
                        type="date"
                        name="date_achat"
                        id="date_achat"
                        value="{{ date('Y-m-d') }}"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                    >

                </div>


                <!-- FACTURE -->

                <div>

                    <label
                        for="numero_facture"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Numéro de facture
                    </label>

                    <input
                        type="text"
                        name="numero_facture"
                        id="numero_facture"
                        placeholder="Ex: FAC-00125"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >

                </div>

            </div>

        </div>



        <!-- =================================================
             PRODUITS
        ================================================== -->

        <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">

                <div>

                    <h2 class="text-lg font-semibold text-gray-800">
                        Produits à acheter
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Ajoutez les produits et les quantités reçues.
                    </p>

                </div>


                <div class="flex gap-2">

                    <!-- AJOUTER PRODUIT -->

                    <button
                        type="button"
                        onclick="ouvrirModal('modalProduit')"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg"
                    >
                        <span class="text-lg">+</span>
                        Ajouter produit
                    </button>


                    <!-- AJOUTER LIGNE -->

                    <button
                        type="button"
                        id="addItem"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg"
                    >
                        <span class="text-lg">+</span>
                        Ajouter ligne
                    </button>

                </div>

            </div>


            <!-- LIGNES -->

            <div id="itemsContainer">

                <div class="item-row border border-gray-200 rounded-xl p-4 mb-4 bg-gray-50">

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                        <!-- PRODUIT -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Produit
                            </label>

                            <select
                                name="items[0][produit_id]"
                                class="produit-select block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required
                            >

                                <option value="">
                                    Sélectionner un produit
                                </option>

                                @foreach($produits as $p)

                                    <option value="{{ $p->id }}">
                                        {{ $p->nom_produit }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <!-- QUANTITE -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Quantité
                            </label>

                            <input
                                type="number"
                                name="items[0][quantite]"
                                min="1"
                                placeholder="0"
                                class="block w-full border-gray-300 rounded-lg shadow-sm"
                                required
                            >

                        </div>


                        <!-- PRIX -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prix unitaire
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="items[0][prix_unitaire]"
                                min="0"
                                placeholder="0"
                                class="block w-full border-gray-300 rounded-lg shadow-sm"
                                required
                            >

                        </div>


                        <!-- PEREMPTION -->

                        <div>

                           <label class="block text-sm font-medium text-gray-700">
    Date de péremption
    <span class="text-gray-400">(facultative)</span>
</label>

<input type="date"
       name="items[0][date_peremption]"
       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

                        </div>


                        <!-- SUPPRIMER -->

                        <div class="flex items-end">

                            <button
                                type="button"
                                class="remove-item w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg"
                                style="display:none;"
                            >
                                Supprimer
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- =================================================
             ACTIONS
        ================================================== -->

        <div class="flex flex-col sm:flex-row gap-3">

            <button
                type="submit"
                class="inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm"
            >
                Enregistrer l'achat
            </button>

            <a
                href="{{ route('achats.index') }}"
                class="inline-flex justify-center items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-lg"
            >
                Annuler
            </a>

        </div>

    </form>

</div>



<!-- =========================================================
     MODAL FOURNISSEUR
========================================================= -->

<div
    id="modalFournisseur"
    class="fixed inset-0 z-[100] hidden"
>

    <div
        class="absolute inset-0 bg-black/50"
        onclick="fermerModal('modalFournisseur')"
    ></div>


    <div class="relative flex items-center justify-center min-h-screen p-4">

        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden">

            <!-- HEADER -->

            <div class="px-6 py-4 border-b flex items-center justify-between">

                <div>

                    <h3 class="text-lg font-bold text-gray-800">
                        Ajouter un fournisseur
                    </h3>

                    <p class="text-sm text-gray-500">
                        Créez le fournisseur sans quitter l'achat.
                    </p>

                </div>

                <button
                    type="button"
                    onclick="fermerModal('modalFournisseur')"
                    class="text-gray-400 hover:text-gray-700 text-2xl"
                >
                    ×
                </button>

            </div>


            <!-- FORM -->

            <form id="fournisseurForm" class="p-6">

                <div class="space-y-4">

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nom du fournisseur *
                        </label>

                        <input
                            type="text"
                            name="nom_fournisseur"
                            required
                            class="w-full border-gray-300 rounded-lg"
                            placeholder="Ex: Société ABC"
                        >

                    </div>


                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="w-full border-gray-300 rounded-lg"
                            placeholder="contact@example.com"
                        >

                    </div>


                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Téléphone
                        </label>

                        <input
                            type="text"
                            name="contact_fournisseur"
                            class="w-full border-gray-300 rounded-lg"
                            placeholder="Ex: 622 00 00 00"
                        >

                    </div>


                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Adresse
                        </label>

                        <textarea
                            name="adresse_fournisseur"
                            rows="2"
                            class="w-full border-gray-300 rounded-lg"
                            placeholder="Adresse du fournisseur"
                        ></textarea>

                    </div>

                </div>


                <div
                    id="fournisseurError"
                    class="hidden mt-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm"
                ></div>


                <div class="flex justify-end gap-3 mt-6">

                    <button
                        type="button"
                        onclick="fermerModal('modalFournisseur')"
                        class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700"
                    >
                        Annuler
                    </button>

                    <button
                        type="submit"
                        id="btnFournisseur"
                        class="px-5 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold"
                    >
                        Ajouter
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<!-- =========================================================
     MODAL PRODUIT
========================================================= -->

<div
    id="modalProduit"
    class="fixed inset-0 z-[100] hidden"
>

    <div
        class="absolute inset-0 bg-black/50"
        onclick="fermerModal('modalProduit')"
    ></div>


    <div class="relative flex items-center justify-center min-h-screen p-4">

        <div class="bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl">

            <!-- HEADER -->

            <div class="sticky top-0 bg-white px-6 py-4 border-b flex items-center justify-between">

                <div>

                    <h3 class="text-lg font-bold text-gray-800">
                        Ajouter un produit
                    </h3>

                    <p class="text-sm text-gray-500">
                        Créez le produit sans quitter votre achat.
                    </p>

                </div>

                <button
                    type="button"
                    onclick="fermerModal('modalProduit')"
                    class="text-gray-400 hover:text-gray-700 text-2xl"
                >
                    ×
                </button>

            </div>


            <!-- FORM -->

            <form id="produitForm" class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- NOM -->

                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nom du produit *
                        </label>

                        <input
                            type="text"
                            name="nom_produit"
                            required
                            class="w-full border-gray-300 rounded-lg"
                            placeholder="Ex: Paracétamol 500mg"
                        >

                    </div>


                    <!-- CATEGORIE -->

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Catégorie *
                        </label>

                        <select
                            name="categorie_id"
                            required
                            class="w-full border-gray-300 rounded-lg"
                        >

                            <option value="">
                                Sélectionner une catégorie
                            </option>

                            @foreach($categories as $categorie)

                                <option value="{{ $categorie->id }}">
                                    {{ $categorie->nom_categorie }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- FOURNISSEUR -->

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Fournisseur
                        </label>

                        <select
                            name="fournisseur_id"
                            id="produit_fournisseur_id"
                            class="w-full border-gray-300 rounded-lg"
                        >

                            <option value="">
                                Aucun fournisseur
                            </option>

                            @foreach($fournisseurs as $f)

                                <option value="{{ $f->id }}">
                                    {{ $f->nom_fournisseur }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- PRIX ACHAT -->

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Prix d'achat *
                        </label>

                        <input
                            type="number"
                            name="prix_produit"
                            min="0"
                            step="0.01"
                            required
                            class="w-full border-gray-300 rounded-lg"
                            placeholder="0"
                        >

                    </div>


                    <!-- PRIX VENTE -->

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Prix de vente *
                        </label>

                        <input
                            type="number"
                            name="prix_vente"
                            min="0"
                            step="0.01"
                            required
                            class="w-full border-gray-300 rounded-lg"
                            placeholder="0"
                        >

                    </div>


                    <!-- STOCK MINIMUM -->

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Stock minimum *
                        </label>

                        <input
                            type="number"
                            name="stock_minimum"
                            min="0"
                            value="0"
                            required
                            class="w-full border-gray-300 rounded-lg"
                        >

                    </div>


                    <!-- STATUT -->

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Statut *
                        </label>

                        <select
                            name="statut"
                            required
                            class="w-full border-gray-300 rounded-lg"
                        >

                            <option value="1">
                                Actif
                            </option>

                            <option value="0">
                                Inactif
                            </option>

                        </select>

                    </div>

                </div>


                <div
                    id="produitError"
                    class="hidden mt-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm"
                ></div>


                <div class="flex justify-end gap-3 mt-6">

                    <button
                        type="button"
                        onclick="fermerModal('modalProduit')"
                        class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700"
                    >
                        Annuler
                    </button>

                    <button
                        type="submit"
                        id="btnProduit"
                        class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold"
                    >
                        Ajouter le produit
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    let itemIndex = 1;


    /*
    |--------------------------------------------------------------------------
    | MODALES
    |--------------------------------------------------------------------------
    */

    window.ouvrirModal = function(id) {

        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

    };


    window.fermerModal = function(id) {

        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

    };


    /*
    |--------------------------------------------------------------------------
    | AJOUTER UNE LIGNE PRODUIT
    |--------------------------------------------------------------------------
    */

    document.getElementById('addItem').addEventListener('click', function () {

        const container = document.getElementById('itemsContainer');

        const newRow = document.createElement('div');

        newRow.className =
            'item-row border border-gray-200 rounded-xl p-4 mb-4 bg-gray-50';


        newRow.innerHTML = `

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Produit
                    </label>

                    <select
                        name="items[${itemIndex}][produit_id]"
                        class="produit-select block w-full border-gray-300 rounded-lg"
                        required
                    >

                        <option value="">
                            Sélectionner un produit
                        </option>

                        @foreach($produits as $p)

                            <option value="{{ $p->id }}">
                                {{ $p->nom_produit }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Quantité
                    </label>

                    <input
                        type="number"
                        name="items[${itemIndex}][quantite]"
                        min="1"
                        class="block w-full border-gray-300 rounded-lg"
                        required
                    >

                </div>


                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Prix unitaire
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="items[${itemIndex}][prix_unitaire]"
                        min="0"
                        class="block w-full border-gray-300 rounded-lg"
                        required
                    >

                </div>


                <div>
    <label class="block text-sm font-medium text-gray-700">
        Date de péremption
        <span class="text-gray-400">(facultative)</span>
    </label>

    <input type="date"
           name="items[${itemIndex}][date_peremption]"
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
</div>


                <div class="flex items-end">

                    <button
                        type="button"
                        class="remove-item w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg"
                    >
                        Supprimer
                    </button>

                </div>

            </div>
        `;


        container.appendChild(newRow);

        itemIndex++;

        actualiserBoutonsSuppression();

    });


    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER UNE LIGNE
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (e) {

        if (e.target.closest('.remove-item')) {

            const button = e.target.closest('.remove-item');

            const row = button.closest('.item-row');

            if (row) {
                row.remove();
            }

            actualiserBoutonsSuppression();

        }

    });


    function actualiserBoutonsSuppression() {

        const rows = document.querySelectorAll('.item-row');

        document.querySelectorAll('.remove-item').forEach(function (button) {

            button.style.display =
                rows.length > 1 ? 'block' : 'none';

        });

    }


    /*
    |--------------------------------------------------------------------------
    | AJOUT FOURNISSEUR
    |--------------------------------------------------------------------------
    */

    document.getElementById('fournisseurForm').addEventListener('submit', async function (e) {

        e.preventDefault();


        const form = this;

        const button = document.getElementById('btnFournisseur');

        const errorBox = document.getElementById('fournisseurError');


        errorBox.classList.add('hidden');

        button.disabled = true;

        button.innerText = 'Ajout en cours...';


        try {

            const response = await fetch(
                "{{ route('achats.ajax.fournisseur') }}",
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN':
                            document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },

                    body: JSON.stringify(
                        Object.fromEntries(new FormData(form))
                    )
                }
            );


            const data = await response.json();


            if (!response.ok) {

                let message = 'Une erreur est survenue.';

                if (data.errors) {

                    message = Object.values(data.errors)
                        .flat()
                        .join('<br>');

                } else if (data.message) {

                    message = data.message;

                }

                throw new Error(message);
            }


            /*
            | Ajouter le nouveau fournisseur dans le select
            */

            const select = document.getElementById('fournisseur_id');

            const option = new Option(
                data.fournisseur.nom,
                data.fournisseur.id,
                true,
                true
            );

            select.add(option);

            select.value = data.fournisseur.id;


            /*
            | Ajouter également dans le select fournisseur
            | du formulaire produit
            */

            const produitFournisseur =
                document.getElementById('produit_fournisseur_id');

            if (produitFournisseur) {

                const optionProduit = new Option(
                    data.fournisseur.nom,
                    data.fournisseur.id
                );

                produitFournisseur.add(optionProduit);

            }


            form.reset();

            fermerModal('modalFournisseur');


            alert('Fournisseur ajouté avec succès.');

        } catch (error) {

            errorBox.innerHTML = error.message;

            errorBox.classList.remove('hidden');

        } finally {

            button.disabled = false;

            button.innerText = 'Ajouter';

        }

    });


    /*
    |--------------------------------------------------------------------------
    | AJOUT PRODUIT
    |--------------------------------------------------------------------------
    */

    document.getElementById('produitForm').addEventListener('submit', async function (e) {

        e.preventDefault();


        const form = this;

        const button = document.getElementById('btnProduit');

        const errorBox = document.getElementById('produitError');


        errorBox.classList.add('hidden');

        button.disabled = true;

        button.innerText = 'Création en cours...';


        try {

            const response = await fetch(
                "{{ route('achats.ajax.produit') }}",
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN':
                            document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },

                    body: JSON.stringify(
                        Object.fromEntries(new FormData(form))
                    )
                }
            );


            const data = await response.json();


            if (!response.ok) {

                let message = 'Une erreur est survenue.';

                if (data.errors) {

                    message = Object.values(data.errors)
                        .flat()
                        .join('<br>');

                } else if (data.message) {

                    message = data.message;

                }

                throw new Error(message);

            }


            /*
            |--------------------------------------------------------------------------
            | Ajouter le nouveau produit dans TOUTES les lignes
            |--------------------------------------------------------------------------
            */

            document.querySelectorAll('.produit-select').forEach(function (select) {

                const option = new Option(
                    data.produit.nom,
                    data.produit.id
                );

                select.add(option);

            });


            /*
            |--------------------------------------------------------------------------
            | Sélectionner automatiquement le nouveau produit
            | dans la dernière ligne
            |--------------------------------------------------------------------------
            */

            const selects =
                document.querySelectorAll('.produit-select');

            const dernierSelect =
                selects[selects.length - 1];

            dernierSelect.value =
                data.produit.id;


            /*
            |--------------------------------------------------------------------------
            | Réinitialiser et fermer
            |--------------------------------------------------------------------------
            */

            form.reset();

            fermerModal('modalProduit');


            alert('Produit ajouté avec succès.');

        } catch (error) {

            errorBox.innerHTML = error.message;

            errorBox.classList.remove('hidden');

        } finally {

            button.disabled = false;

            button.innerText = 'Ajouter le produit';

        }

    });


    /*
    |--------------------------------------------------------------------------
    | ESCAPE POUR FERMER LES MODALES
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {

            fermerModal('modalFournisseur');
            fermerModal('modalProduit');

        }

    });

});

</script>

@endsection


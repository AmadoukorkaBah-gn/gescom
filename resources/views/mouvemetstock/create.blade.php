@extends('layouts.app')

@section('content')

<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}
    <div class="mb-5 sm:mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-800 tracking-tight">
                    Nouveau Approvisionnement
                </h1>

                <p class="mt-1 text-xs sm:text-sm text-gray-500">
                    Enregistrer un nouvel approvisionnement fournisseur
                </p>
            </div>

        </div>
    </div>


    {{-- =========================================================
         FORMULAIRE
    ========================================================== --}}
    <form action="{{ route('mouvement.store') }}" method="POST" id="achatForm">
        @csrf


        {{-- =====================================================
             INFORMATIONS APPROVISIONNEMENT
        ====================================================== --}}
        <div class="bg-white shadow-sm sm:shadow-md rounded-xl border border-gray-100 p-4 sm:p-6 mb-5 sm:mb-6">

            <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">

                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-800">
                        Informations générales
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500">
                        Sélectionnez le fournisseur et la date
                    </p>
                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">

                {{-- Fournisseur --}}
                <div>

                    <label for="fournisseur_id"
                           class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Fournisseur
                    </label>

                    <select
                        name="fournisseur_id"
                        id="fournisseur_id"
                        class="w-full min-h-[44px] border border-gray-300 rounded-lg px-3 py-2.5
                               text-sm sm:text-base text-gray-800 bg-white
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition"
                        required>

                        <option value="">
                            Sélectionner un fournisseur
                        </option>

                        @foreach($fournisseurs as $f)
                            <option value="{{ $f->id }}">
                                {{ $f->nom_fournisseur }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Date --}}
                <div>

                    <label for="date"
                           class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Date d'approvisionnement
                    </label>

                    <input
                        type="date"
                        name="date"
                        id="date"
                        value="{{ date('Y-m-d') }}"
                        class="w-full min-h-[44px] border border-gray-300 rounded-lg px-3 py-2.5
                               text-sm sm:text-base text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition"
                        required>

                </div>

            </div>

        </div>



        {{-- =====================================================
             PRODUITS
        ====================================================== --}}
        <div class="bg-white shadow-sm sm:shadow-md rounded-xl border border-gray-100 p-4 sm:p-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5 pb-4 border-b border-gray-100">

                <div class="flex items-center gap-3">

                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-50 text-green-600 flex-shrink-0">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>

                    </div>

                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-800">
                            Produits à approvisionner
                        </h2>

                        <p class="text-xs sm:text-sm text-gray-500">
                            Ajoutez les produits et leurs quantités
                        </p>
                    </div>

                </div>


                {{-- Compteur visuel --}}
                <div class="text-xs sm:text-sm text-gray-500">
                    <span class="font-semibold text-gray-700">
                        Produits :
                    </span>

                    <span id="itemCount">
                        1
                    </span>
                </div>

            </div>


            {{-- =================================================
                 CONTENEUR DES PRODUITS
            ================================================== --}}
            <div id="itemsContainer" class="space-y-4">

                <div class="item-row relative bg-gray-50 border border-gray-200 rounded-xl p-4">

                    {{-- Numéro --}}
                    <div class="flex items-center justify-between mb-4">

                        <div class="flex items-center gap-2">

                            <span class="flex items-center justify-center w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-bold">
                                1
                            </span>

                            <span class="text-sm font-bold text-gray-700">
                                Produit
                            </span>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- Produit --}}
                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Produit
                            </label>

                            <select
                                name="items[0][produit_id]"
                                class="produit-select w-full min-h-[44px] border border-gray-300 rounded-lg
                                       px-3 py-2.5 text-sm sm:text-base text-gray-800 bg-white
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                       transition"
                                required>

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


                        {{-- Quantité --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Quantité
                            </label>

                            <input
                                type="number"
                                name="items[0][quantite]"
                                min="1"
                                class="w-full min-h-[44px] border border-gray-300 rounded-lg
                                       px-3 py-2.5 text-sm sm:text-base text-gray-800
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                       transition"
                                required>

                        </div>

                    </div>


                    {{-- Suppression --}}
                    <div class="mt-4 flex justify-end">

                        <button
                            type="button"
                            class="remove-item hidden bg-red-50 hover:bg-red-100 text-red-600
                                   border border-red-200 font-semibold text-sm
                                   py-2 px-3 rounded-lg items-center gap-2 transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-4 h-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 2h4a1 1 0 011 1v1H9V3a1 1 0 011-1z"/>

                            </svg>

                            Supprimer

                        </button>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 AJOUT PRODUIT
            ================================================== --}}
            <div class="mt-5">

                <button
                    type="button"
                    id="addItem"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                           bg-green-600 hover:bg-green-700
                           text-white font-semibold text-sm sm:text-base
                           py-2.5 px-4 rounded-lg
                           shadow-sm hover:shadow transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 4v16m8-8H4"/>

                    </svg>

                    Ajouter un produit

                </button>

            </div>

        </div>



        {{-- =====================================================
             ACTIONS
        ====================================================== --}}
        <div class="mt-5 sm:mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

            <a
                href="{{ route('mouvement.index') }}"
                class="w-full sm:w-auto inline-flex justify-center items-center
                       bg-gray-100 hover:bg-gray-200
                       text-gray-700 font-semibold text-sm sm:text-base
                       py-2.5 px-5 rounded-lg
                       border border-gray-200 transition">

                Annuler

            </a>


            <button
                type="submit"
                class="w-full sm:w-auto inline-flex justify-center items-center gap-2
                       bg-blue-600 hover:bg-blue-700
                       text-white font-semibold text-sm sm:text-base
                       py-2.5 px-5 rounded-lg
                       shadow-sm hover:shadow transition">

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

                Enregistrer l'approvisionnement

            </button>

        </div>

    </form>

</div>



{{-- =============================================================
     JAVASCRIPT
============================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function() {

    let itemIndex = 1;

    const container = document.getElementById('itemsContainer');
    const addButton = document.getElementById('addItem');
    const itemCount = document.getElementById('itemCount');


    function updateItems() {

        const rows = document.querySelectorAll('.item-row');
        const removeButtons = document.querySelectorAll('.remove-item');

        itemCount.textContent = rows.length;

        removeButtons.forEach(function(btn) {

            if (rows.length > 1) {

                btn.classList.remove('hidden');
                btn.classList.add('inline-flex');

            } else {

                btn.classList.add('hidden');
                btn.classList.remove('inline-flex');

            }

        });


        // Mettre à jour les numéros visuels
        rows.forEach(function(row, index) {

            const number = row.querySelector('.flex.items-center.gap-2 span');

            if (number) {
                number.textContent = index + 1;
            }

        });

    }


    addButton.addEventListener('click', function() {

        const newRow = document.createElement('div');

        newRow.className =
            'item-row relative bg-gray-50 border border-gray-200 rounded-xl p-4';


        newRow.innerHTML = `

            <div class="flex items-center justify-between mb-4">

                <div class="flex items-center gap-2">

                    <span class="flex items-center justify-center w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-bold">
                        ${itemIndex + 1}
                    </span>

                    <span class="text-sm font-bold text-gray-700">
                        Produit
                    </span>

                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="md:col-span-2">

                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Produit
                    </label>

                    <select
                        name="items[${itemIndex}][produit_id]"
                        class="produit-select w-full min-h-[44px] border border-gray-300 rounded-lg
                               px-3 py-2.5 text-sm sm:text-base text-gray-800 bg-white
                               focus:outline-none focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500 transition"
                        required>

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

                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Quantité
                    </label>

                    <input
                        type="number"
                        name="items[${itemIndex}][quantite]"
                        min="1"
                        class="w-full min-h-[44px] border border-gray-300 rounded-lg
                               px-3 py-2.5 text-sm sm:text-base text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500 transition"
                        required>

                </div>

            </div>


            <div class="mt-4 flex justify-end">

                <button
                    type="button"
                    class="remove-item inline-flex items-center gap-2
                           bg-red-50 hover:bg-red-100
                           text-red-600 border border-red-200
                           font-semibold text-sm
                           py-2 px-3 rounded-lg transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-4 h-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 2h4a1 1 0 011 1v1H9V3a1 1 0 011-1z"/>

                    </svg>

                    Supprimer

                </button>

            </div>
        `;


        container.appendChild(newRow);

        itemIndex++;

        updateItems();

    });


    document.addEventListener('click', function(e) {

        const removeButton = e.target.closest('.remove-item');

        if (removeButton) {

            const row = removeButton.closest('.item-row');

            if (row) {
                row.remove();
            }

            updateItems();

        }

    });


    updateItems();

});

</script>

@endsection
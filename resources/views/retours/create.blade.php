@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 sm:py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-3xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="mb-6">

            <div class="flex items-center gap-3 mb-2">

                <div class="flex items-center justify-center
                            w-11 h-11
                            rounded-xl
                            bg-indigo-100
                            text-indigo-600
                            text-xl
                            shadow-sm">
                    ↩
                </div>

                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                        Ajouter un retour
                    </h1>

                    <p class="text-sm sm:text-base text-slate-500 mt-1">
                        Enregistrez le retour d'un produit et gérez automatiquement le remboursement.
                    </p>
                </div>

            </div>

        </div>


        {{-- =====================================================
             MESSAGES D'ERREUR
        ====================================================== --}}
        @if($errors->any())

            <div class="mb-6 rounded-xl border border-red-200
                        bg-red-50 p-4 shadow-sm">

                <div class="flex items-start gap-3">

                    <span class="text-xl flex-shrink-0">
                        ⚠️
                    </span>

                    <div>

                        <p class="font-semibold text-red-800">
                            Veuillez corriger les erreurs suivantes :
                        </p>

                        <ul class="mt-2 list-disc list-inside
                                   text-sm text-red-700 space-y-1">

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
        <div class="bg-white rounded-2xl shadow-sm
                    border border-slate-200 overflow-hidden">

            {{-- En-tête formulaire --}}
            <div class="px-5 sm:px-7 py-5
                        border-b border-slate-200
                        bg-slate-50">

                <h2 class="text-lg font-bold text-slate-800">
                    Informations du retour
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Sélectionnez la vente concernée puis le produit retourné.
                </p>

            </div>


            <form action="{{ route('retours.store') }}"
                  method="POST"
                  class="p-5 sm:p-7 space-y-6">

                @csrf


                {{-- =================================================
                     VENTE
                ================================================== --}}
                <div>

                    <label for="vente_select"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Vente

                    </label>

                    <select
                        id="vente_select"
                        name="vente_id"
                        required

                        class="w-full
                               rounded-xl
                               border-slate-300
                               bg-white
                               px-4 py-3
                               text-sm sm:text-base
                               text-slate-700
                               shadow-sm
                               transition
                               focus:border-indigo-500
                               focus:ring-2
                               focus:ring-indigo-500/20
                               hover:border-slate-400"
                    >

                        <option value="">
                            -- Sélectionnez une vente --
                        </option>

                        @foreach($ventes as $vente)

                            <option
                                value="{{ $vente->id }}"
                                data-produits='@json(
                                    $vente->details->map(
                                        fn($d) => [
                                            "id" => $d->produit->id,
                                            "nom" => $d->produit->nom_produit
                                        ]
                                    )
                                )'
                            >

                                Vente N°{{ $vente->id }}
                                — {{ $vente->client->nom_client ?? 'Client non renseigné' }}

                            </option>

                        @endforeach

                    </select>

                    <p class="mt-1.5 text-xs text-slate-500">
                        Sélectionnez la vente contenant le produit retourné.
                    </p>

                </div>


                {{-- =================================================
                     PRODUIT
                ================================================== --}}
                <div>

                    <label for="produit_select"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Produit retourné

                    </label>

                    <select
                        id="produit_select"
                        name="produit_id"
                        required

                        class="w-full
                               rounded-xl
                               border-slate-300
                               bg-white
                               px-4 py-3
                               text-sm sm:text-base
                               text-slate-700
                               shadow-sm
                               transition
                               focus:border-indigo-500
                               focus:ring-2
                               focus:ring-indigo-500/20
                               hover:border-slate-400"
                    >

                        <option value="">
                            -- Sélectionnez un produit --
                        </option>

                    </select>

                    <p class="mt-1.5 text-xs text-slate-500">
                        Les produits disponibles apparaîtront après sélection de la vente.
                    </p>

                </div>


                {{-- =================================================
                     QUANTITÉ + RAISON
                ================================================== --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- Quantité --}}
                    <div>

                        <label for="quantite"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Quantité

                        </label>

                        <input
                            type="number"
                            id="quantite"
                            name="quantite"
                            required
                            min="1"
                            value="{{ old('quantite') }}"

                            class="w-full
                                   rounded-xl
                                   border-slate-300
                                   px-4 py-3
                                   text-sm sm:text-base
                                   text-slate-700
                                   shadow-sm
                                   transition
                                   focus:border-indigo-500
                                   focus:ring-2
                                   focus:ring-indigo-500/20
                                   hover:border-slate-400"
                        >

                    </div>


                    {{-- Raison --}}
                    <div>

                        <label for="raison"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Motif du retour

                        </label>

                        <input
                            type="text"
                            id="raison"
                            name="raison"
                            required
                            value="{{ old('raison') }}"
                            placeholder="Ex : Produit défectueux"

                            class="w-full
                                   rounded-xl
                                   border-slate-300
                                   px-4 py-3
                                   text-sm sm:text-base
                                   text-slate-700
                                   shadow-sm
                                   transition
                                   focus:border-indigo-500
                                   focus:ring-2
                                   focus:ring-indigo-500/20
                                   hover:border-slate-400"
                        >

                    </div>

                </div>


                {{-- =================================================
                     CAISSE
                ================================================== --}}
                <div class="rounded-xl
                            border border-amber-200
                            bg-amber-50
                            p-4 sm:p-5">

                    <div class="flex items-start gap-3 mb-4">

                        <div class="flex-shrink-0
                                    flex items-center justify-center
                                    w-10 h-10
                                    rounded-lg
                                    bg-amber-100
                                    text-amber-700
                                    text-lg">

                            💰

                        </div>

                        <div>

                            <h3 class="font-bold text-amber-900">
                                Caisse à débiter
                            </h3>

                            <p class="text-sm text-amber-700 mt-1">
                                Sélectionnez la caisse utilisée pour effectuer le remboursement.
                            </p>

                        </div>

                    </div>


                    <label for="caisse_id"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Caisse à débiter (remboursement)

                    </label>


                    <select
                        id="caisse_id"
                        name="caisse_id"
                        required

                        class="w-full
                               rounded-xl
                               border-slate-300
                               bg-white
                               px-4 py-3
                               text-sm sm:text-base
                               text-slate-700
                               shadow-sm
                               transition
                               focus:border-indigo-500
                               focus:ring-2
                               focus:ring-indigo-500/20"
                    >

                        <option value="">
                            -- Sélectionnez une caisse --
                        </option>

                        @forelse($caisses as $caisse)

                            <option
                                value="{{ $caisse->id }}"
                                {{ old('caisse_id') == $caisse->id ? 'selected' : '' }}
                            >

                                {{ $caisse->nom }}
                                — Solde :
                                {{ number_format($caisse->solde, 2, ',', ' ') }}
                                GNF

                            </option>

                        @empty

                            <option value="" disabled>
                                Aucune caisse disponible pour votre entreprise
                            </option>

                        @endforelse

                    </select>


                    <div class="flex items-start gap-2 mt-3">

                        <span class="text-amber-600 text-sm">
                            ℹ️
                        </span>

                        <p class="text-xs sm:text-sm text-amber-700">

                            Le montant du remboursement sera débité de cette caisse.

                        </p>

                    </div>

                </div>


                {{-- =================================================
                     BOUTONS
                ================================================== --}}
                <div class="pt-2
                            flex flex-col-reverse
                            sm:flex-row
                            sm:justify-end
                            gap-3">

                    <a
                        href="{{ route('retours.index') }}"

                        class="inline-flex
                               items-center
                               justify-center
                               px-5 py-3
                               rounded-xl
                               border border-slate-300
                               bg-white
                               text-slate-700
                               text-sm font-semibold
                               hover:bg-slate-50
                               hover:border-slate-400
                               transition"
                    >

                        Annuler

                    </a>


                    <button
                        type="submit"

                        class="inline-flex
                               items-center
                               justify-center
                               gap-2
                               px-6 py-3
                               rounded-xl
                               bg-indigo-600
                               text-white
                               text-sm font-semibold
                               shadow-sm
                               hover:bg-indigo-700
                               active:scale-[.98]
                               transition"
                    >

                        <span>↩</span>

                        Enregistrer le retour

                    </button>

                </div>

            </form>

        </div>


        {{-- =====================================================
             INFORMATION
        ====================================================== --}}
        <div class="mt-5 rounded-xl
                    border border-blue-200
                    bg-blue-50
                    px-4 py-3">

            <div class="flex items-start gap-3">

                <span class="text-blue-600 text-lg">
                    ℹ️
                </span>

                <p class="text-sm text-blue-800">

                    Vérifiez attentivement la vente, le produit et la quantité
                    avant d'enregistrer le retour.

                </p>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     SCRIPT : PRODUITS SELON LA VENTE
============================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const venteSelect = document.getElementById('vente_select');
    const produitSelect = document.getElementById('produit_select');

    if (!venteSelect || !produitSelect) {
        return;
    }

    venteSelect.addEventListener('change', function () {

        const selectedOption = venteSelect.selectedOptions[0];

        const produits = selectedOption && selectedOption.dataset.produits
            ? JSON.parse(selectedOption.dataset.produits)
            : [];

        // Vider le select des produits
        produitSelect.innerHTML =
            '<option value="">-- Sélectionnez un produit --</option>';

        // Ajouter les produits disponibles pour cette vente
        produits.forEach(function (p) {

            const option = document.createElement('option');

            option.value = p.id;
            option.textContent = p.nom;

            produitSelect.appendChild(option);

        });

    });

});

</script>

@endsection
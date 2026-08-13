@extends('layouts.app')

@section('content')

{{-- =========================================================
     POLICE
========================================================= --}}
<style>
    .inventaire-page {
        font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        letter-spacing: 0.01em;
    }

    .inventaire-page h1,
    .inventaire-page h2,
    .inventaire-page h3 {
        letter-spacing: -0.02em;
    }

    .inventaire-page label,
    .inventaire-page th {
        letter-spacing: 0.015em;
    }

    .inventaire-page input,
    .inventaire-page button,
    .inventaire-page a {
        font-family: inherit;
    }
</style>

<div class="inventaire-page min-h-screen bg-slate-50 py-6 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">

        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800">
                    Nouvel inventaire
                </h1>

                <p class="mt-1 text-sm sm:text-base font-medium text-slate-500">
                    Comptez physiquement les produits puis saisissez les quantités constatées.
                </p>
            </div>

            <a href="{{ route('inventaire.index') }}"
               class="inline-flex items-center justify-center gap-2
                      px-4 py-2.5 rounded-lg
                      bg-slate-700 text-white
                      text-sm font-semibold
                      hover:bg-slate-800
                      transition">

                ← Retour à l'inventaire

            </a>

        </div>


        {{-- =========================================================
             MESSAGES
        ========================================================== --}}

        @if(session('error'))

            <div class="mb-6 rounded-lg border border-red-200
                        bg-red-50 px-4 py-3 text-sm font-medium text-red-700">

                ⚠️ {{ session('error') }}

            </div>

        @endif


        @if($errors->any())

            <div class="mb-6 rounded-lg border border-red-200
                        bg-red-50 px-4 py-3">

                <p class="font-bold text-red-700 mb-2">
                    Veuillez corriger les erreurs suivantes :
                </p>

                <ul class="list-disc list-inside text-sm font-medium text-red-600 space-y-1">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =========================================================
             FORMULAIRE
        ========================================================== --}}

        <form method="POST"
              action="{{ route('inventaire.store') }}"
              x-data="inventaireForm()">

            @csrf


            {{-- =====================================================
                 INFORMATIONS INVENTAIRE
            ====================================================== --}}

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-6">

                <div class="flex items-center gap-2 mb-5">

                    <span class="text-xl">
                        📋
                    </span>

                    <h2 class="text-lg font-bold text-slate-800">
                        Informations de l'inventaire
                    </h2>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Date --}}
                    <div>

                        <label for="date_inventaire"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Date de l'inventaire

                        </label>

                        <input
                            type="date"
                            id="date_inventaire"
                            name="date_inventaire"
                            value="{{ old('date_inventaire', now()->format('Y-m-d')) }}"
                            required

                            class="w-full rounded-lg border-slate-300
                                   focus:border-blue-500
                                   focus:ring-blue-500
                                   text-sm font-medium"
                        >

                    </div>


                    {{-- Référence --}}
                    <div>

                        <label for="reference"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Référence

                        </label>

                        <input
                            type="text"
                            id="reference"
                            name="reference"
                            value="{{ old('reference', 'INV-' . now()->format('Ymd-His')) }}"
                            readonly

                            class="w-full rounded-lg border-slate-300
                                   bg-slate-100
                                   text-slate-600
                                   text-sm font-semibold"
                        >

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 RECHERCHE
            ====================================================== --}}

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div>

                        <h2 class="text-lg font-bold text-slate-800">
                            Produits à inventorier
                        </h2>

                        <p class="text-sm font-medium text-slate-500 mt-1">
                            Vérifiez le stock physique de chaque produit.
                        </p>

                    </div>


                    <div class="relative w-full sm:w-80">

                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            🔎
                        </span>

                        <input
                            type="search"
                            x-model="search"
                            placeholder="Rechercher un produit..."

                            class="w-full pl-10 pr-4 py-2.5
                                   rounded-lg
                                   border-slate-300
                                   text-sm font-medium
                                   focus:border-blue-500
                                   focus:ring-blue-500"
                        >

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 PRODUITS
            ====================================================== --}}

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">

                {{-- DESKTOP --}}
                <div class="hidden md:block overflow-x-auto">

                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-5 py-3 text-left text-xs font-bold
                                           uppercase tracking-wider text-slate-500">
                                    Produit
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-bold
                                           uppercase tracking-wider text-slate-500">
                                    Catégorie
                                </th>

                                <th class="px-5 py-3 text-center text-xs font-bold
                                           uppercase tracking-wider text-slate-500">
                                    Stock théorique
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-bold
                                           uppercase tracking-wider text-slate-500">
                                    Prix produit
                                </th>

                                <th class="px-5 py-3 text-center text-xs font-bold
                                           uppercase tracking-wider text-slate-500">
                                    Quantité comptée
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse($produits as $produit)

                                @php
                                    $stockActuel = $produit->stockActuel();
                                @endphp

                                <tr
                                    x-show="matches('{{ strtolower(addslashes($produit->nom_produit)) }}')"
                                    class="hover:bg-slate-50 transition"
                                >

                                    {{-- Produit --}}
                                    <td class="px-5 py-4">

                                        <div class="font-bold text-slate-800">
                                            {{ $produit->nom_produit }}
                                        </div>

                                        @if($produit->fournisseur)

                                            <div class="text-xs font-medium text-slate-500 mt-1">
                                                {{ $produit->fournisseur->nom ?? $produit->fournisseur->nom_fournisseur ?? '' }}
                                            </div>

                                        @endif

                                    </td>


                                    {{-- Catégorie --}}
                                    <td class="px-5 py-4 text-sm font-medium text-slate-600">

                                        {{ $produit->categorie->nom_categorie
                                            ?? $produit->categorie->nom
                                            ?? '-' }}

                                    </td>


                                    {{-- Stock théorique --}}
                                    <td class="px-5 py-4 text-center">

                                        <span class="inline-flex items-center justify-center
                                                     min-w-12 px-3 py-1.5
                                                     rounded-lg
                                                     bg-blue-50
                                                     text-blue-700
                                                     font-extrabold">

                                            {{ $stockActuel }}

                                        </span>

                                    </td>


                                    {{-- Prix --}}
                                    <td class="px-5 py-4 text-right text-sm font-semibold text-slate-700">

                                        {{ number_format($produit->prix_produit ?? 0, 0, ',', ' ') }}
                                        GNF

                                    </td>


                                    {{-- Quantité réelle --}}
                                    <td class="px-5 py-4">

                                        <input
                                            type="number"
                                            min="0"
                                            step="1"

                                            name="produits[{{ $produit->id }}][quantite_reelle]"

                                            value="{{ old(
                                                'produits.' . $produit->id . '.quantite_reelle',
                                                $stockActuel
                                            ) }}"

                                            required

                                            class="w-32 mx-auto block
                                                   rounded-lg
                                                   border-slate-300
                                                   text-center
                                                   font-bold
                                                   focus:border-blue-500
                                                   focus:ring-blue-500"
                                        >

                                        <input
                                            type="hidden"
                                            name="produits[{{ $produit->id }}][quantite_theorique]"
                                            value="{{ $stockActuel }}"
                                        >

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5"
                                        class="px-6 py-12 text-center">

                                        <div class="text-4xl mb-3">
                                            📦
                                        </div>

                                        <p class="font-bold text-slate-700">
                                            Aucun produit disponible
                                        </p>

                                        <p class="text-sm font-medium text-slate-500 mt-1">
                                            Ajoutez des produits avant de réaliser un inventaire.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                     MOBILE
                ================================================== --}}

                <div class="md:hidden divide-y divide-slate-100">

                    @forelse($produits as $produit)

                        @php
                            $stockActuel = $produit->stockActuel();
                        @endphp

                        <div
                            x-show="matches('{{ strtolower(addslashes($produit->nom_produit)) }}')"
                            class="p-4"
                        >

                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <h3 class="font-bold text-slate-800 truncate">
                                        {{ $produit->nom_produit }}
                                    </h3>

                                    <p class="text-xs font-medium text-slate-500 mt-1">

                                        {{ $produit->categorie->nom_categorie
                                            ?? $produit->categorie->nom
                                            ?? 'Sans catégorie' }}

                                    </p>

                                </div>


                                <span class="flex-shrink-0
                                             inline-flex items-center
                                             px-2.5 py-1
                                             rounded-lg
                                             bg-blue-50
                                             text-blue-700
                                             text-sm font-extrabold">

                                    Stock : {{ $stockActuel }}

                                </span>

                            </div>


                            <div class="grid grid-cols-2 gap-3 mt-4">

                                <div class="rounded-lg bg-slate-50 p-3">

                                    <p class="text-xs font-medium text-slate-500">
                                        Prix produit
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-800">

                                        {{ number_format($produit->prix_produit ?? 0, 0, ',', ' ') }}
                                        GNF

                                    </p>

                                </div>


                                <div class="rounded-lg bg-slate-50 p-3">

                                    <label
                                        for="quantite_{{ $produit->id }}"
                                        class="text-xs font-medium text-slate-500"
                                    >
                                        Quantité comptée
                                    </label>

                                    <input
                                        id="quantite_{{ $produit->id }}"
                                        type="number"
                                        min="0"
                                        step="1"

                                        name="produits[{{ $produit->id }}][quantite_reelle]"

                                        value="{{ old(
                                            'produits.' . $produit->id . '.quantite_reelle',
                                            $stockActuel
                                        ) }}"

                                        required

                                        class="mt-1 w-full
                                               rounded-lg
                                               border-slate-300
                                               text-center
                                               font-bold
                                               focus:border-blue-500
                                               focus:ring-blue-500"
                                    >

                                    <input
                                        type="hidden"
                                        name="produits[{{ $produit->id }}][quantite_theorique]"
                                        value="{{ $stockActuel }}"
                                    >

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="p-10 text-center">

                            <div class="text-4xl mb-3">
                                📦
                            </div>

                            <p class="font-bold text-slate-700">
                                Aucun produit disponible
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- =====================================================
                 NOTE
            ====================================================== --}}

            <div class="rounded-xl border border-amber-200
                        bg-amber-50 p-4 mb-6">

                <div class="flex gap-3">

                    <span class="text-xl flex-shrink-0">
                        ⚠️
                    </span>

                    <div>

                        <p class="font-bold text-amber-800">
                            Important
                        </p>

                        <p class="text-sm font-medium text-amber-700 mt-1">

                            La quantité théorique correspond au stock enregistré
                            dans le système. Saisissez uniquement la quantité
                            réellement constatée lors du comptage physique.

                            <strong>
                                La clôture de l'inventaire calculera automatiquement
                                les gains et les pertes.
                            </strong>

                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 BOUTONS
            ====================================================== --}}

            <div class="flex flex-col-reverse sm:flex-row
                        sm:items-center sm:justify-end
                        gap-3">

                <a
                    href="{{ route('inventaire.index') }}"

                    class="inline-flex items-center justify-center
                           px-5 py-2.5
                           rounded-lg
                           border border-slate-300
                           bg-white
                           text-slate-700
                           text-sm font-semibold
                           hover:bg-slate-50
                           transition"
                >

                    Annuler

                </a>


                <button
                    type="submit"

                    class="inline-flex items-center justify-center gap-2
                           px-5 py-2.5
                           rounded-lg
                           bg-blue-600
                           text-white
                           text-sm font-semibold
                           hover:bg-blue-700
                           active:scale-[.98]
                           transition"
                >

                    📋 Enregistrer l'inventaire

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =============================================================
RECHERCHE ALPINE
============================================================= --}}

<script>

function inventaireForm() {

    return {

        search: '',

        matches(nom) {

            if (!this.search.trim()) {
                return true;
            }

            return nom
                .toLowerCase()
                .includes(this.search.toLowerCase().trim());

        }

    }

}

</script>

@endsection
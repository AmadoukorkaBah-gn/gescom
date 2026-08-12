@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50">

```
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                📦 Inventaire
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Comparez le stock théorique avec le stock réellement compté.
            </p>

            @if(isset($inventaire))
                <div class="mt-2 flex flex-wrap items-center gap-2">

                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold">
                        {{ $inventaire->reference }}
                    </span>

                    @if($inventaire->statut === 'brouillon')
                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-amber-50 text-amber-700 text-xs font-semibold">
                            🟡 Brouillon
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-green-50 text-green-700 text-xs font-semibold">
                            ✅ Clôturé
                        </span>
                    @endif

                </div>
            @endif
        </div>

        <div class="flex flex-wrap gap-2">

            <a
                href="{{ route('inventaire.historique') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-700 text-white text-sm font-semibold hover:bg-slate-800 transition"
            >
                📋 Historique
            </a>

            <a
                href="{{ route('inventaire.recapitulatif') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition"
            >
                📊 Récapitulatif
            </a>

        </div>

    </div>


    {{-- =====================================================
         MESSAGE SUCCÈS
    ====================================================== --}}

    @if(session('success'))

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">

            <div class="flex items-center gap-2">
                <span>✅</span>

                <span class="text-sm font-medium">
                    {{ session('success') }}
                </span>
            </div>

        </div>

    @endif


    {{-- =====================================================
         ERREURS
    ====================================================== --}}

    @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">

            <div class="font-semibold mb-2">
                ⚠️ Vérifiez les informations suivantes :
            </div>

            <ul class="list-disc list-inside text-sm space-y-1">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
         FILTRES
    ====================================================== --}}

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">

        <form
            method="GET"
            action="{{ route('inventaire.index') }}"
            class="grid grid-cols-1 md:grid-cols-3 gap-4"
        >

            {{-- Recherche --}}

            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Rechercher
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nom du produit..."
                    class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>


            {{-- Catégorie --}}

            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Catégorie
                </label>

                <select
                    name="categorie_id"
                    class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        Toutes les catégories
                    </option>

                    @foreach($categories as $categorie)

                        <option
                            value="{{ $categorie->id }}"
                            @selected(request('categorie_id') == $categorie->id)
                        >
                            {{ $categorie->nom_categorie }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Boutons --}}

            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-slate-800 text-white font-semibold hover:bg-slate-900 transition"
                >
                    🔎 Rechercher
                </button>

                <a
                    href="{{ route('inventaire.index') }}"
                    class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition"
                >
                    Réinitialiser
                </a>

            </div>

        </form>

    </div>


    {{-- =====================================================
         FORMULAIRE INVENTAIRE
    ====================================================== --}}

    <form
        method="POST"
        action="{{ route('inventaire.enregistrer') }}"
    >

        @csrf


        {{-- =================================================
             VERSION MOBILE
        ================================================== --}}

        <div class="space-y-4 md:hidden">

            @forelse($produits as $produit)

                @php
                    $detail = $details->get($produit->id);

                    $stockTheorique = $detail?->stock_theorique ?? 0;
                    $stockCompte = $detail?->stock_compte ?? $stockTheorique;
                    $ecart = $detail?->ecart ?? 0;
                @endphp

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <h3 class="font-bold text-slate-800 truncate">
                                {{ $produit->nom_produit }}
                            </h3>

                            @if($produit->categorie)

                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $produit->categorie->nom_categorie }}
                                </p>

                            @endif

                        </div>

                        <span class="text-xs px-2 py-1 rounded-lg bg-blue-50 text-blue-700 font-semibold">
                            Stock
                        </span>

                    </div>


                    <div class="grid grid-cols-2 gap-3 mt-4">

                        {{-- Stock théorique --}}

                        <div class="rounded-xl bg-slate-50 p-3">

                            <p class="text-xs text-slate-500">
                                Stock théorique
                            </p>

                            <p class="text-lg font-bold text-slate-800">
                                {{ number_format((float) $stockTheorique, 0, ',', ' ') }}
                            </p>

                        </div>


                        {{-- Stock compté --}}

                        <div class="rounded-xl bg-blue-50 p-3">

                            <label class="text-xs text-blue-700 font-semibold">
                                Stock réel compté
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                name="quantites[{{ $produit->id }}]"
                                value="{{ old('quantites.' . $produit->id, $stockCompte) }}"
                                class="mt-1 w-full rounded-lg border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-center font-bold"
                                @disabled(isset($inventaire) && $inventaire->estCloture())
                            >

                        </div>

                    </div>


                    {{-- Écart --}}

                    <div class="mt-3 rounded-xl p-3
                        {{ $ecart > 0
                            ? 'bg-green-50 text-green-700'
                            : ($ecart < 0
                                ? 'bg-red-50 text-red-700'
                                : 'bg-slate-50 text-slate-600')
                        }}
                    ">

                        <div class="flex items-center justify-between">

                            <span class="text-xs font-semibold">
                                Écart
                            </span>

                            <span class="font-bold">
                                {{ $ecart > 0 ? '+' : '' }}{{ number_format((float) $ecart, 0, ',', ' ') }}
                            </span>

                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center">

                    <div class="text-4xl mb-3">
                        📦
                    </div>

                    <p class="font-semibold text-slate-700">
                        Aucun produit trouvé
                    </p>

                    <p class="text-sm text-slate-500 mt-1">
                        Modifiez vos critères de recherche.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- =================================================
             VERSION DESKTOP
        ================================================== --}}

        <div class="hidden md:block bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Produit
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Catégorie
                            </th>

                            <th class="px-5 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Stock théorique
                            </th>

                            <th class="px-5 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Stock réel
                            </th>

                            <th class="px-5 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Écart
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($produits as $produit)

                            @php
                                $detail = $details->get($produit->id);

                                $stockTheorique = $detail?->stock_theorique ?? 0;
                                $stockCompte = $detail?->stock_compte ?? $stockTheorique;
                                $ecart = $detail?->ecart ?? 0;
                            @endphp

                            <tr class="hover:bg-slate-50 transition">

                                {{-- Produit --}}

                                <td class="px-5 py-4">

                                    <div class="font-semibold text-slate-800">
                                        {{ $produit->nom_produit }}
                                    </div>

                                    @if($produit->fournisseur)

                                        <div class="text-xs text-slate-400 mt-1">
                                            {{ $produit->fournisseur->nom }}
                                        </div>

                                    @endif

                                </td>


                                {{-- Catégorie --}}

                                <td class="px-5 py-4 text-sm text-slate-600">

                                    {{ $produit->categorie?->nom_categorie ?? '—' }}

                                </td>


                                {{-- Stock théorique --}}

                                <td class="px-5 py-4 text-center">

                                    <span class="inline-flex items-center justify-center min-w-[80px] px-3 py-2 rounded-lg bg-slate-100 text-slate-800 font-bold">

                                        {{ number_format((float) $stockTheorique, 0, ',', ' ') }}

                                    </span>

                                </td>


                                {{-- Stock réel --}}

                                <td class="px-5 py-4">

                                    <input
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        name="quantites[{{ $produit->id }}]"
                                        value="{{ old('quantites.' . $produit->id, $stockCompte) }}"
                                        class="w-32 mx-auto block text-center rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 font-bold"
                                        @disabled(isset($inventaire) && $inventaire->estCloture())
                                    >

                                </td>


                                {{-- Écart --}}

                                <td class="px-5 py-4 text-center">

                                    @if($ecart > 0)

                                        <span class="inline-flex items-center justify-center min-w-[70px] px-3 py-2 rounded-lg bg-green-50 text-green-700 font-bold">
                                            +{{ number_format((float) $ecart, 0, ',', ' ') }}
                                        </span>

                                    @elseif($ecart < 0)

                                        <span class="inline-flex items-center justify-center min-w-[70px] px-3 py-2 rounded-lg bg-red-50 text-red-700 font-bold">
                                            {{ number_format((float) $ecart, 0, ',', ' ') }}
                                        </span>

                                    @else

                                        <span class="inline-flex items-center justify-center min-w-[70px] px-3 py-2 rounded-lg bg-slate-100 text-slate-500 font-bold">
                                            0
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-5 py-12 text-center"
                                >

                                    <div class="text-4xl mb-3">
                                        📦
                                    </div>

                                    <p class="font-semibold text-slate-700">
                                        Aucun produit trouvé
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Modifiez vos critères de recherche.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}

            @if($produits->hasPages())

                <div class="px-5 py-4 border-t border-slate-200">

                    {{ $produits->links() }}

                </div>

            @endif

        </div>


        {{-- =================================================
             BOUTONS
        ================================================== --}}

        @if($produits->count())

            <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div class="text-sm text-slate-500">

                    💡 Vérifiez les quantités physiques avant d'enregistrer.

                </div>


                @if(!isset($inventaire) || !$inventaire->estCloture())

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-bold shadow-sm hover:bg-blue-700 active:scale-[0.98] transition"
                    >
                        💾 Enregistrer l'inventaire
                    </button>

                @endif

            </div>

        @endif

    </form>

</div>


</div>

@endsection

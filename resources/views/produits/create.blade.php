@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-3 py-5 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-5xl">

        <!-- En-tête -->
        <div class="mb-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900">
                        Ajouter un produit
                    </h1>

                    <p class="mt-1 text-sm sm:text-base text-gray-500">
                        Enregistrez les informations du nouveau produit.
                    </p>
                </div>

                <a href="{{ route('produits.index') }}"
                   class="inline-flex w-full sm:w-auto items-center justify-center rounded-xl
                          border border-gray-300 bg-white px-4 py-2.5
                          text-sm font-semibold text-gray-700
                          shadow-sm transition
                          hover:bg-gray-50 hover:text-gray-900">

                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>

            </div>
        </div>


        <!-- Erreurs -->
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>

                    <div class="min-w-0">
                        <h3 class="text-sm font-bold text-red-800">
                            Veuillez corriger les erreurs suivantes :
                        </h3>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            </div>
        @endif


        <!-- Formulaire -->
        <form action="{{ route('produits.store') }}"
              method="POST"
              class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            @csrf


            <!-- Informations générales -->
            <div class="border-b border-gray-200 px-4 py-5 sm:px-6">

                <div class="mb-5 flex items-center gap-3">

                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100">
                        <i class="fas fa-box text-blue-600"></i>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Informations du produit
                        </h2>

                        <p class="text-sm text-gray-500">
                            Renseignez les informations principales.
                        </p>
                    </div>

                </div>


                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">


                    <!-- Nom -->
                    <div>
                        <label for="nom_produit"
                               class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Nom du produit
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="nom_produit"
                            id="nom_produit"
                            value="{{ old('nom_produit') }}"
                            class="block w-full rounded-xl border border-gray-300 bg-white
                                   px-3.5 py-3 text-sm text-gray-900
                                   outline-none transition
                                   placeholder:text-gray-400
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            placeholder="Ex. Coca-Cola 33cl"
                            required
                        >
                    </div>


                    <!-- Catégorie -->
                    <div>
                        <label for="categorie_id"
                               class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Catégorie
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="categorie_id"
                            id="categorie_id"
                            class="block w-full rounded-xl border border-gray-300 bg-white
                                   px-3.5 py-3 text-sm text-gray-900
                                   outline-none transition
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            required
                        >
                            <option value="">-- Choisir --</option>

                            @foreach($categories as $categorie)
                                <option
                                    value="{{ $categorie->id }}"
                                    {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}
                                >
                                    {{ $categorie->nom_categorie }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Fournisseur -->
                    <div>
                        <label for="fournisseur_id"
                               class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Fournisseur
                            <span class="font-normal text-gray-400">(optionnel)</span>
                        </label>

                        <select
                            name="fournisseur_id"
                            id="fournisseur_id"
                            class="block w-full rounded-xl border border-gray-300 bg-white
                                   px-3.5 py-3 text-sm text-gray-900
                                   outline-none transition
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="">-- Aucun fournisseur --</option>

                            @foreach($fournisseurs as $fournisseur)
                                <option
                                    value="{{ $fournisseur->id }}"
                                    {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}
                                >
                                    {{ $fournisseur->nom_fournisseur }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Quantité -->
                    <div>
                        <label for="quantite_initiale"
                               class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Quantité en stock
                            <span class="font-normal text-gray-400">(optionnel)</span>
                        </label>

                        <input
                            type="number"
                            name="quantite_initiale"
                            id="quantite_initiale"
                            min="0"
                            value="{{ old('quantite_initiale', 0) }}"
                            class="block w-full rounded-xl border border-gray-300 bg-white
                                   px-3.5 py-3 text-sm text-gray-900
                                   outline-none transition
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                        <p class="mt-1.5 text-xs text-gray-500">
                            Laissez à 0 si vous comptez plutôt passer par un achat fournisseur.
                        </p>
                    </div>


                    <!-- Date péremption -->
                    <div>
                        <label for="date_peremption"
                               class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Date de péremption
                            <span class="font-normal text-gray-400">(optionnelle)</span>
                        </label>

                        <input
                            type="date"
                            name="date_peremption"
                            id="date_peremption"
                            value="{{ old('date_peremption') }}"
                            class="block w-full rounded-xl border border-gray-300 bg-white
                                   px-3.5 py-3 text-sm text-gray-900
                                   outline-none transition
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                        <p class="mt-1.5 text-xs text-gray-500">
                            Laissez vide pour les produits sans date de péremption.
                        </p>
                    </div>

                </div>
            </div>


            <!-- Prix et stock -->
            <div class="border-b border-gray-200 px-4 py-5 sm:px-6">

                <div class="mb-5 flex items-center gap-3">

                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-green-100">
                        <i class="fas fa-coins text-green-600"></i>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Prix et gestion du stock
                        </h2>

                        <p class="text-sm text-gray-500">
                            Définissez les prix et le niveau minimum du stock.
                        </p>
                    </div>

                </div>


                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">


                    <!-- Prix achat -->
                    <div>
                        <label for="prix_produit"
                               class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Prix d'achat
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">
                            <input
                                type="number"
                                step="0.01"
                                name="prix_produit"
                                id="prix_produit"
                                value="{{ old('prix_produit') }}"
                                class="block w-full rounded-xl border border-gray-300 bg-white
                                       px-3.5 py-3 pr-16 text-sm text-gray-900
                                       outline-none transition
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="0"
                                required
                            >

                            <span class="absolute inset-y-0 right-3 flex items-center text-xs font-semibold text-gray-400">
                                GNF
                            </span>
                        </div>
                    </div>


                    <!-- Prix vente -->
                    <div>
                        <label for="prix_vente"
                               class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Prix de vente
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">
                            <input
                                type="number"
                                step="0.01"
                                name="prix_vente"
                                id="prix_vente"
                                value="{{ old('prix_vente') }}"
                                class="block w-full rounded-xl border border-gray-300 bg-white
                                       px-3.5 py-3 pr-16 text-sm text-gray-900
                                       outline-none transition
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="0"
                                required
                            >

                            <span class="absolute inset-y-0 right-3 flex items-center text-xs font-semibold text-gray-400">
                                GNF
                            </span>
                        </div>
                    </div>


                    <!-- Stock minimum -->
                    <div>
                        <label for="stock_minimum"
                               class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Stock minimum
                        </label>

                        <input
                            type="number"
                            name="stock_minimum"
                            id="stock_minimum"
                            min="0"
                            value="{{ old('stock_minimum', 0) }}"
                            class="block w-full rounded-xl border border-gray-300 bg-white
                                   px-3.5 py-3 text-sm text-gray-900
                                   outline-none transition
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                </div>
            </div>


            <!-- Statut -->
            <div class="px-4 py-5 sm:px-6">

                <div class="max-w-md">

                    <label for="statut"
                           class="mb-1.5 block text-sm font-semibold text-gray-700">
                        Statut
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="statut"
                        id="statut"
                        required
                        class="block w-full rounded-xl border border-gray-300 bg-white
                               px-3.5 py-3 text-sm text-gray-900
                               outline-none transition
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="1" {{ old('statut', '1') == '1' ? 'selected' : '' }}>
                            Actif
                        </option>

                        <option value="0" {{ old('statut') === '0' ? 'selected' : '' }}>
                            Inactif
                        </option>
                    </select>

                </div>

            </div>


            <!-- Boutons -->
            <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50
                        px-4 py-5 sm:flex-row sm:justify-end sm:px-6">

                <a
                    href="{{ route('produits.index') }}"
                    class="inline-flex w-full items-center justify-center rounded-xl
                           border border-gray-300 bg-white px-5 py-3
                           text-sm font-semibold text-gray-700
                           shadow-sm transition
                           hover:bg-gray-100
                           sm:w-auto"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-xl
                           bg-blue-600 px-5 py-3
                           text-sm font-bold text-white
                           shadow-sm transition
                           hover:bg-blue-700
                           focus:outline-none focus:ring-2
                           focus:ring-blue-500 focus:ring-offset-2
                           sm:w-auto"
                >
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer le produit
                </button>

            </div>

        </form>

    </div>
</div>
@endsection
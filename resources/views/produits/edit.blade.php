@extends('layouts.app')

@section('content')

<div class="w-full px-3 sm:px-5 lg:px-8 py-5 sm:py-7">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-800 tracking-tight">
                    Modifier le Produit
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Modifiez les informations du produit ci-dessous.
                </p>
            </div>

            <a href="{{ route('produits.index') }}"
               class="inline-flex items-center justify-center gap-2
                      w-full sm:w-auto
                      px-4 py-2.5
                      bg-gray-100 hover:bg-gray-200
                      text-gray-700 font-semibold text-sm
                      rounded-xl
                      border border-gray-200
                      transition duration-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-4 h-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 19l-7-7 7-7"/>
                </svg>

                Retour aux produits
            </a>

        </div>
    </div>


    {{-- =========================================================
         CARTE FORMULAIRE
    ========================================================== --}}
    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête du formulaire --}}
            <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5 bg-gradient-to-r from-blue-600 to-blue-500">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-white/20
                                flex items-center justify-center
                                flex-shrink-0">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 text-white"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                     M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>

                    </div>

                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-white">
                            Informations du produit
                        </h2>

                        <p class="text-xs sm:text-sm text-blue-100">
                            Mettez à jour les informations nécessaires
                        </p>
                    </div>

                </div>

            </div>


            {{-- =====================================================
                 FORMULAIRE
            ====================================================== --}}
            <form method="POST"
                  action="{{ route('produits.update', $produit) }}"
                  class="p-4 sm:p-6 lg:p-8">

                @csrf
                @method('PUT')


                {{-- =================================================
                     INFORMATIONS GÉNÉRALES
                ================================================== --}}
                <div class="mb-7">

                    <div class="flex items-center gap-2 mb-4">

                        <div class="w-1 h-5 bg-blue-600 rounded-full"></div>

                        <h3 class="text-base sm:text-lg font-bold text-gray-800">
                            Informations générales
                        </h3>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                        {{-- Nom --}}
                        <div>
                            <label for="nom_produit"
                                   class="block text-sm font-semibold text-gray-700 mb-1.5">

                                Nom du produit
                                <span class="text-red-500">*</span>

                            </label>

                            <input type="text"
                                   name="nom_produit"
                                   id="nom_produit"
                                   value="{{ old('nom_produit', $produit->nom_produit) }}"
                                   class="w-full px-4 py-2.5
                                          bg-gray-50
                                          border border-gray-300
                                          rounded-xl
                                          text-sm text-gray-800
                                          placeholder-gray-400
                                          focus:bg-white
                                          focus:border-blue-500
                                          focus:ring-2
                                          focus:ring-blue-100
                                          outline-none
                                          transition
                                          @error('nom_produit') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                                   required>

                            @error('nom_produit')
                                <p class="mt-1.5 text-xs font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Catégorie --}}
                        <div>
                            <label for="categorie_id"
                                   class="block text-sm font-semibold text-gray-700 mb-1.5">

                                Catégorie
                                <span class="text-red-500">*</span>

                            </label>

                            <select name="categorie_id"
                                    id="categorie_id"
                                    class="w-full px-4 py-2.5
                                           bg-gray-50
                                           border border-gray-300
                                           rounded-xl
                                           text-sm text-gray-800
                                           focus:bg-white
                                           focus:border-blue-500
                                           focus:ring-2
                                           focus:ring-blue-100
                                           outline-none
                                           transition
                                           @error('categorie_id') border-red-500 @enderror"
                                    required>

                                <option value="">
                                    Sélectionner une catégorie
                                </option>

                                @foreach($categories as $categorie)

                                    <option value="{{ $categorie->id }}"
                                        {{ old('categorie_id', $produit->categorie_id) == $categorie->id ? 'selected' : '' }}>

                                        {{ $categorie->nom_categorie }}

                                    </option>

                                @endforeach

                            </select>

                            @error('categorie_id')
                                <p class="mt-1.5 text-xs font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Fournisseur --}}
                        <div>
                            <label for="fournisseur_id"
                                   class="block text-sm font-semibold text-gray-700 mb-1.5">

                                Fournisseur
                                <span class="text-red-500">*</span>

                            </label>

                            <select name="fournisseur_id"
                                    id="fournisseur_id"
                                    class="w-full px-4 py-2.5
                                           bg-gray-50
                                           border border-gray-300
                                           rounded-xl
                                           text-sm text-gray-800
                                           focus:bg-white
                                           focus:border-blue-500
                                           focus:ring-2
                                           focus:ring-blue-100
                                           outline-none
                                           transition
                                           @error('fournisseur_id') border-red-500 @enderror"
                                    required>

                                <option value="">
                                    Sélectionner un fournisseur
                                </option>

                                @foreach($fournisseurs as $fournisseur)

                                    <option value="{{ $fournisseur->id }}"
                                        {{ old('fournisseur_id', $produit->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>

                                        {{ $fournisseur->nom_fournisseur }}

                                    </option>

                                @endforeach

                            </select>

                            @error('fournisseur_id')
                                <p class="mt-1.5 text-xs font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Statut --}}
                        <div>
                            <label for="statut"
                                   class="block text-sm font-semibold text-gray-700 mb-1.5">

                                Statut
                                <span class="text-red-500">*</span>

                            </label>

                            <select name="statut"
                                    id="statut"
                                    class="w-full px-4 py-2.5
                                           bg-gray-50
                                           border border-gray-300
                                           rounded-xl
                                           text-sm text-gray-800
                                           focus:bg-white
                                           focus:border-blue-500
                                           focus:ring-2
                                           focus:ring-blue-100
                                           outline-none
                                           transition
                                           @error('statut') border-red-500 @enderror"
                                    required>

                                <option value="actif"
                                    {{ old('statut', $produit->statut ? 'actif' : 'inactif') == 'actif' ? 'selected' : '' }}>
                                    Actif
                                </option>

                                <option value="inactif"
                                    {{ old('statut', $produit->statut ? 'actif' : 'inactif') == 'inactif' ? 'selected' : '' }}>
                                    Inactif
                                </option>

                            </select>

                            @error('statut')
                                <p class="mt-1.5 text-xs font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     INFORMATIONS FINANCIÈRES
                ================================================== --}}
                <div class="mb-7">

                    <div class="flex items-center gap-2 mb-4">

                        <div class="w-1 h-5 bg-green-600 rounded-full"></div>

                        <h3 class="text-base sm:text-lg font-bold text-gray-800">
                            Informations financières
                        </h3>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                        {{-- Prix achat --}}
                        <div>

                            <label for="prix_produit"
                                   class="block text-sm font-semibold text-gray-700 mb-1.5">

                                Prix d'achat
                                <span class="text-red-500">*</span>

                            </label>

                            <div class="relative">

                                <input type="number"
                                       step="0.01"
                                       name="prix_produit"
                                       id="prix_produit"
                                       value="{{ old('prix_produit', $produit->prix_produit) }}"
                                       class="w-full px-4 py-2.5 pr-16
                                              bg-gray-50
                                              border border-gray-300
                                              rounded-xl
                                              text-sm text-gray-800
                                              focus:bg-white
                                              focus:border-blue-500
                                              focus:ring-2
                                              focus:ring-blue-100
                                              outline-none
                                              transition
                                              @error('prix_produit') border-red-500 @enderror"
                                       required>

                                <span class="absolute right-4 top-1/2 -translate-y-1/2
                                             text-xs font-semibold text-gray-400">
                                    GNF
                                </span>

                            </div>

                            @error('prix_produit')
                                <p class="mt-1.5 text-xs font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Prix vente --}}
                        <div>

                            <label for="prix_vente"
                                   class="block text-sm font-semibold text-gray-700 mb-1.5">

                                Prix de vente
                                <span class="text-red-500">*</span>

                            </label>

                            <div class="relative">

                                <input type="number"
                                       step="0.01"
                                       name="prix_vente"
                                       id="prix_vente"
                                       value="{{ old('prix_vente', $produit->prix_vente) }}"
                                       class="w-full px-4 py-2.5 pr-16
                                              bg-gray-50
                                              border border-gray-300
                                              rounded-xl
                                              text-sm text-gray-800
                                              focus:bg-white
                                              focus:border-blue-500
                                              focus:ring-2
                                              focus:ring-blue-100
                                              outline-none
                                              transition
                                              @error('prix_vente') border-red-500 @enderror"
                                       required>

                                <span class="absolute right-4 top-1/2 -translate-y-1/2
                                             text-xs font-semibold text-gray-400">
                                    GNF
                                </span>

                            </div>

                            @error('prix_vente')
                                <p class="mt-1.5 text-xs font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     GESTION DU STOCK
                ================================================== --}}
                <div class="mb-7">

                    <div class="flex items-center gap-2 mb-4">

                        <div class="w-1 h-5 bg-orange-500 rounded-full"></div>

                        <h3 class="text-base sm:text-lg font-bold text-gray-800">
                            Gestion du stock
                        </h3>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                        {{-- Stock minimum --}}
                        <div>

                            <label for="stock_minimum"
                                   class="block text-sm font-semibold text-gray-700 mb-1.5">

                                Stock minimum
                                <span class="text-red-500">*</span>

                            </label>

                            <input type="number"
                                   name="stock_minimum"
                                   id="stock_minimum"
                                   value="{{ old('stock_minimum', $produit->stock_minimum) }}"
                                   class="w-full px-4 py-2.5
                                          bg-gray-50
                                          border border-gray-300
                                          rounded-xl
                                          text-sm text-gray-800
                                          focus:bg-white
                                          focus:border-blue-500
                                          focus:ring-2
                                          focus:ring-blue-100
                                          outline-none
                                          transition
                                          @error('stock_minimum') border-red-500 @enderror"
                                   required>

                            <p class="mt-1.5 text-xs text-gray-400">
                                Une alerte sera affichée lorsque le stock passe sous cette valeur.
                            </p>

                            @error('stock_minimum')
                                <p class="mt-1.5 text-xs font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Stock actuel --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Stock actuel
                            </label>

                            <div class="w-full px-4 py-2.5
                                        bg-gray-100
                                        border border-gray-200
                                        rounded-xl
                                        text-sm font-bold text-gray-700">

                                {{ $produit->stockActuel() }}

                                <span class="font-normal text-gray-400 ml-1">
                                    unité(s)
                                </span>

                            </div>

                            <p class="mt-1.5 text-xs text-gray-400">
                                Le stock actuel est calculé automatiquement.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     BOUTONS
                ================================================== --}}
                <div class="pt-5 border-t border-gray-100">

                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                        <a href="{{ route('produits.index') }}"
                           class="w-full sm:w-auto
                                  inline-flex items-center justify-center
                                  px-5 py-2.5
                                  bg-gray-100 hover:bg-gray-200
                                  text-gray-700
                                  font-semibold text-sm
                                  rounded-xl
                                  border border-gray-200
                                  transition duration-200">

                            Annuler

                        </a>


                        <button type="submit"
                                class="w-full sm:w-auto
                                       inline-flex items-center justify-center gap-2
                                       px-5 py-2.5
                                       bg-blue-600 hover:bg-blue-700
                                       text-white
                                       font-semibold text-sm
                                       rounded-xl
                                       shadow-sm
                                       hover:shadow
                                       transition duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-4 h-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>

                            Mettre à jour

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
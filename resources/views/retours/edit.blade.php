@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50 py-6 sm:py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-2xl mx-auto">

        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}
        <div class="mb-6 sm:mb-8">

            <div class="flex items-center gap-3 mb-2">

                <div class="flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center
                            rounded-xl bg-amber-100 text-amber-600
                            text-lg sm:text-xl shadow-sm">
                    ↻
                </div>

                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl
                               font-bold tracking-tight text-slate-800">
                        Modifier un retour
                    </h1>

                    <p class="mt-1 text-xs sm:text-sm text-slate-500">
                        Modifiez les informations du retour de marchandise.
                    </p>
                </div>

            </div>

        </div>


        {{-- =========================================================
             FORMULAIRE
        ========================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm
                    border border-slate-200 overflow-hidden">

            {{-- En-tête du formulaire --}}
            <div class="px-5 sm:px-7 py-4 sm:py-5
                        border-b border-slate-200
                        bg-slate-50/70">

                <h2 class="text-base sm:text-lg font-bold text-slate-800">
                    Informations du retour
                </h2>

                <p class="mt-1 text-xs sm:text-sm text-slate-500">
                    Vérifiez les informations avant d'enregistrer les modifications.
                </p>

            </div>


            <form
                action="{{ route('retours.update', $retour->id) }}"
                method="POST"
                class="p-5 sm:p-7 space-y-5 sm:space-y-6"
            >

                @csrf
                @method('PUT')


                {{-- =====================================================
                     VENTE
                ====================================================== --}}
                <div>

                    <label
                        for="vente_id"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Vente
                    </label>

                    <select
                        id="vente_id"
                        name="vente_id"
                        required
                        class="w-full rounded-xl
                               border border-slate-300
                               bg-white
                               px-3.5 py-3
                               text-sm sm:text-base
                               text-slate-700
                               shadow-sm
                               transition
                               focus:border-blue-500
                               focus:ring-2
                               focus:ring-blue-500/20
                               focus:outline-none"
                    >

                        @foreach($ventes as $vente)

                            <option
                                value="{{ $vente->id }}"
                                {{ $retour->vente_id == $vente->id ? 'selected' : '' }}
                            >
                                Vente #{{ $vente->id }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- =====================================================
                     PRODUIT
                ====================================================== --}}
                <div>

                    <label
                        for="produit_id"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Produit
                    </label>

                    <select
                        id="produit_id"
                        name="produit_id"
                        required
                        class="w-full rounded-xl
                               border border-slate-300
                               bg-white
                               px-3.5 py-3
                               text-sm sm:text-base
                               text-slate-700
                               shadow-sm
                               transition
                               focus:border-blue-500
                               focus:ring-2
                               focus:ring-blue-500/20
                               focus:outline-none"
                    >

                        @foreach($produits as $produit)

                            <option
                                value="{{ $produit->id }}"
                                {{ $retour->produit_id == $produit->id ? 'selected' : '' }}
                            >
                                {{ $produit->nom_produit }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- =====================================================
                     QUANTITÉ
                ====================================================== --}}
                <div>

                    <label
                        for="quantite"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Quantité
                    </label>

                    <input
                        type="number"
                        id="quantite"
                        name="quantite"
                        value="{{ $retour->quantite }}"
                        required
                        min="1"
                        class="w-full rounded-xl
                               border border-slate-300
                               bg-white
                               px-3.5 py-3
                               text-sm sm:text-base
                               font-medium text-slate-700
                               shadow-sm
                               transition
                               focus:border-blue-500
                               focus:ring-2
                               focus:ring-blue-500/20
                               focus:outline-none"
                    >

                </div>


                {{-- =====================================================
                     RAISON
                ====================================================== --}}
                <div>

                    <label
                        for="raison"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Raison du retour
                    </label>

                    <input
                        type="text"
                        id="raison"
                        name="raison"
                        value="{{ $retour->raison }}"
                        required
                        placeholder="Ex. Produit défectueux, erreur de commande..."
                        class="w-full rounded-xl
                               border border-slate-300
                               bg-white
                               px-3.5 py-3
                               text-sm sm:text-base
                               text-slate-700
                               shadow-sm
                               transition
                               placeholder:text-slate-400
                               focus:border-blue-500
                               focus:ring-2
                               focus:ring-blue-500/20
                               focus:outline-none"
                    >

                </div>


                {{-- =====================================================
                     ACTIONS
                ====================================================== --}}
                <div class="pt-3 sm:pt-4
                            border-t border-slate-200
                            flex flex-col-reverse sm:flex-row
                            gap-3 sm:justify-end">

                    <a
                        href="{{ route('retours.index') }}"
                        class="w-full sm:w-auto
                               inline-flex items-center justify-center
                               px-5 py-3
                               rounded-xl
                               border border-slate-300
                               bg-white
                               text-slate-700
                               text-sm font-semibold
                               shadow-sm
                               hover:bg-slate-50
                               transition"
                    >
                        Annuler
                    </a>


                    <button
                        type="submit"
                        class="w-full sm:w-auto
                               inline-flex items-center justify-center gap-2
                               px-5 py-3
                               rounded-xl
                               bg-amber-500
                               text-white
                               text-sm font-semibold
                               shadow-sm
                               hover:bg-amber-600
                               active:scale-[0.98]
                               transition"
                    >

                        <span>✓</span>

                        Mettre à jour

                    </button>

                </div>

            </form>

        </div>


        {{-- =========================================================
             INFORMATION
        ========================================================== --}}
        <div class="mt-5 rounded-xl
                    border border-blue-100
                    bg-blue-50
                    px-4 sm:px-5 py-3.5">

            <div class="flex gap-3">

                <span class="flex-shrink-0 text-blue-600 text-lg">
                    ℹ
                </span>

                <p class="text-xs sm:text-sm leading-5 text-blue-700">
                    Vérifiez attentivement la vente, le produit et la quantité
                    avant de valider la modification du retour.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection
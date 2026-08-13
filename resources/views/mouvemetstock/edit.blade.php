@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8">

    <div class="max-w-5xl mx-auto">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}
        <div class="mb-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                        Modifier le Mouvement
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Modifiez les informations du mouvement de stock.
                    </p>
                </div>

                <a
                    href="{{ route('mouvement.index') }}"
                    class="
                        inline-flex items-center justify-center
                        gap-2
                        w-full sm:w-auto
                        px-4 py-2.5
                        bg-white
                        border border-gray-300
                        text-gray-700
                        rounded-xl
                        font-semibold
                        text-sm
                        shadow-sm
                        hover:bg-gray-50
                        hover:border-gray-400
                        transition
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"
                        />
                    </svg>

                    Retour à la liste
                </a>

            </div>

        </div>


        {{-- =====================================================
             FORMULAIRE
        ====================================================== --}}
        <form
            action="{{ route('mouvement.update', $mouvement) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div
                class="
                    bg-white
                    rounded-2xl
                    shadow-sm
                    border border-gray-200
                    overflow-hidden
                "
            >

                {{-- =================================================
                     TITRE DU FORMULAIRE
                ================================================== --}}
                <div class="px-4 sm:px-6 lg:px-8 py-5 border-b border-gray-200">

                    <div class="flex items-center gap-3">

                        <div
                            class="
                                w-10 h-10
                                sm:w-11 sm:h-11
                                rounded-xl
                                bg-blue-100
                                text-blue-600
                                flex items-center justify-center
                                flex-shrink-0
                            "
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 sm:w-6 sm:h-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-800">
                                Informations du mouvement
                            </h2>

                            <p class="text-sm text-gray-500 mt-0.5">
                                Mettez à jour les informations ci-dessous.
                            </p>
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     CONTENU
                ================================================== --}}
                <div class="p-4 sm:p-6 lg:p-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">


                        {{-- PRODUIT --}}
                        <div>

                            <label
                                for="produit_id"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Produit
                            </label>

                            <select
                                name="produit_id"
                                id="produit_id"
                                class="
                                    w-full
                                    min-h-[46px]
                                    px-3.5
                                    py-2.5
                                    bg-white
                                    border border-gray-300
                                    rounded-xl
                                    text-sm sm:text-base
                                    text-gray-800
                                    shadow-sm
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-blue-500
                                    focus:border-blue-500
                                    transition
                                "
                                required
                            >

                                @foreach(\App\Models\Produit::all() as $p)

                                    <option
                                        value="{{ $p->id }}"
                                        {{ $mouvement->produit_id == $p->id ? 'selected' : '' }}
                                    >
                                        {{ $p->nom_produit }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- TYPE --}}
                        <div>

                            <label
                                for="type_mouvement"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Type de mouvement
                            </label>

                            <select
                                name="type_mouvement"
                                id="type_mouvement"
                                class="
                                    w-full
                                    min-h-[46px]
                                    px-3.5
                                    py-2.5
                                    bg-white
                                    border border-gray-300
                                    rounded-xl
                                    text-sm sm:text-base
                                    text-gray-800
                                    shadow-sm
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-blue-500
                                    focus:border-blue-500
                                    transition
                                "
                                required
                            >

                                <option
                                    value="entree"
                                    {{ $mouvement->type_mouvement == 'entree' ? 'selected' : '' }}
                                >
                                    Entrée
                                </option>

                                <option
                                    value="sortie"
                                    {{ $mouvement->type_mouvement == 'sortie' ? 'selected' : '' }}
                                >
                                    Sortie
                                </option>

                            </select>

                        </div>


                        {{-- QUANTITÉ --}}
                        <div>

                            <label
                                for="quantite"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Quantité
                            </label>

                            <input
                                type="number"
                                name="quantite"
                                id="quantite"
                                value="{{ $mouvement->quantite }}"
                                min="1"
                                class="
                                    w-full
                                    min-h-[46px]
                                    px-3.5
                                    py-2.5
                                    bg-white
                                    border border-gray-300
                                    rounded-xl
                                    text-sm sm:text-base
                                    text-gray-800
                                    shadow-sm
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-blue-500
                                    focus:border-blue-500
                                    transition
                                "
                                required
                            >

                        </div>


                        {{-- RAISON --}}
                        <div>

                            <label
                                for="raison"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Raison
                            </label>

                            <select
                                name="raison"
                                id="raison"
                                class="
                                    w-full
                                    min-h-[46px]
                                    px-3.5
                                    py-2.5
                                    bg-white
                                    border border-gray-300
                                    rounded-xl
                                    text-sm sm:text-base
                                    text-gray-800
                                    shadow-sm
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-blue-500
                                    focus:border-blue-500
                                    transition
                                "
                                required
                            >

                                <option
                                    value="achat"
                                    {{ $mouvement->raison == 'achat' ? 'selected' : '' }}
                                >
                                    Achat
                                </option>

                                <option
                                    value="vente"
                                    {{ $mouvement->raison == 'vente' ? 'selected' : '' }}
                                >
                                    Vente
                                </option>

                                <option
                                    value="retour"
                                    {{ $mouvement->raison == 'retour' ? 'selected' : '' }}
                                >
                                    Retour
                                </option>

                            </select>

                        </div>


                        {{-- DATE --}}
                        <div class="md:col-span-2">

                            <label
                                for="date_mouvement"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Date du mouvement
                            </label>

                            <input
                                type="datetime-local"
                                name="date_mouvement"
                                id="date_mouvement"
                                value="{{ $mouvement->date_mouvement ? $mouvement->date_mouvement->format('Y-m-d\TH:i') : '' }}"
                                class="
                                    w-full
                                    min-h-[46px]
                                    px-3.5
                                    py-2.5
                                    bg-white
                                    border border-gray-300
                                    rounded-xl
                                    text-sm sm:text-base
                                    text-gray-800
                                    shadow-sm
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-blue-500
                                    focus:border-blue-500
                                    transition
                                "
                                required
                            >

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     FOOTER / BOUTONS
                ================================================== --}}
                <div
                    class="
                        px-4 sm:px-6 lg:px-8
                        py-4 sm:py-5
                        bg-gray-50
                        border-t border-gray-200
                    "
                >

                    <div
                        class="
                            flex
                            flex-col-reverse
                            sm:flex-row
                            sm:justify-end
                            gap-3
                        "
                    >

                        <a
                            href="{{ route('mouvement.index') }}"
                            class="
                                w-full sm:w-auto
                                inline-flex
                                items-center
                                justify-center
                                gap-2
                                px-5 py-2.5
                                bg-white
                                border border-gray-300
                                text-gray-700
                                rounded-xl
                                font-semibold
                                text-sm
                                hover:bg-gray-100
                                transition
                            "
                        >
                            Annuler
                        </a>

                        <button
                            type="submit"
                            class="
                                w-full sm:w-auto
                                inline-flex
                                items-center
                                justify-center
                                gap-2
                                px-5 py-2.5
                                bg-blue-600
                                hover:bg-blue-700
                                text-white
                                rounded-xl
                                font-semibold
                                text-sm
                                shadow-sm
                                hover:shadow
                                transition
                            "
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            Mettre à jour

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
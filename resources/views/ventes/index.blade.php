@extends('layouts.app')

@section('content')

<div class="w-full max-w-7xl mx-auto px-3 sm:px-5 lg:px-8 pb-8 sm:pb-10">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                Ventes
            </h1>

            <p class="text-sm sm:text-base text-gray-500 mt-1">
                {{ $ventes->total() ?? $ventes->count() }} vente(s) enregistrée(s)
            </p>
        </div>


        {{-- ACTIONS --}}

        <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 w-full lg:w-auto">

            {{-- PDF --}}
            <a
                href="{{ route('ventes.export.pdf') }}"
                class="inline-flex items-center justify-center gap-1.5
                       border border-gray-300 bg-white
                       text-gray-700 hover:bg-gray-50
                       text-sm font-medium
                       px-3 py-2.5 rounded-xl
                       transition shadow-sm"
            >
                <svg
                    class="w-4 h-4 text-red-500 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2"
                    />
                </svg>

                <span>PDF</span>
            </a>


            {{-- EXCEL --}}
            <a
                href="{{ route('ventes.export.excel') }}"
                class="inline-flex items-center justify-center gap-1.5
                       border border-gray-300 bg-white
                       text-gray-700 hover:bg-gray-50
                       text-sm font-medium
                       px-3 py-2.5 rounded-xl
                       transition shadow-sm"
            >
                <svg
                    class="w-4 h-4 text-green-600 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2"
                    />
                </svg>

                <span>Excel</span>
            </a>


            {{-- NOUVELLE VENTE --}}
            <a
                href="{{ route('ventes.create') }}"
                class="col-span-2 sm:col-span-1
                       inline-flex items-center justify-center gap-1.5
                       bg-blue-600 hover:bg-blue-700
                       active:scale-[0.98]
                       text-white text-sm font-semibold
                       px-4 py-2.5 rounded-xl
                       shadow-sm transition"
            >
                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4v16m8-8H4"
                    />
                </svg>

                <span>Nouvelle vente</span>
            </a>

        </div>

    </div>


    {{-- =========================================================
         MESSAGES
    ========================================================== --}}

    @if(session('success'))

        <div
            class="flex items-start gap-3
                   bg-green-50 border border-green-200
                   text-green-800
                   text-sm sm:text-base
                   px-4 py-3.5
                   rounded-xl mb-5 shadow-sm"
        >

            <svg
                class="w-5 h-5 flex-shrink-0 mt-0.5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('error'))

        <div
            class="flex items-start gap-3
                   bg-red-50 border border-red-200
                   text-red-800
                   text-sm sm:text-base
                   px-4 py-3.5
                   rounded-xl mb-5 shadow-sm"
        >

            <svg
                class="w-5 h-5 flex-shrink-0 mt-0.5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                />
            </svg>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =========================================================
         TABLEAU
    ========================================================== --}}

    <div
        class="bg-white
               border border-gray-200
               rounded-2xl
               shadow-sm
               overflow-hidden"
    >

        {{-- EN-TÊTE DU TABLEAU --}}

        <div class="px-4 sm:px-5 py-4 border-b border-gray-100 bg-gray-50/70">

            <div class="flex items-center justify-between gap-3">

                <div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800">
                        Liste des ventes
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                        Historique des ventes enregistrées
                    </p>
                </div>

                <div
                    class="hidden sm:flex items-center justify-center
                           w-9 h-9 rounded-lg
                           bg-blue-50 text-blue-600"
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 2a1 1 0 00-1 1v1H6a2 2 0 00-2 2v13a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2V3a1 1 0 00-1-1H9z"
                        />
                    </svg>
                </div>

            </div>

        </div>


        {{-- =====================================================
             TABLEAU RESPONSIVE
        ====================================================== --}}

        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px] divide-y divide-gray-100">

                <thead class="bg-gray-50">

                    <tr>

                        <th
                            class="px-4 sm:px-5 py-3.5
                                   text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wide
                                   whitespace-nowrap"
                        >
                            N°
                        </th>

                        <th
                            class="px-4 sm:px-5 py-3.5
                                   text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wide
                                   whitespace-nowrap"
                        >
                            Client
                        </th>

                        <th
                            class="px-4 sm:px-5 py-3.5
                                   text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wide
                                   whitespace-nowrap"
                        >
                            Date
                        </th>

                        <th
                            class="px-4 sm:px-5 py-3.5
                                   text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wide
                                   whitespace-nowrap"
                        >
                            Total
                        </th>

                        <th
                            class="px-4 sm:px-5 py-3.5
                                   text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wide
                                   whitespace-nowrap"
                        >
                            Statut
                        </th>

                        <th
                            class="px-4 sm:px-5 py-3.5
                                   text-right text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wide
                                   whitespace-nowrap"
                        >
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($ventes as $vente)

                    <tr
                        class="hover:bg-gray-50/70
                               transition-colors duration-150"
                    >

                        {{-- N° --}}
                        <td
                            class="px-4 sm:px-5 py-4
                                   text-sm text-gray-500
                                   whitespace-nowrap"
                        >
                            {{ $loop->iteration }}
                        </td>


                        {{-- CLIENT --}}
                        <td
                            class="px-4 sm:px-5 py-4
                                   text-sm font-medium
                                   text-gray-900
                                   whitespace-nowrap"
                        >
                            {{ $vente->client->nom_client ?? '-' }}
                        </td>


                        {{-- DATE --}}
                        <td
                            class="px-4 sm:px-5 py-4
                                   text-sm text-gray-600
                                   whitespace-nowrap"
                        >
                            {{ $vente->date_vente->format('d/m/Y') }}
                        </td>


                        {{-- TOTAL --}}
                        <td
                            class="px-4 sm:px-5 py-4
                                   text-sm font-semibold
                                   text-gray-900
                                   whitespace-nowrap"
                        >
                            {{ number_format($vente->montant_total, 2) }} GNF
                        </td>


                        {{-- STATUT --}}
                        <td
                            class="px-4 sm:px-5 py-4
                                   text-sm whitespace-nowrap"
                        >

                            <span
                                class="inline-flex items-center
                                       px-2.5 py-1.5
                                       text-xs font-semibold
                                       rounded-full

                                       @if($vente->statut == 'payé')
                                           bg-green-100 text-green-700

                                       @elseif($vente->statut == 'partiel')
                                           bg-orange-100 text-orange-700

                                       @elseif($vente->statut == 'en_cours')
                                           bg-yellow-100 text-yellow-700

                                       @else
                                           bg-gray-100 text-gray-700
                                       @endif"
                            >

                                <span
                                    class="w-1.5 h-1.5 rounded-full mr-1.5

                                    @if($vente->statut == 'payé')
                                        bg-green-500

                                    @elseif($vente->statut == 'partiel')
                                        bg-orange-500

                                    @elseif($vente->statut == 'en_cours')
                                        bg-yellow-500

                                    @else
                                        bg-gray-500
                                    @endif"
                                ></span>


                                @if($vente->statut == 'en_cours')

                                    Crédit

                                @elseif($vente->statut == 'payé')

                                    Payé

                                @elseif($vente->statut == 'partiel')

                                    Partiel

                                @else

                                    {{ ucfirst($vente->statut) }}

                                @endif

                            </span>

                        </td>


                        {{-- =================================================
                             ACTIONS
                             MODIFICATION RETIRÉE
                        ================================================== --}}

                        <td
                            class="px-4 sm:px-5 py-4
                                   text-sm"
                        >

                            <div class="flex justify-end items-center gap-1.5">


                                {{-- VOIR --}}
                                <a
                                    href="{{ route('ventes.show', $vente) }}"
                                    class="w-9 h-9
                                           flex items-center justify-center
                                           rounded-lg
                                           text-blue-600
                                           hover:bg-blue-50
                                           active:bg-blue-100
                                           transition"
                                    title="Voir"
                                >

                                    <svg
                                        class="h-4.5 w-4.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>

                                </a>


                                {{-- REÇU --}}
                                <a
                                    href="{{ route('ventes.receipt', $vente) }}"
                                    class="w-9 h-9
                                           flex items-center justify-center
                                           rounded-lg
                                           text-indigo-600
                                           hover:bg-indigo-50
                                           active:bg-indigo-100
                                           transition"
                                    title="Imprimer le reçu"
                                >

                                    <svg
                                        class="h-4.5 w-4.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 9V2h12v7M6 22h12v-7H6v7zM6 14h12v3H6v-3z"
                                        />
                                    </svg>

                                </a>


                                {{-- ENCAISSER --}}
                                @if($vente->statut == 'en_cours' || $vente->statut == 'partiel')

                                    <a
                                        href="{{ route('recettes.create', ['vente_id' => $vente->id]) }}"
                                        class="w-9 h-9
                                               flex items-center justify-center
                                               rounded-lg
                                               text-green-600
                                               hover:bg-green-50
                                               active:bg-green-100
                                               transition"
                                        title="Encaisser"
                                    >

                                        <svg
                                            class="h-4.5 w-4.5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8c-2 0-4 1-4 3s2 3 4 3 4-1 4-3-2-3-4-3zm0 6v6"
                                            />
                                        </svg>

                                    </a>

                                @endif


                                {{-- =================================================
                                     MODIFIER SUPPRIMÉ
                                     L'action ventes.edit n'est plus affichée.
                                ================================================== --}}


                                {{-- SUPPRIMER --}}
                                @if($vente->statut == 'en_cours')

                                    <form
                                        action="{{ route('ventes.destroy', $vente) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Supprimer cette vente ?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="w-9 h-9
                                                   flex items-center justify-center
                                                   rounded-lg
                                                   text-red-600
                                                   hover:bg-red-50
                                                   active:bg-red-100
                                                   transition"
                                            title="Supprimer"
                                        >

                                            <svg
                                                class="h-4.5 w-4.5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 2h4a1 1 0 011 1v1H9V3a1 1 0 011-1z"
                                                />
                                            </svg>

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>


                    @empty

                    {{-- AUCUNE VENTE --}}
                    <tr>

                        <td
                            colspan="6"
                            class="px-4 py-14 text-center"
                        >

                            <div
                                class="flex flex-col
                                       items-center gap-3
                                       text-gray-400"
                            >

                                <div
                                    class="w-14 h-14
                                           flex items-center justify-center
                                           rounded-full
                                           bg-gray-100"
                                >

                                    <svg
                                        class="w-7 h-7"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 2a1 1 0 00-1 1v1H6a2 2 0 00-2 2v13a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2V3a1 1 0 00-1-1H9z"
                                        />
                                    </svg>

                                </div>


                                <p
                                    class="text-sm sm:text-base
                                           text-gray-500"
                                >
                                    Aucune vente enregistrée pour le moment
                                </p>


                                <a
                                    href="{{ route('ventes.create') }}"
                                    class="text-sm font-semibold
                                           text-blue-600
                                           hover:text-blue-700"
                                >
                                    Créer la première vente
                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =========================================================
             PAGINATION
        ========================================================== --}}

        @if(method_exists($ventes, 'links'))

            <div
                class="px-4 sm:px-5 py-4
                       border-t border-gray-100
                       bg-gray-50/50
                       overflow-x-auto"
            >
                {{ $ventes->links() }}
            </div>

        @endif

    </div>

</div>

@endsection
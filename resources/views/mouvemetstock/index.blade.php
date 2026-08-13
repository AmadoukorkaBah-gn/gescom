@extends('layouts.app')

@section('content')
<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-8">

    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 tracking-tight">
                Approvisionnements (Achats)
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Gestion des entrées de stock
            </p>
        </div>

        <a
            href="{{ route('mouvement.create') }}"
            class="inline-flex items-center justify-center gap-2
                   w-full sm:w-auto
                   bg-blue-600 hover:bg-blue-700
                   text-white font-semibold
                   px-4 py-2.5
                   rounded-lg shadow-sm
                   transition duration-200
                   text-sm sm:text-base"
        >
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

            <span>Nouveau Approvisionnement</span>
        </a>
    </div>


    {{-- =====================================================
         MESSAGE SUCCESS
    ====================================================== --}}
    @if(session('success'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm">
            <div class="flex items-start gap-2">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 flex-shrink-0"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>

                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif


    {{-- =====================================================
         TABLEAU
    ====================================================== --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        {{-- En-tête du tableau --}}
        <div class="px-4 sm:px-5 py-4 border-b border-gray-200 bg-gray-50">

            <div class="flex items-center gap-2">

                <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M20 7h-9m9 5h-9m9 5h-9M4 7h.01M4 12h.01M4 17h.01"/>
                    </svg>
                </div>

                <div>
                    <h2 class="font-semibold text-gray-800">
                        Liste des approvisionnements
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-500">
                        Historique des mouvements de stock
                    </p>
                </div>

            </div>

        </div>


        {{-- =================================================
             CONTENEUR RESPONSIVE
        ================================================== --}}
        <div class="overflow-x-auto">

            <table class="min-w-[850px] w-full">

                {{-- En-tête --}}
                <thead class="bg-orange-500">

                    <tr>

                        <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wide">
                            #
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wide">
                            Produit
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wide">
                            Quantité
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wide">
                            Raison
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wide">
                            Date
                        </th>

                        <th class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wide">
                            Actions
                        </th>

                    </tr>

                </thead>


                {{-- Corps --}}
                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($mouvements as $m)

                        <tr class="hover:bg-gray-50 transition duration-150">

                            {{-- Numéro --}}
                            <td class="px-4 py-3.5 text-sm font-semibold text-gray-500">
                                {{ $loop->iteration }}
                            </td>


                            {{-- Produit --}}
                            <td class="px-4 py-3.5">

                                <div class="font-semibold text-gray-800 text-sm">
                                    {{ $m->produit->nom_produit ?? '-' }}
                                </div>

                            </td>


                            {{-- Quantité --}}
                            <td class="px-4 py-3.5">

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-blue-50 text-blue-700
                                             text-xs sm:text-sm font-semibold">

                                    {{ $m->quantite }}

                                </span>

                            </td>


                            {{-- Raison --}}
                            <td class="px-4 py-3.5">

                                @if($m->raison === 'achat')

                                    <span class="inline-flex items-center px-2.5 py-1
                                                 rounded-full
                                                 bg-green-100 text-green-700
                                                 text-xs font-semibold">
                                        Achat
                                    </span>

                                @elseif($m->raison === 'vente')

                                    <span class="inline-flex items-center px-2.5 py-1
                                                 rounded-full
                                                 bg-blue-100 text-blue-700
                                                 text-xs font-semibold">
                                        Vente
                                    </span>

                                @elseif($m->raison === 'retour')

                                    <span class="inline-flex items-center px-2.5 py-1
                                                 rounded-full
                                                 bg-yellow-100 text-yellow-700
                                                 text-xs font-semibold">
                                        Retour
                                    </span>

                                @else

                                    <span class="inline-flex items-center px-2.5 py-1
                                                 rounded-full
                                                 bg-gray-100 text-gray-700
                                                 text-xs font-semibold">
                                        {{ ucfirst($m->raison) }}
                                    </span>

                                @endif

                            </td>


                            {{-- Date --}}
                            <td class="px-4 py-3.5 text-sm text-gray-600 whitespace-nowrap">

                                {{ $m->date_mouvement
                                    ? $m->date_mouvement->format('Y-m-d H:i')
                                    : $m->created_at->format('Y-m-d H:i')
                                }}

                            </td>


                            {{-- Actions --}}
                            <td class="px-4 py-3.5">

                                <div class="flex items-center justify-center gap-1.5">

                                    {{-- Voir --}}
                                    <a
                                        href="{{ route('mouvement.show', $m) }}"
                                        title="Voir"
                                        class="inline-flex items-center justify-center
                                               w-9 h-9
                                               rounded-lg
                                               bg-indigo-50 text-indigo-600
                                               hover:bg-indigo-100
                                               transition"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-4 h-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>

                                        </svg>

                                    </a>


                                    {{-- Modifier --}}
                                    <a
                                        href="{{ route('mouvement.edit', $m) }}"
                                        title="Modifier"
                                        class="inline-flex items-center justify-center
                                               w-9 h-9
                                               rounded-lg
                                               bg-yellow-50 text-yellow-600
                                               hover:bg-yellow-100
                                               transition"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-4 h-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M15.232 5.232l3.536 3.536M9 13.5V15h1.5l7.5-7.5-1.5-1.5L9 13.5z"/>

                                        </svg>

                                    </a>


                                    {{-- Supprimer --}}
                                    <form
                                        action="{{ route('mouvement.destroy', $m) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Êtes-vous sûr ?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Supprimer"
                                            class="inline-flex items-center justify-center
                                                   w-9 h-9
                                                   rounded-lg
                                                   bg-red-50 text-red-600
                                                   hover:bg-red-100
                                                   transition"
                                        >

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

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-4 py-12 text-center"
                            >

                                <div class="flex flex-col items-center justify-center">

                                    <div class="w-14 h-14 rounded-full bg-gray-100
                                                flex items-center justify-center mb-3">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-7 h-7 text-gray-400"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M20 7h-9m9 5h-9m9 5h-9M4 7h.01M4 12h.01M4 17h.01"/>

                                        </svg>

                                    </div>

                                    <p class="text-sm font-semibold text-gray-600">
                                        Aucun approvisionnement trouvé
                                    </p>

                                    <p class="text-xs text-gray-400 mt-1">
                                        Les nouveaux approvisionnements apparaîtront ici.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             PAGINATION
        ================================================== --}}
        @if(method_exists($mouvements, 'links'))

            <div class="px-4 sm:px-5 py-4 border-t border-gray-200 bg-gray-50 overflow-x-auto">
                {{ $mouvements->links() }}
            </div>

        @endif

    </div>

</div>
@endsection
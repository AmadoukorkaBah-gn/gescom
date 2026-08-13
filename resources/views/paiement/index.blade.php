@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                Liste des Paiements
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Consultez l'historique des paiements enregistrés.
            </p>
        </div>

        <a
            href="{{ route('paiement.create') }}"
            class="inline-flex items-center justify-center gap-2
                   w-full sm:w-auto
                   bg-blue-600 hover:bg-blue-700
                   text-white font-semibold
                   px-5 py-2.5
                   rounded-xl
                   shadow-sm hover:shadow-md
                   transition duration-200"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>

            Nouveau Paiement
        </a>

    </div>


    {{-- =========================================================
         MESSAGE DE SUCCÈS
    ========================================================== --}}
    @if(session('success'))

        <div class="mb-6 flex items-start gap-3
                    bg-green-50
                    border border-green-200
                    text-green-800
                    px-4 py-3
                    rounded-xl
                    shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 mt-0.5 flex-shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <span class="text-sm sm:text-base font-medium">
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- =========================================================
         TABLEAU
    ========================================================== --}}
    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">

        {{-- En-tête du tableau --}}
        <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gray-50">

            <h2 class="text-base sm:text-lg font-semibold text-gray-800">
                Historique des paiements
            </h2>

        </div>


        {{-- Scroll horizontal sur mobile --}}
        <div class="overflow-x-auto">

            <table class="min-w-[850px] w-full">

                {{-- =================================================
                     THEAD
                ================================================== --}}
                <thead class="bg-blue-600">

                    <tr>

                        <th class="px-4 sm:px-5 py-3.5 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            N°
                        </th>

                        <th class="px-4 sm:px-5 py-3.5 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Vente
                        </th>

                        <th class="px-4 sm:px-5 py-3.5 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Client
                        </th>

                        <th class="px-4 sm:px-5 py-3.5 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Montant payé
                        </th>

                        <th class="px-4 sm:px-5 py-3.5 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Date
                        </th>

                        <th class="px-4 sm:px-5 py-3.5 text-left
                                   text-xs font-bold text-white uppercase
                                   tracking-wider whitespace-nowrap">
                            Mode
                        </th>

                    </tr>

                </thead>


                {{-- =================================================
                     TBODY
                ================================================== --}}
                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse(\App\Models\Paiement::with(['vente.client'])->orderBy('date_paiement', 'desc')->get() as $paiement)

                    <tr class="hover:bg-blue-50/50 transition duration-150">

                        {{-- N° --}}
                        <td class="px-4 sm:px-5 py-4
                                   text-sm font-semibold text-gray-700">
                            #{{ $paiement->id }}
                        </td>


                        {{-- Vente --}}
                        <td class="px-4 sm:px-5 py-4 text-sm">

                            <span class="inline-flex items-center
                                         px-2.5 py-1
                                         rounded-lg
                                         bg-blue-50
                                         text-blue-700
                                         font-semibold">
                                #{{ $paiement->vente_id }}
                            </span>

                        </td>


                        {{-- Client --}}
                        <td class="px-4 sm:px-5 py-4
                                   text-sm font-medium text-gray-800">

                            {{ $paiement->vente->client->nom_client ?? '-' }}

                        </td>


                        {{-- Montant --}}
                        <td class="px-4 sm:px-5 py-4 text-sm">

                            <span class="font-bold text-green-600 whitespace-nowrap">
                                {{ number_format($paiement->montant_paye, 2) }}
                                <span class="text-xs font-semibold">
                                    GNF
                                </span>
                            </span>

                        </td>


                        {{-- Date --}}
                        <td class="px-4 sm:px-5 py-4
                                   text-sm text-gray-600 whitespace-nowrap">

                            <div class="flex items-center gap-2">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-4 w-4 text-gray-400"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                                </svg>

                                {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('Y-m-d') }}

                            </div>

                        </td>


                        {{-- Mode --}}
                        <td class="px-4 sm:px-5 py-4 text-sm">

                            <span class="inline-flex items-center
                                         px-3 py-1
                                         rounded-full
                                         bg-gray-100
                                         text-gray-700
                                         font-semibold
                                         whitespace-nowrap">

                                {{ ucfirst($paiement->mode) }}

                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="px-4 py-12 text-center">

                            <div class="flex flex-col items-center justify-center">

                                <div class="w-14 h-14
                                            flex items-center justify-center
                                            rounded-full
                                            bg-gray-100
                                            mb-3">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-7 w-7 text-gray-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 12v-2m0 0c-1.11 0-2.08-.402-2.599-1M12 16c1.657 0 3-.895 3-2s-1.343-2-3-2-3-.895-3-2 1.343-2 3-2"/>
                                    </svg>

                                </div>

                                <p class="text-gray-500 font-medium">
                                    Aucun paiement trouvé.
                                </p>

                                <p class="text-gray-400 text-sm mt-1">
                                    Les paiements enregistrés apparaîtront ici.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
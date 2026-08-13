@extends('layouts.app')

@section('content')

<style>
    /* Police Inter : très lisible sur écran, bon support des accents français */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    #achatsListPage {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    #achatsListPage table {
        font-size: 14px;
    }
</style>

<div id="achatsListPage" class="container mx-auto px-3 sm:px-4 py-6 sm:py-8">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 tracking-tight">
            Achats / Approvisionnements
        </h1>

        <a href="{{ route('achats.create') }}"
           class="inline-flex justify-center items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded w-full sm:w-auto text-sm sm:text-base">
            Nouveau Achat
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
            {{ session('error') }}
        </div>
    @endif


    <!-- =====================================================
         VUE CARTES (mobile / tablette < md)
    ====================================================== -->

    <div class="md:hidden space-y-3">

        @php $counterMobile = 1; @endphp

        @foreach($achats as $achat)
            @foreach($achat->details as $detail)

                <div class="bg-white shadow-md rounded-lg p-4 border border-gray-100">

                    <div class="flex items-start justify-between gap-3 mb-3">

                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 font-semibold mb-0.5">
                                N° {{ $counterMobile++ }}
                            </p>
                            <h3 class="font-bold text-gray-900 text-base leading-snug break-words">
                                {{ $detail->produit->nom_produit }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-0.5">
                                {{ $achat->fournisseur->nom_fournisseur ?? '-' }}
                            </p>
                        </div>

                        <span class="shrink-0 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($achat->statut == 'en_cours') bg-yellow-100 text-yellow-800
                            @elseif($achat->statut == 'recu') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($achat->statut) }}
                        </span>

                    </div>


                    <div class="grid grid-cols-2 gap-x-3 gap-y-2 text-sm border-t border-gray-100 pt-3">

                        <div>
                            <p class="text-xs text-gray-400">Qté achetée</p>
                            <p class="font-bold text-gray-900">{{ $detail->quantite }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400">Stock actuel</p>
                            <p class="font-bold text-gray-900">{{ $detail->produit->stockActuel() }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400">Péremption</p>
                            <p class="font-bold text-gray-900">{{ $detail->date_peremption ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400">Prix unitaire</p>
                            <p class="font-bold text-gray-900">{{ number_format($detail->prix_unitaire, 2) }} GNF</p>
                        </div>

                    </div>


                    @if($loop->first && $achat->statut == 'recu')
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-400 mb-1">Paiement</p>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($achat->statut_paiement == 'paye') bg-green-100 text-green-800
                                @elseif($achat->statut_paiement == 'partiel') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($achat->statut_paiement == 'paye')
                                    Payé
                                @elseif($achat->statut_paiement == 'partiel')
                                    Partiel ({{ number_format($achat->reste_a_payer, 0) }} GNF)
                                @else
                                    Crédit ({{ number_format($achat->total, 0) }} GNF)
                                @endif
                            </span>
                        </div>
                    @endif


                    @if($loop->first)
                        <div class="flex flex-wrap gap-2 mt-3 pt-3 border-t border-gray-100">
                            <a href="{{ route('achats.show', $achat) }}"
                               class="flex-1 text-center bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-2 rounded text-xs font-semibold">
                                Voir
                            </a>

                            @if($achat->statut == 'en_cours')
                                <a href="{{ route('achats.receive.form', $achat) }}"
                                   class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-xs font-semibold">
                                    Recevoir
                                </a>
                            @endif

                            @if($achat->statut == 'recu' && $achat->statut_paiement != 'paye')
                                <a href="{{ route('depenses.create', ['achat_id' => $achat->id]) }}"
                                   class="flex-1 text-center bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded text-xs font-semibold">
                                    Payer
                                </a>
                            @endif
                        </div>
                    @endif

                </div>

            @endforeach
        @endforeach

        <div class="mt-4">
            {{ $achats->links() }}
        </div>

    </div>


    <!-- =====================================================
         VUE TABLEAU (md et plus)
    ====================================================== -->

    <div class="hidden md:block bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <!-- En-tête orange -->
            <thead class="bg-orange-500">
                <tr>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">N°</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Produit</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Fournisseur</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Qté Achetée</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Stock Actuel</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Date Péremption</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Prix Unitaire</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Statut</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Paiement</th>
                    <th class="px-2 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <!-- Corps du tableau -->
            <tbody class="bg-white divide-y divide-gray-200 text-gray-900 font-bold">
                @php $counter = 1; @endphp
                @foreach($achats as $achat)
                    @foreach($achat->details as $detail)
                    <tr class="hover:bg-gray-50">
                        <td class="px-2 py-2 text-sm">{{ $counter++ }}</td>
                        <td class="px-2 py-2 text-sm">{{ $detail->produit->nom_produit }}</td>
                        <td class="px-2 py-2 text-sm">{{ $achat->fournisseur->nom_fournisseur ?? '-' }}</td>
                        <td class="px-2 py-2 text-sm">{{ $detail->quantite }}</td>
                        <td class="px-2 py-2 text-sm">{{ $detail->produit->stockActuel() }}</td>
                        <td class="px-2 py-2 text-sm">{{ $detail->date_peremption }}</td>
                        <td class="px-2 py-2 text-sm">{{ number_format($detail->prix_unitaire, 2) }} GNF</td>
                        <td class="px-2 py-2 text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($achat->statut == 'en_cours') bg-yellow-100 text-yellow-800
                                @elseif($achat->statut == 'recu') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($achat->statut) }}
                            </span>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            @if($loop->first && $achat->statut == 'recu')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($achat->statut_paiement == 'paye') bg-green-100 text-green-800
                                    @elseif($achat->statut_paiement == 'partiel') bg-orange-100 text-orange-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($achat->statut_paiement == 'paye')
                                        Payé
                                    @elseif($achat->statut_paiement == 'partiel')
                                        Partiel ({{ number_format($achat->reste_a_payer, 0) }} GNF)
                                    @else
                                        Crédit ({{ number_format($achat->total, 0) }} GNF)
                                    @endif
                                </span>
                            @endif
                        </td>
                        <td class="px-2 py-2 text-sm">
                            @if($loop->first)
                                <div class="flex space-x-1">
                                    <a href="{{ route('achats.show', $achat) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-2 py-1 rounded text-xs">Voir</a>
                                    @if($achat->statut == 'en_cours')
                                        <a href="{{ route('achats.receive.form', $achat) }}" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">Recevoir</a>
                                    @endif
                                    @if($achat->statut == 'recu' && $achat->statut_paiement != 'paye')
                                        <a href="{{ route('depenses.create', ['achat_id' => $achat->id]) }}" class="bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded text-xs">Payer</a>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 px-4 pb-4">
            {{ $achats->links() }}
        </div>
    </div>

</div>
@endsection
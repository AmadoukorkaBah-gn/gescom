@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Achats / Approvisionnements</h1>
        <a href="{{ route('achats.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nouveau Achat
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
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

        <div class="mt-4">
            {{ $achats->links() }}
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Détails de la Vente</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>Client:</strong> {{ $vente->client->nom_client }}
            </div>
            <div>
                <strong>Date de vente:</strong> {{ $vente->date_vente->format('d/m/Y à H:i') }}

            </div>
            <div>
                <strong>Montant total:</strong> {{ number_format($vente->montant_total, 2) }} GNF
            </div>
            <div>
                <strong>Statut:</strong>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                    @if($vente->statut == 'payé') bg-green-100 text-green-800
                    @elseif($vente->statut == 'partiel') bg-orange-100 text-orange-800
                    @elseif($vente->statut == 'en_cours') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800 @endif">
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
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Produits vendus</h2>
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sous-total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($vente->details as $detail)
                <tr>
                    <td class="px-4 py-2">{{ $detail->produit->nom_produit }}</td>
                    <td class="px-4 py-2">{{ $detail->quantite }}</td>
                    <td class="px-4 py-2">{{ number_format($detail->prix_unitaire, 2) }} GNF</td>
                    <td class="px-4 py-2">{{ number_format($detail->quantite * $detail->prix_unitaire, 2) }} GNF</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 space-x-4">
        <a href="{{ route('ventes.index') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour à la liste
        </a>
        <a href="{{ route('ventes.receipt', $vente) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            📥 Télécharger/Imprimer
        </a>
        @if($vente->statut == 'en_cours' || $vente->statut == 'partiel')
            <a href="{{ route('recettes.create', ['vente_id' => $vente->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Encaisser
            </a>
        @endif
    </div>
</div>
@endsection
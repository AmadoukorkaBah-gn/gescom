@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Titre --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Détails de l'Achat</h1>
        <a href="{{ route('achats.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour à la liste
        </a>
    </div>

    {{-- Informations générales --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><strong>Fournisseur :</strong> {{ $achat->fournisseur->nom_fournisseur }}</div>
        <div><strong>Date d'achat :</strong> {{ $achat->date_achat->format('Y-m-d') }}</div>
        <div><strong>Numéro de facture :</strong> {{ $achat->numero_facture ?? '-' }}</div>
        <div><strong>Total :</strong> {{ number_format($achat->total, 2) }} GNF</div>
        <div>
            <strong>Statut :</strong>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                @if($achat->statut == 'en_cours') bg-yellow-100 text-yellow-800
                @elseif($achat->statut == 'recu') bg-green-100 text-green-800
                @else bg-red-100 text-red-800 @endif">
                {{ ucfirst($achat->statut) }}
            </span>
        </div>
    </div>

    {{-- Produits commandés --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Produits commandés</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité achetée</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date péremption</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sous-total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($achat->details as $detail)
                <tr>
                    <td class="px-4 py-2">{{ $detail->produit->nom_produit }}</td>
                    <td class="px-4 py-2">{{ $detail->quantite }}</td>
                    <td class="px-4 py-2">{{ $detail->date_peremption }}</td>
                    <td class="px-4 py-2">{{ number_format($detail->prix_unitaire, 2) }} GNF</td>
                    <td class="px-4 py-2">{{ number_format($detail->quantite * $detail->prix_unitaire, 2) }} GNF</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Bouton de réception --}}
    @if($achat->statut == 'en_cours')
    <div>
        <a href="{{ route('achats.receive.form', $achat) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">
            Recevoir et payer
        </a>
    </div>
    @endif

</div>
@endsection

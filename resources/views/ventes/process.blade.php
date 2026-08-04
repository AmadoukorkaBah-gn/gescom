@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Traitement de la vente #{{ $vente->id }}</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Unitaire</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($vente->details as $detail)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $detail->produit->nom_produit }}</td>
                    <td class="px-4 py-2">{{ $detail->quantite }}</td>
                    <td class="px-4 py-2">{{ number_format($detail->prix_unitaire, 2) }} GNF</td>
                    <td class="px-4 py-2">{{ number_format($detail->quantite * $detail->prix_unitaire, 2) }} GNF</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <th colspan="3" class="px-4 py-2 text-right text-lg font-bold">Montant Total :</th>
                    <th class="px-4 py-2 text-lg font-bold">{{ number_format($vente->montant_total, 2) }} GNF</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <form action="{{ route('ventes.process', $vente) }}" method="POST">
        @csrf
        <div class="flex items-center space-x-4">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded"
                onclick="return confirm('Confirmer le traitement de cette vente et mise à jour du stock ?')">
                Confirmer et Traiter
            </button>

            <a href="{{ route('ventes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection

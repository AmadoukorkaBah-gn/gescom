@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto pb-10">

    {{-- En-tête --}}
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-1">
            <a href="{{ route('ventes.index') }}" class="hover:text-blue-600 transition">Ventes</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-700 font-medium">Traitement</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Vente #{{ $vente->id }}</h1>
    </div>

    @if(session('error'))
        <div class="flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-xl mb-5">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Info --}}
    <div class="flex items-start gap-2.5 bg-blue-50 border border-blue-100 text-blue-800 text-sm px-4 py-3 rounded-xl mb-5">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Confirmer le traitement mettra à jour le stock des produits listés ci-dessous. Cette action est définitive.</span>
    </div>

    {{-- Détails --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Produit</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Quantité</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Prix unitaire</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($vente->details as $detail)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $detail->produit->nom_produit }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 text-right">{{ $detail->quantite }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 text-right">{{ number_format($detail->prix_unitaire, 2) }} GNF</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">{{ number_format($detail->quantite * $detail->prix_unitaire, 2) }} GNF</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Total --}}
    <div class="bg-[#1e293b] rounded-2xl shadow-sm p-5 sm:p-6 mb-6 flex items-center justify-between">
        <span class="text-sm text-white/70 uppercase tracking-wide">Montant total</span>
        <span class="text-2xl sm:text-3xl font-bold text-white">{{ number_format($vente->montant_total, 2) }} GNF</span>
    </div>

    {{-- Actions --}}
    <form action="{{ route('ventes.process', $vente) }}" method="POST">
        @csrf
        <div class="flex items-center gap-4">
            <button
                type="submit"
                onclick="return confirm('Confirmer le traitement de cette vente et mise à jour du stock ?')"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 active:scale-[0.98] text-white font-semibold text-sm py-2.5 px-5 rounded-lg shadow-sm transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Confirmer et traiter
            </button>

            <a href="{{ route('ventes.index') }}" class="text-sm text-gray-600 hover:text-gray-900 transition">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
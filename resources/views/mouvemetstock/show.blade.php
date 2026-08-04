@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Détails du Mouvement</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>Produit:</strong> {{ $mouvement->produit->nom_produit ?? '-' }}
            </div>
            <div>
                <strong>Type:</strong> {{ $mouvement->type_mouvement }}
            </div>
            <div>
                <strong>Quantité:</strong> {{ $mouvement->quantite }}
            </div>
            <div>
                <strong>Raison:</strong> {{ $mouvement->raison }}
            </div>
            <div>
                <strong>Date:</strong> {{ $mouvement->date_mouvement ? $mouvement->date_mouvement->format('Y-m-d H:i') : $mouvement->created_at->format('Y-m-d H:i') }}
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('mouvement.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
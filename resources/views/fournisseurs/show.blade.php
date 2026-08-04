@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Détails du Fournisseur</h1>

    <div class="bg-white shadow rounded p-4">
        <p><strong>Nom :</strong> {{ $fournisseur->nom_fournisseur }}</p>
        <p><strong>Email :</strong> {{ $fournisseur->email ?? 'Non renseigné' }}</p>
        <p><strong>Téléphone :</strong> {{ $fournisseur->contact_fournisseur ?? 'Non renseigné' }}</p>
        <p><strong>Adresse :</strong> {{ $fournisseur->adresse_fournisseur ?? 'Non renseigné' }}</p>
    </div>

    <a href="{{ route('fournisseurs.index') }}" class="mt-4 inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
        Retour à la liste
    </a>
</div>
@endsection

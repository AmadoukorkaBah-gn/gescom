@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Détails de la catégorie</h1>

    <div class="bg-white p-4 shadow rounded">
        <p><strong>Identifiant :</strong> {{ $categorie->id }}</p>
        <p class="mt-2"><strong>Nom :</strong> {{ $categorie->nom_categorie }}</p>
    </div>

    <div class="mt-4">
        <a href="{{ route('categorie.index') }}" class="text-gray-600">Retour à la liste</a>
    </div>
</div>
@endsection

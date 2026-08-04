@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Détails du Client</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>Nom:</strong> {{ $client->nom_client }}
            </div>
            <div>
                <strong>Contact:</strong> {{ $client->contact_client ?? '-' }}
            </div>
            <div>
                <strong>Adresse:</strong> {{ $client->adresse_client ?? '-' }}
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('clients.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
            <a href="{{ route('clients.edit', $client->id) }}" class="ml-4 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Modifier
            </a>
        </div>
    </div>
</div>
@endsection
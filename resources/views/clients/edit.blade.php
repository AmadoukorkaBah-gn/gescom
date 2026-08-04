@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Client</h1>

    <form action="{{ route('clients.update', $client->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="nom_client" class="block text-sm font-medium text-gray-700">Nom du client</label>
                <input type="text" name="nom_client" id="nom_client" value="{{ old('nom_client', $client->nom_client) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nom_client')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="contact_client" class="block text-sm font-medium text-gray-700">Contact</label>
                <input type="text" name="contact_client" id="contact_client" value="{{ old('contact_client', $client->contact_client) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('contact_client')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="adresse_client" class="block text-sm font-medium text-gray-700">Adresse</label>
                <textarea name="adresse_client" id="adresse_client" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('adresse_client', $client->adresse_client) }}</textarea>
                @error('adresse_client')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Mettre à jour
            </button>
            <a href="{{ route('clients.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Annuler</a>
        </div>
    </form>
</div>
@endsection

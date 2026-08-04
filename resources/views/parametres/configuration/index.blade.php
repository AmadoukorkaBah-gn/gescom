@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Configuration de l'Entreprise</h1>

        {{-- Messages de succès --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Messages d'erreurs --}}
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('configuration.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informations de l'Entreprise</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nom_entreprise" class="block text-sm font-medium text-gray-700 mb-2">Nom de l'entreprise</label>
                        <input type="text" name="nom_entreprise" id="nom_entreprise" 
                            value="{{ old('nom_entreprise', $config->nom_entreprise) }}"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">Contact (Téléphone)</label>
                        <input type="text" name="contact" id="contact" 
                            value="{{ old('contact', $config->contact) }}"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email_entreprise" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email_entreprise" id="email_entreprise" 
                            value="{{ old('email_entreprise', $config->email_entreprise) }}"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">Adresse / Localisation</label>
                        <input type="text" name="adresse" id="adresse" 
                            value="{{ old('adresse', $config->adresse) }}"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- Logo --}}
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo de l'entreprise</label>
                    <div class="flex items-center gap-4">
                        @if($config->logo && file_exists(public_path('storage/' . $config->logo)))
                            <div class="relative">
                                <img src="{{ asset('storage/' . $config->logo) }}" alt="Logo" class="h-20 w-20 object-contain border rounded">
                                <a href="#" 
                                   class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                   onclick="event.preventDefault(); if(confirm('Supprimer le logo ?')) { document.getElementById('delete-logo-form').submit(); }">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Aucun logo chargé.</p>
                        @endif
                        <input type="file" name="logo" id="logo" accept="image/*"
                            class="border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Formats acceptés : JPEG, PNG, GIF. Max 2 Mo.</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Enregistrer la configuration
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Formulaire caché pour supprimer le logo --}}
<form id="delete-logo-form" method="POST" action="{{ route('configuration.delete-logo') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Ajouter un Fournisseur</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('fournisseurs.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="nom" class="block font-medium">Nom</label>
            <input type="text" id="nom_fournisseur" name="nom_fournisseur" value="{{ old('nom_fournisseur') }}" required class="w-full border rounded px-3 py-2">
        </div>  
       <div>
            <label for="email" class="block font-medium">Email</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label for="telephone" class="block font-medium">Téléphone</label>
            <input type="text" id="contact_fournisseur" name="contact_fournisseur" value="{{ old('contact_fournisseur') }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label for="adresse" class="block font-medium">Adresse</label>
            <input type="text" id="adresse" name="adresse_fournisseur" value="{{ old('adresse_fournisseur') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="space-x-2">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Enregistrer</button>
            <a href="{{ route('fournisseurs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Annuler</a>
        </div>
    </form>
</div>
@endsection

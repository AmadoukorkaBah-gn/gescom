@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Modifier la catégorie</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categorie.update', $categorie) }}" method="POST" class="bg-white p-4 shadow rounded">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nom_categorie" class="block text-sm font-medium text-gray-700">Nom de la catégorie</label>
            <input type="text" name="nom_categorie" id="nom_categorie" value="{{ old('nom_categorie', $categorie->nom_categorie) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Mettre à jour</button>
            <a href="{{ route('categorie.index') }}" class="text-gray-600">Annuler</a>
        </div>
    </form>
</div>
@endsection

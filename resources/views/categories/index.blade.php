@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Liste des catégories</h1>
        <a href="{{ route('categorie.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded">Nouvelle catégorie</a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    @if($categories->count())
        <table class="w-full table-auto bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $categorie)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $categorie->id }}</td>
                    <td class="px-4 py-2">{{ $categorie->nom_categorie }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('categorie.show', $categorie) }}" class="text-blue-600 mr-2">Voir</a>
                        <a href="{{ route('categorie.edit', $categorie) }}" class="text-yellow-600 mr-2">Modifier</a>
                        <form action="{{ route('categorie.destroy', $categorie) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cette catégorie ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    @else
        <p>Aucune catégorie trouvée.</p>
    @endif
</div>
@endsection

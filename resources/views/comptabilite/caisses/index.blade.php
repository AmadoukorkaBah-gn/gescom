@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Caisses</h1>
        <a href="{{ route('caisses.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Nouvelle Caisse
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($caisses as $caisse)
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-semibold text-gray-800">{{ $caisse->nom }}</h2>
                <span class="px-3 py-1 rounded-full text-sm font-bold {{ $caisse->solde >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ number_format($caisse->solde, 2) }} GNF
                </span>
            </div>
            
            <div class="flex space-x-2 mt-4">
                <a href="{{ route('caisses.show', $caisse) }}" 
                   class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-sm">
                    Détails
                </a>
                <a href="{{ route('caisses.edit', $caisse) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                    Modifier
                </a>
                <form action="{{ route('caisses.destroy', $caisse) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                        onclick="return confirm('Voulez-vous vraiment supprimer cette caisse ?')">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-8 text-gray-500">
            Aucune caisse trouvée. <a href="{{ route('caisses.create') }}" class="text-blue-500 hover:underline">Créer une caisse</a>
        </div>
        @endforelse
    </div>
</div>
@endsection

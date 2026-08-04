@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Utilisateurs</h1>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajouter un Utilisateur
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-orange-500">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">N°</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Nom</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Rôle</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Créé le</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr>
                    <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 text-sm font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-sm">
                        @php
                            $roleColors = [
                                'admin' => 'bg-purple-100 text-purple-800',
                                'gestionnaire' => 'bg-blue-100 text-blue-800',
                                'vendeur' => 'bg-green-100 text-green-800',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $roleColors[$user->role] ?? 'bg-gray-100' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex gap-2">
                            <a href="{{ route('users.edit', $user) }}" class="bg-yellow-100 text-yellow-800 p-2 rounded hover:bg-yellow-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13.5V15h1.5l7.5-7.5-1.5-1.5L9 13.5z" />
                                </svg>
                            </a>
                            @if($user->id !== auth()->id() && $user->parent_id === auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-800 p-2 rounded hover:bg-red-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 2h4a1 1 0 011 1v1H9V3a1 1 0 011-1z" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Aucun utilisateur trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

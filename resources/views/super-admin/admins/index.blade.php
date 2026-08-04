@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Administrateurs</h1>
        <a href="{{ route('super-admin.create-admin') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            ➕ Créer un Admin
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Nom</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Date création</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase">Statut</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium">{{ $admin->name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $admin->email }}</td>
                    <td class="px-4 py-3 text-sm">{{ $admin->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($admin->statut_abonnement == 'actif') bg-green-100 text-green-800
                            @elseif($admin->statut_abonnement == 'expire') bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($admin->statut_abonnement) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('super-admin.admins.edit', $admin) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                                ✏️ Modifier
                            </a>
                            @if($admin->statut_abonnement == 'suspendu')
                                <form action="{{ route('super-admin.reactiver', $admin) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                        ✅ Réactiver
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('super-admin.suspendre', $admin) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs"
                                            onclick="return confirm('Voulez-vous vraiment suspendre cet administrateur ?')">
                                        ⏸️ Suspendre
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                        Aucun administrateur trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $admins->links() }}
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Impression - Fournisseurs</h1>
        <button onclick="window.print()" class="bg-gray-700 text-white px-4 py-2 rounded">Imprimer</button>
    </div>

    <div class="bg-white shadow rounded p-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">#</th>
                    <th class="text-left py-2">Nom</th>
                    <th class="text-left py-2">Email</th>
                    <th class="text-left py-2">Téléphone</th>
                    <th class="text-left py-2">Adresse</th>
                </tr>
            </thead>
            <tbody>
                @foreach(App\Models\Fournisseur::all() as $fournisseur)
                <tr class="border-b">
                    <td class="py-2">{{ $loop->iteration }}</td>
                    <td class="py-2">{{ $fournisseur->nom_fournisseur }}</td>
                    <td class="py-2">{{ $fournisseur->email }}</td>
                    <td class="py-2">{{ $fournisseur->contact_fournisseur }}</td>
                    <td class="py-2">{{ $fournisseur->adresse_fournisseur }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

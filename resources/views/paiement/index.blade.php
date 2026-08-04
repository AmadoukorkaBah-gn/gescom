@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
	<div class="flex justify-between items-center mb-6">
		<h1 class="text-2xl font-bold text-gray-800">Liste des Paiements</h1>
		<a href="{{ route('paiement.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
			Nouveau Paiement
		</a>
	</div>

	@if(session('success'))
		<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
			{{ session('success') }}
		</div>
	@endif

	<div class="bg-white shadow-md rounded-lg overflow-hidden">
		<table class="min-w-full bg-white">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
					<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vente</th>
					<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
					<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant payé</th>
					<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
					<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-200">
				@foreach(\App\Models\Paiement::with(['vente.client'])->orderBy('date_paiement', 'desc')->get() as $paiement)
				<tr>
					<td class="px-4 py-2">{{ $paiement->id }}</td>
					<td class="px-4 py-2">#{{ $paiement->vente_id }}</td>
					<td class="px-4 py-2">{{ $paiement->vente->client->nom_client ?? '-' }}</td>
					<td class="px-4 py-2">{{ number_format($paiement->montant_paye, 2) }} GNF</td>
					<td class="px-4 py-2">{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('Y-m-d') }}</td>
					<td class="px-4 py-2">{{ ucfirst($paiement->mode) }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

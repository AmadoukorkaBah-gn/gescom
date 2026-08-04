@extends('layouts.app')

@section('content')
<div class="py-6">
	<div class="max-w-xl mx-auto bg-white shadow-sm rounded-lg p-8">
		<h1 class="text-2xl font-bold text-gray-800 mb-6">Détail du retour #{{ $retour->id }}</h1>
		<div class="space-y-4">
			<div>
				<span class="font-medium text-gray-700">Produit :</span>
				<span class="ml-2">{{ $retour->produit->nom_produit }}</span>
			</div>
			<div>
				<span class="font-medium text-gray-700">Vente :</span>
				<span class="ml-2">#{{ $retour->vente->id }}</span>
			</div>
			<div>
				<span class="font-medium text-gray-700">Quantité :</span>
				<span class="ml-2">{{ $retour->quantite }}</span>
			</div>
			<div>
				<span class="font-medium text-gray-700">Raison :</span>
				<span class="ml-2">{{ $retour->raison }}</span>
			</div>
			<div>
				<span class="font-medium text-gray-700">Date :</span>
				<span class="ml-2">{{ $retour->date_retour }}</span>
			</div>
		</div>
		<div class="mt-8 flex justify-end">
			<a href="{{ route('retours.index') }}" class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700 transition">Retour à la liste</a>
		</div>
	</div>
</div>
@endsection

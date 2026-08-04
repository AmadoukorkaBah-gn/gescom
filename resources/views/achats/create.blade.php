@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouveau Achat</h1>

    <form action="{{ route('achats.store') }}" method="POST" id="achatForm">
        @csrf

        {{-- Informations achat --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="fournisseur_id" class="block text-sm font-medium text-gray-700">Fournisseur</label>
                    <select name="fournisseur_id" id="fournisseur_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Sélectionner un fournisseur</option>
                        @foreach($fournisseurs as $f)
                            <option value="{{ $f->id }}">{{ $f->nom_fournisseur }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="date_achat" class="block text-sm font-medium text-gray-700">Date d'achat</label>
                    <input type="date" name="date_achat" id="date_achat" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="numero_facture" class="block text-sm font-medium text-gray-700">Numéro de facture</label>
                    <input type="text" name="numero_facture" id="numero_facture" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        </div>

        {{-- Produits --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Produits à acheter</h2>

            <div id="itemsContainer">
                <div class="item-row grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Produit</label>
                        <select name="items[0][produit_id]" class="produit-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Sélectionner un produit</option>
                            @foreach($produits as $p)
                                <option value="{{ $p->id }}">{{ $p->nom_produit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantité</label>
                        <input type="number" name="items[0][quantite]" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix unitaire</label>
                        <input type="number" step="0.01" name="items[0][prix_unitaire]" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de péremption</label>
                        <input type="date" name="items[0][date_peremption]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="flex items-end">
                        <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" style="display: none;">Supprimer</button>
                    </div>
                </div>
            </div>

            <button type="button" id="addItem" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Ajouter un produit
            </button>
        </div>

        {{-- Actions --}}
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer l'achat
            </button>
            <a href="{{ route('achats.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Annuler</a>
        </div>
    </form>
</div>

{{-- Script JS pour gérer l'ajout/suppression des lignes --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    document.getElementById('addItem').addEventListener('click', function() {
        const container = document.getElementById('itemsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'item-row grid grid-cols-1 md:grid-cols-5 gap-4 mb-4';
        newRow.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700">Produit</label>
                <select name="items[${itemIndex}][produit_id]" class="produit-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Sélectionner un produit</option>
                    @foreach($produits as $p)
                        <option value="{{ $p->id }}">{{ $p->nom_produit }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Quantité</label>
                <input type="number" name="items[${itemIndex}][quantite]" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Prix unitaire</label>
                <input type="number" step="0.01" name="items[${itemIndex}][prix_unitaire]" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date de péremption</label>
                <input type="date" name="items[${itemIndex}][date_peremption]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="flex items-end">
                <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</button>
            </div>
        `;
        container.appendChild(newRow);
        itemIndex++;

        // Afficher les boutons supprimer si plus d'une ligne
        document.querySelectorAll('.remove-item').forEach(btn => btn.style.display = 'block');
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
            // Masquer le bouton supprimer si une seule ligne reste
            if (document.querySelectorAll('.item-row').length === 1) {
                document.querySelector('.remove-item').style.display = 'none';
            }
        }
    });
});
</script>
@endsection

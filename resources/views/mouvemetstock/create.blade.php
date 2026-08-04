@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouveau Approvisionnement</h1>

    <form action="{{ route('mouvement.store') }}" method="POST" id="achatForm">
        @csrf

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    <label for="date" class="block text-sm font-medium text-gray-700">Date d'approvisionnement</label>
                    <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Produits à approvisionner</h2>

            <div id="itemsContainer">
                <div class="item-row grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
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

                    <div class="flex items-end">
                        <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" style="display: none;">Supprimer</button>
                    </div>
                </div>
            </div>

            <button type="button" id="addItem" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Ajouter un produit
            </button>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer l'approvisionnement
            </button>
            <a href="{{ route('mouvement.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Annuler</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    document.getElementById('addItem').addEventListener('click', function() {
        const container = document.getElementById('itemsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'item-row grid grid-cols-1 md:grid-cols-3 gap-4 mb-4';
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
            <div class="flex items-end">
                <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</button>
            </div>
        `;
        container.appendChild(newRow);
        itemIndex++;

        // Show remove buttons if more than one item
        document.querySelectorAll('.remove-item').forEach(btn => btn.style.display = 'block');
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
            // Hide remove buttons if only one item left
            if (document.querySelectorAll('.item-row').length === 1) {
                document.querySelector('.remove-item').style.display = 'none';
            }
        }
    });
});
</script>
@endsection

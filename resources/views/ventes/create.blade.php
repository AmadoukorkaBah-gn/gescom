@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvelle Vente</h1>

    <form action="{{ route('ventes.store') }}" method="POST" id="venteForm">
        @csrf

        {{-- Client et Date --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                    <select name="client_id" id="client_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Sélectionner un client</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}">{{ $c->nom_client }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="date_vente" class="block text-sm font-medium text-gray-700">Date de vente</label>
                    <input type="date" name="date_vente" id="date_vente" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>
        </div>

        {{-- Produits --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Produits vendus</h2>

            <div id="itemsContainer">
                <div class="item-row grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Produit</label>
                        <select name="items[0][produit_id]" class="produit-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Sélectionner un produit</option>
                            @foreach($produits as $p)
                                <option value="{{ $p->id }}" data-stock="{{ $p->stockActuel() }}" data-prix="{{ $p->prix_vente }}">
                                    {{ $p->nom_produit }} (Stock: {{ $p->stockActuel() }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantité</label>
                        <input type="number" name="items[0][quantite]" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm quantite-input" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix unitaire</label>
                        <input type="number" step="0.01" name="items[0][prix_unitaire]" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm prix-input" readonly required>
                    </div>

                    <div class="flex items-center">
                        <span class="stock-info text-sm text-gray-600"></span>
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

        {{-- Remise --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Remise</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="type_remise" class="block text-sm font-medium text-gray-700">Type de remise</label>
                    <select name="type_remise" id="type_remise" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Aucune remise</option>
                        <option value="fixe">Montant fixe (GNF)</option>
                        <option value="pourcentage">Pourcentage (%)</option>
                    </select>
                </div>
                <div>
                    <label for="valeur_remise" class="block text-sm font-medium text-gray-700">Valeur</label>
                    <input type="number" step="0.01" min="0" name="valeur_remise" id="valeur_remise" value="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        </div>

        {{-- Totaux --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex justify-end">
                <div class="w-full md:w-1/3 space-y-2 text-right">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sous-total :</span>
                        <span id="sousTotalDisplay" class="font-medium">0 GNF</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Remise :</span>
                        <span id="remiseDisplay" class="font-medium text-red-600">- 0 GNF</span>
                    </div>
                    <div class="flex justify-between border-t pt-2">
                        <span class="text-gray-800 font-semibold">Total à payer :</span>
                        <span id="totalDisplay" class="font-bold text-lg">0 GNF</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enregistrer la vente
            </button>
            <a href="{{ route('ventes.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Annuler</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    function updateStockInfo(row) {
        const select = row.querySelector('.produit-select');
        const stockInfo = row.querySelector('.stock-info');
        const prixInput = row.querySelector('.prix-input');
        const selectedOption = select.options[select.selectedIndex];

        if (selectedOption && selectedOption.value) {
            stockInfo.textContent = "Stock disponible: " + selectedOption.dataset.stock;
            const qtyInput = row.querySelector('.quantite-input');
            qtyInput.max = selectedOption.dataset.stock;

            // Auto-remplissage du prix de vente
            if (selectedOption.dataset.prix) {
                prixInput.value = selectedOption.dataset.prix;
            }
        } else {
            stockInfo.textContent = "";
        }
        calculerTotaux();
    }

    function calculerTotaux() {
        let sousTotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qte = parseFloat(row.querySelector('.quantite-input').value) || 0;
            const prix = parseFloat(row.querySelector('.prix-input').value) || 0;
            sousTotal += qte * prix;
        });

        const typeRemise = document.getElementById('type_remise').value;
        const valeurRemise = parseFloat(document.getElementById('valeur_remise').value) || 0;

        let remise = 0;
        if (typeRemise === 'fixe') {
            remise = Math.min(valeurRemise, sousTotal);
        } else if (typeRemise === 'pourcentage') {
            remise = sousTotal * (Math.min(valeurRemise, 100) / 100);
        }

        const total = sousTotal - remise;

        document.getElementById('sousTotalDisplay').textContent = sousTotal.toLocaleString('fr-FR') + ' GNF';
        document.getElementById('remiseDisplay').textContent = '- ' + remise.toLocaleString('fr-FR') + ' GNF';
        document.getElementById('totalDisplay').textContent = total.toLocaleString('fr-FR') + ' GNF';
    }

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('produit-select')) {
            updateStockInfo(e.target.closest('.item-row'));
        }
        if (e.target.id === 'type_remise' || e.target.id === 'valeur_remise') {
            calculerTotaux();
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantite-input') || e.target.classList.contains('prix-input') || e.target.id === 'valeur_remise') {
            calculerTotaux();
        }
    });

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
                        <option value="{{ $p->id }}" data-stock="{{ $p->stockActuel() }}" data-prix="{{ $p->prix_vente }}">{{ $p->nom_produit }} (Stock: {{ $p->stockActuel() }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Quantité</label>
                <input type="number" name="items[${itemIndex}][quantite]" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm quantite-input" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Prix unitaire</label>
                <input type="number" step="0.01" name="items[${itemIndex}][prix_unitaire]" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm prix-input" readonly required>
            </div>
            <div class="flex items-center">
                <span class="stock-info text-sm text-gray-600"></span>
            </div>
            <div class="flex items-end">
                <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</button>
            </div>
        `;
        container.appendChild(newRow);
        itemIndex++;
        document.querySelectorAll('.remove-item').forEach(btn => btn.style.display = 'block');
        updateStockInfo(newRow);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
            if (document.querySelectorAll('.item-row').length === 1) {
                document.querySelector('.remove-item').style.display = 'none';
            }
            calculerTotaux();
        }
    });

    updateStockInfo(document.querySelector('.item-row'));
});
</script>
@endsection
@php
    $config = \App\Models\Configuration::getForCurrentUser();
    $devise = $config ? $config->symbole_devise : 'GNF';
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de vente #{{ $vente->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #fff;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            color: #666;
        }
        
        .receipt-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            font-size: 13px;
        }
        
        .receipt-info-block h3 {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: #333;
        }
        
        .receipt-info-block p {
            margin: 3px 0;
            line-height: 1.6;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            font-size: 13px;
        }
        
        table thead {
            background-color: #f5f5f5;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
        }
        
        table th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        table tbody tr:last-child td {
            border-bottom: 2px solid #333;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .totals {
            display: grid;
            grid-template-columns: 1fr 200px;
            gap: 20px;
            margin: 30px 0;
            font-size: 13px;
        }
        
        .totals-section {
            grid-column: 2;
        }
        
        .totals-row {
            display: grid;
            grid-template-columns: 1fr 100px;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        
        .totals-row.total {
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            font-weight: bold;
            font-size: 14px;
            padding: 10px 0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
            color: #999;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .thank-you {
            text-align: center;
            font-style: italic;
            margin: 20px 0;
            color: #666;
        }
        
        @media print {
            body {
                background-color: #fff;
            }
            .container {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            @if($config && $config->logo)
                <img src="{{ public_path('storage/' . $config->logo) }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
            @endif
            <h1>{{ $config && $config->nom_entreprise ? $config->nom_entreprise : 'REÇU DE VENTE' }}</h1>
            @if($config && $config->adresse)
                <p>{{ $config->adresse }}</p>
            @endif
            @if($config && $config->contact)
                <p>Tél: {{ $config->contact }}</p>
            @endif
            @if($config && $config->email_entreprise)
                <p>Email: {{ $config->email_entreprise }}</p>
            @endif
            <p style="margin-top: 10px; font-weight: bold;">Vente N°{{ $vente->id }}</p>
        </div>
        
        <!-- Receipt Info -->
        <div class="receipt-info">
            <div class="receipt-info-block">
                <h3>Informations de vente</h3>
                <p><strong>Date:</strong> {{ $vente->date_vente->format('d/m/Y H:i') }}</p>
                <p><strong>Numéro de vente:</strong> N°{{ $vente->id }}</p>
                <p><strong>Statut:</strong> {{ ucfirst(str_replace('_', ' ', $vente->statut)) }}</p>
            </div>
            
            <div class="receipt-info-block">
                <h3>Client</h3>
                <p><strong>{{ $vente->client->nom_client }}</strong></p>
                @if($vente->client->email)
                    <p>{{ $vente->client->email }}</p>
                @endif
                @if($vente->client->telephone)
                    <p>{{ $vente->client->telephone }}</p>
                @endif
                @if($vente->client->adresse)
                    <p>{{ $vente->client->adresse }}</p>
                @endif
            </div>
        </div>
        
        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th class="text-right">Quantité</th>
                    <th class="text-right">Prix Unitaire</th>
                    <th class="text-right">Sous-total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vente->details as $detail)
                    <tr>
                        <td>{{ $detail->produit->nom_produit }}</td>
                        <td class="text-right">{{ $detail->quantite }}</td>
                        <td class="text-right">{{ number_format($detail->prix_unitaire, 2, ',', ' ') }} {{ $devise }}</td>
                        <td class="text-right">{{ number_format($detail->quantite * $detail->prix_unitaire, 2, ',', ' ') }} {{ $devise }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Totals -->
        <div class="totals">
            <div></div>
            <div class="totals-section">
                <div class="totals-row">
                    <span>Sous-total:</span>
                    <span class="text-right">{{ number_format($vente->montant_total, 2, ',', ' ') }} {{ $devise }}</span>
                </div>
                <div class="totals-row total">
                    <span>TOTAL:</span>
                    <span class="text-right">{{ number_format($vente->montant_total, 2, ',', ' ') }} {{ $devise }}</span>
                </div>
            </div>
        </div>
        
        <!-- Thank You -->
        <div class="thank-you">
            <p>Merci pour votre achat!</p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Reçu généré le {{ now()->format('d/m/Y à H:i:s') }}</p>
            <p>Veuillez conserver ce reçu comme preuve d'achat</p>
        </div>
    </div>
</body>
</html>

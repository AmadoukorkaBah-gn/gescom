<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        h1 { font-size: 16px; margin-bottom: 4px; }
        .periode { color: #666; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background-color: #f3f4f6; }
        tfoot td { font-weight: bold; background-color: #f9fafb; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Liste des ventes</h1>
    <div class="periode">
        @if($dateDebut || $dateFin)
            Période : {{ $dateDebut ? \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') : '...' }}
            au {{ $dateFin ? \Carbon\Carbon::parse($dateFin)->format('d/m/Y') : "aujourd'hui" }}
        @else
            Toutes les ventes
        @endif
        — Généré le {{ now()->format('d/m/Y à H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Date</th>
                <th>Client</th>
                <th class="text-right">Montant brut</th>
                <th class="text-right">Remise</th>
                <th class="text-right">Total</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventes as $vente)
                <tr>
                    <td>{{ $vente->id }}</td>
                    <td>{{ $vente->date_vente->format('d/m/Y H:i') }}</td>
                    <td>{{ $vente->client->nom_client ?? '-' }}</td>
                    <td class="text-right">{{ number_format($vente->montant_brut ?? $vente->montant_total, 2, ',', ' ') }}</td>
                    <td class="text-right">{{ number_format($vente->montant_remise ?? 0, 2, ',', ' ') }}</td>
                    <td class="text-right">{{ number_format($vente->montant_total, 2, ',', ' ') }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $vente->statut)) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">Total général</td>
                <td class="text-right">{{ number_format($ventes->sum('montant_total'), 2, ',', ' ') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
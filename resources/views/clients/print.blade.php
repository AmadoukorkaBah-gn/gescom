<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impression - Clients</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body>
    <h1>Liste des Clients</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Contact</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $client->nom_client }}</td>
                <td>{{ $client->contact_client }}</td>
                <td>{{ $client->adresse_client }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
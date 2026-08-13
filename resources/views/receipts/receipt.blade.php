@php
    $config = \App\Models\Configuration::getForCurrentUser();
    $devise = $config ? $config->symbole_devise : 'GNF';

    // Sécurisation des montants
    $montantBrut = (float) ($vente->montant_brut ?? 0);
    $montantRemise = (float) ($vente->montant_remise ?? 0);
    $montantTotal = (float) ($vente->montant_total ?? 0);
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reçu de vente N°{{ $vente->id }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, Helvetica, sans-serif;
            background: #eef2f7;
            color: #1f2937;
            line-height: 1.5;
            font-size: 13px;
        }

        .page {
            width: 100%;
            padding: 35px 15px;
        }

        .receipt {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.10);
        }

        /* =====================================================
           BANDEAU SUPÉRIEUR
        ====================================================== */

        .top-bar {
            height: 7px;
            background: #2563eb;
        }

        /* =====================================================
           EN-TÊTE
        ====================================================== */

        .header {
            padding: 32px 40px 25px;
            border-bottom: 1px solid #e5e7eb;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .company {
            display: table-cell;
            width: 65%;
            vertical-align: middle;
        }

        .receipt-title {
            display: table-cell;
            width: 35%;
            text-align: right;
            vertical-align: middle;
        }

        .logo {
            max-height: 70px;
            max-width: 150px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.4px;
            margin-bottom: 5px;
        }

        .company-info {
            color: #6b7280;
            font-size: 12px;
            line-height: 1.7;
        }

        .receipt-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .receipt-number {
            font-size: 22px;
            font-weight: 800;
            color: #2563eb;
        }

        /* =====================================================
           INFORMATIONS
        ====================================================== */

        .information {
            padding: 25px 40px;
        }

        .info-grid {
            display: table;
            width: 100%;
            border-spacing: 12px 0;
            margin-left: -12px;
        }

        .info-card {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px 18px;
        }

        .info-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #2563eb;
            margin-bottom: 11px;
        }

        .info-line {
            margin-bottom: 5px;
            color: #4b5563;
        }

        .info-line:last-child {
            margin-bottom: 0;
        }

        .info-line strong {
            color: #111827;
        }

        /* =====================================================
           TABLEAU
        ====================================================== */

        .products {
            padding: 0 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #1e3a8a;
            color: white;
        }

        th {
            padding: 12px 14px;
            text-align: left;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 13px 14px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
            font-size: 12px;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: 1px solid #cbd5e1;
        }

        .product-name {
            font-weight: 700;
            color: #111827;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* =====================================================
           REMISE
        ====================================================== */

        .remise-info {
            margin: 20px 40px 0;
            padding: 12px 15px;
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-left: 4px solid #f97316;
            border-radius: 7px;
            color: #9a3412;
            font-size: 12px;
        }

        /* =====================================================
           TOTAUX
        ====================================================== */

        .totals-wrapper {
            display: table;
            width: 100%;
            padding: 25px 40px 5px;
        }

        .totals-spacer {
            display: table-cell;
            width: 55%;
        }

        .totals {
            display: table-cell;
            width: 45%;
        }

        .total-row {
            display: table;
            width: 100%;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .total-label {
            display: table-cell;
            color: #6b7280;
        }

        .total-value {
            display: table-cell;
            text-align: right;
            font-weight: 700;
            color: #374151;
        }

        .discount {
            color: #dc2626;
        }

        .grand-total {
            margin-top: 8px;
            padding: 13px 15px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 9px;
        }

        .grand-total .total-label {
            font-weight: 800;
            color: #1e40af;
            font-size: 13px;
        }

        .grand-total .total-value {
            color: #1d4ed8;
            font-size: 16px;
            font-weight: 900;
        }

        /* =====================================================
           MESSAGE
        ====================================================== */

        .thank-you {
            margin: 25px 40px;
            padding: 15px;
            text-align: center;
            background: #f8fafc;
            border-radius: 8px;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
        }

        .thank-you-icon {
            font-size: 18px;
            margin-bottom: 3px;
        }

        /* =====================================================
           FOOTER
        ====================================================== */

        .footer {
            padding: 20px 40px 25px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #94a3b8;
            font-size: 10px;
            line-height: 1.8;
        }

        .footer strong {
            color: #64748b;
        }

        /* =====================================================
           IMPRESSION
        ====================================================== */

        @media print {

            @page {
                size: A4;
                margin: 12mm;
            }

            body {
                background: white;
                font-size: 12px;
            }

            .page {
                padding: 0;
            }

            .receipt {
                max-width: none;
                box-shadow: none;
                border-radius: 0;
            }

            .top-bar {
                height: 5px;
            }

            .header {
                padding: 20px 25px;
            }

            .information {
                padding: 18px 25px;
            }

            .products {
                padding: 0 25px;
            }

            .remise-info {
                margin-left: 25px;
                margin-right: 25px;
            }

            .totals-wrapper {
                padding-left: 25px;
                padding-right: 25px;
            }

            .thank-you {
                margin-left: 25px;
                margin-right: 25px;
            }

            .footer {
                padding-left: 25px;
                padding-right: 25px;
            }

            thead {
                background: #1e3a8a !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .grand-total {
                background: #eff6ff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            tbody tr:nth-child(even) {
                background: #f8fafc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* =====================================================
           MOBILE
        ====================================================== */

        @media screen and (max-width: 650px) {

            body {
                background: #f1f5f9;
            }

            .page {
                padding: 10px;
            }

            .receipt {
                border-radius: 10px;
            }

            .header {
                padding: 22px 20px;
            }

            .header-content,
            .company,
            .receipt-title {
                display: block;
                width: 100%;
                text-align: center;
            }

            .receipt-title {
                margin-top: 18px;
            }

            .company-name {
                font-size: 20px;
            }

            .information {
                padding: 20px;
            }

            .info-grid {
                display: block;
                margin-left: 0;
            }

            .info-card {
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }

            .info-card:last-child {
                margin-bottom: 0;
            }

            .products {
                padding: 0 10px;
                overflow-x: auto;
            }

            th,
            td {
                white-space: nowrap;
            }

            .remise-info {
                margin: 15px 20px 0;
            }

            .totals-wrapper {
                display: block;
                padding: 20px;
            }

            .totals-spacer {
                display: none;
            }

            .totals {
                display: block;
                width: 100%;
            }

            .thank-you {
                margin: 20px;
            }

            .footer {
                padding: 18px 20px;
            }
        }
    </style>
</head>

<body>

<div class="page">

    <div class="receipt">

        <div class="top-bar"></div>

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}

        <div class="header">

            <div class="header-content">

                <div class="company">

                    @if($config && $config->logo)

                        <img
                            src="{{ public_path('storage/' . $config->logo) }}"
                            alt="Logo"
                            class="logo"
                        >

                    @endif

                    <div class="company-name">

                        {{ $config && $config->nom_entreprise
                            ? $config->nom_entreprise
                            : 'REÇU DE VENTE' }}

                    </div>

                    <div class="company-info">

                        @if($config && $config->adresse)
                            <div>{{ $config->adresse }}</div>
                        @endif

                        @if($config && $config->contact)
                            <div>Tél : {{ $config->contact }}</div>
                        @endif

                        @if($config && $config->email_entreprise)
                            <div>{{ $config->email_entreprise }}</div>
                        @endif

                    </div>

                </div>


                <div class="receipt-title">

                    <div class="receipt-label">
                        Reçu de vente
                    </div>

                    <div class="receipt-number">
                        N°{{ $vente->id }}
                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             INFORMATIONS
        ====================================================== --}}

        <div class="information">

            <div class="info-grid">

                {{-- Vente --}}

                <div class="info-card">

                    <div class="info-title">
                        Informations de vente
                    </div>

                    <div class="info-line">
                        <strong>Date :</strong>
                        {{ $vente->date_vente->format('d/m/Y H:i') }}
                    </div>

                    <div class="info-line">
                        <strong>Numéro :</strong>
                        N°{{ $vente->id }}
                    </div>

                    <div class="info-line">
                        <strong>Statut :</strong>
                        {{ ucfirst(str_replace('_', ' ', $vente->statut)) }}
                    </div>

                </div>


                {{-- Client --}}

                <div class="info-card">

                    <div class="info-title">
                        Informations client
                    </div>

                    <div class="info-line">
                        <strong>{{ $vente->client->nom_client }}</strong>
                    </div>

                    @if($vente->client->email)
                        <div class="info-line">
                            {{ $vente->client->email }}
                        </div>
                    @endif

                    @if($vente->client->telephone)
                        <div class="info-line">
                            {{ $vente->client->telephone }}
                        </div>
                    @endif

                    @if($vente->client->adresse)
                        <div class="info-line">
                            {{ $vente->client->adresse }}
                        </div>
                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
             PRODUITS
        ====================================================== --}}

        <div class="products">

            <table>

                <thead>

                    <tr>

                        <th>
                            Produit
                        </th>

                        <th class="text-right">
                            Quantité
                        </th>

                        <th class="text-right">
                            Prix unitaire
                        </th>

                        <th class="text-right">
                            Sous-total
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($vente->details as $detail)

                        <tr>

                            <td class="product-name">
                                {{ $detail->produit->nom_produit }}
                            </td>

                            <td class="text-right">
                                {{ $detail->quantite }}
                            </td>

                            <td class="text-right">

                                {{ number_format(
                                    $detail->prix_unitaire,
                                    2,
                                    ',',
                                    ' '
                                ) }}

                                {{ $devise }}

                            </td>

                            <td class="text-right">

                                {{ number_format(
                                    $detail->quantite * $detail->prix_unitaire,
                                    2,
                                    ',',
                                    ' '
                                ) }}

                                {{ $devise }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             REMISE
        ====================================================== --}}

        @if($montantRemise > 0)

            <div class="remise-info">

                <strong>Remise accordée :</strong>

                @if($vente->type_remise === 'pourcentage')

                    {{ number_format(
                        (float) $vente->valeur_remise,
                        2,
                        ',',
                        ' '
                    ) }} %

                @elseif($vente->type_remise === 'fixe')

                    Remise fixe

                @endif

                &nbsp;—

                {{ number_format(
                    $montantRemise,
                    2,
                    ',',
                    ' '
                ) }}

                {{ $devise }}

            </div>

        @endif


        {{-- =====================================================
             TOTAUX
        ====================================================== --}}

        <div class="totals-wrapper">

            <div class="totals-spacer"></div>

            <div class="totals">

                {{-- Sous-total --}}

                <div class="total-row">

                    <span class="total-label">
                        Sous-total
                    </span>

                    <span class="total-value">

                        {{ number_format(
                            $montantBrut,
                            2,
                            ',',
                            ' '
                        ) }}

                        {{ $devise }}

                    </span>

                </div>


                {{-- Remise --}}

                @if($montantRemise > 0)

                    <div class="total-row">

                        <span class="total-label discount">
                            Remise
                        </span>

                        <span class="total-value discount">

                            - {{ number_format(
                                $montantRemise,
                                2,
                                ',',
                                ' '
                            ) }}

                            {{ $devise }}

                        </span>

                    </div>

                @endif


                {{-- Total --}}

                <div class="grand-total">

                    <div class="total-row" style="border: none; padding: 0;">

                        <span class="total-label">
                            TOTAL À PAYER
                        </span>

                        <span class="total-value">

                            {{ number_format(
                                $montantTotal,
                                2,
                                ',',
                                ' '
                            ) }}

                            {{ $devise }}

                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             MESSAGE
        ====================================================== --}}

        <div class="thank-you">

            <div class="thank-you-icon">
                ✓
            </div>

            Merci pour votre achat et pour votre confiance.

        </div>


        {{-- =====================================================
             PIED DE PAGE
        ====================================================== --}}

        <div class="footer">

            <p>
                Reçu généré le
                <strong>{{ now()->format('d/m/Y à H:i:s') }}</strong>
            </p>

            <p>
                Veuillez conserver ce document comme preuve d'achat.
            </p>

            @if($config && $config->nom_entreprise)

                <p>
                    <strong>{{ $config->nom_entreprise }}</strong>
                    — Merci de votre confiance.
                </p>

            @endif

        </div>

    </div>

</div>

</body>
</html>
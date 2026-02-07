<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture Client - OUCHRIF</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica Neue', 'Helvetica', sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 80px 60px;
            background: #ffffff;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        /* Header */
        .header {
            margin-bottom: 80px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 40px;
        }

        .header table {
            width: 100%;
        }

        .logo {
            width: 180px;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: 900;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 2px;
            line-height: 1;
        }

        .date {
            font-size: 14px;
            color: #94a3b8;
            font-weight: 700;
            margin-top: 5px;
        }

        /* Information Grid */
        .info-grid {
            margin-bottom: 60px;
        }

        .info-grid table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-label {
            font-size: 10px;
            font-weight: 900;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            line-height: 1.5;
        }

        /* Table Styling */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .items-table th {
            background: #f8fafc;
            color: #64748b;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }

        .items-table td {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }

        .product-name {
            font-weight: 700;
            color: #1e293b;
        }

        .product-cat {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 600;
        }

        /* Totals */
        .totals {
            float: right;
            width: 300px;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 10px 0;
            font-size: 14px;
        }

        .total-row-main {
            border-top: 2px solid #f1f5f9;
            margin-top: 10px;
            padding-top: 20px !important;
        }

        .grand-total-label {
            font-size: 12px;
            font-weight: 900;
            color: #1e293b;
            text-transform: uppercase;
        }

        .grand-total-value {
            font-size: 24px;
            font-weight: 900;
            color: #4f46e5;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 60px;
            left: 60px;
            right: 60px;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 30px;
            font-size: 10px;
            color: #94a3b8;
            font-weight: 600;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <table>
                <tr>
                    <td>
                        <img src="{{ public_path('images/ouchrif_icons.png') }}" class="logo">
                    </td>
                    <td style="text-align: right;">
                        <div class="invoice-title">Facture</div>
                        <div class="date">Émise le {{ $order->created_at->format('d/m/Y') }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Addresses -->
        <div class="info-grid">
            <table>
                <tr>
                    <td width="50%">
                        <div class="info-label">Facturé à</div>
                        <div class="info-value">
                            <span style="font-size: 18px; color: #1e293b;">{{ $order->full_name }}</span><br>
                            {{ $order->address }}<br>
                            Tel: {{ $order->phone }}<br>
                            Email: {{ $order->email }}
                        </div>
                    </td>
                    <td width="50%" style="text-align: right; vertical-align: top;">
                        <div class="info-label">Expéditeur</div>
                        <div class="info-value">
                            OUCHRIF STORE<br>
                            Casablanca, Maroc<br>
                            contact@ouchrif.com<br>
                            www.ouchrif.com
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Status & Method -->
        <div style="margin-bottom: 40px; padding: 20px; background: #f8fafc; border-radius: 15px;">
            <table width="100%">
                <tr>
                    <td>
                        <div class="info-label" style="margin-bottom:5px;">Mode de Paiement</div>
                        <div style="font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase;">
                            {{ $order->payment_method === 'online' ? 'Transaction Sécurisée (Stripe)' : 'Paiement à la Livraison' }}
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <div class="info-label" style="margin-bottom:5px;">État du Paiement</div>
                        <div
                            style="font-size: 12px; font-weight: 800; color: {{ $order->payment_status === 'paid' ? '#10b981' : '#f59e0b' }}; text-transform: uppercase;">
                            {{ $order->payment_status === 'paid' ? 'Payée' : 'En Attente' }}
                        </div>
                        <div
                            style="margin-top: 5px; font-size: 10px; color: #666; font-weight: bold; text-transform: uppercase;">
                            Livraison: {{ $order->status }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Désignation de l'article</th>
                    <th style="text-align: center;">Quantité</th>
                    <th style="text-align: right;">Prix Unit.</th>
                    <th style="text-align: right;">Montant HT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="product-name">{{ $item->produit->name_produit }}</div>
                            <div class="product-cat">{{ $item->produit->categorie->name_categorie ?? 'Standard' }}</div>
                        </td>
                        <td style="text-align: center; font-weight: 800;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">{{ number_format($item->price, 2) }} DH</td>
                        <td style="text-align: right; font-weight: 800;">
                            {{ number_format($item->price * $item->quantity, 2) }} DH
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr>
                    <td style="color: #64748b;">Sous-total</td>
                    <td style="text-align: right; font-weight: 700;">{{ number_format($order->total_amount, 2) }} DH
                    </td>
                </tr>
                <tr>
                    <td style="color: #64748b;">Livraison</td>
                    <td style="text-align: right; font-weight: 700;">0.00 DH</td>
                </tr>
                <tr class="total-row-main">
                    <td class="grand-total-label">Net à Payer</td>
                    <td style="text-align: right;" class="grand-total-value">
                        {{ number_format($order->total_amount, 2) }} DH
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            Ceci est un document officiel généré par OUCHRIF Management System.<br>
            Merci de votre commande et à bientôt sur <strong>ouchrif.com</strong>
        </div>
    </div>
</body>

</html>
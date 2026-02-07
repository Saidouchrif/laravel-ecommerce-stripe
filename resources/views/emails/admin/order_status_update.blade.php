<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mise à jour Commande - Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #1a1a1a;
            padding: 30px;
            text-align: center;
            color: #fff;
        }

        .header h2 {
            margin: 0;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .status-header {
            background: #f8fafc;
            padding: 15px;
            border-bottom: 2px solid #e2e8f0;
            text-align: center;
            font-weight: bold;
        }

        .content {
            padding: 40px;
        }

        .section {
            margin-bottom: 30px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 15px;
            display: block;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .info-row {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .info-label {
            font-weight: 700;
            color: #1e293b;
            width: 140px;
            display: inline-block;
        }

        .product-card {
            background: #fdfdfd;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .total-box {
            background: #1a1a1a;
            color: #fff;
            padding: 20px;
            border-radius: 12px;
            text-align: right;
            margin-top: 20px;
        }

        .total-label {
            font-size: 12px;
            font-weight: 800;
            opacity: 0.7;
            text-transform: uppercase;
        }

        .total-amount {
            font-size: 24px;
            font-weight: 900;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @if(isset($logoPath))
                <img src="{{ $message->embed($logoPath) }}" alt="Logo" style="height: 40px; margin-bottom: 15px;">
            @endif
            <h2>OUCHRIF STORE</h2>
        </div>

        <div class="status-header" style="color: {{ $order->status === 'annuler' ? '#e11d48' : '#059669' }}">
            STATUT COMMANDE : {{ strtoupper($statusLabel) }}
        </div>

        <div class="content">
            <div class="section">
                <span class="section-title">Informations Client</span>
                <div class="info-row"><span class="info-label">Client :</span> {{ $order->full_name }}</div>
                <div class="info-row"><span class="info-label">Email :</span> {{ $order->email }}</div>
                <div class="info-row"><span class="info-label">Téléphone :</span> {{ $order->phone }}</div>
                <div class="info-row"><span class="info-label">Adresse :</span> {{ $order->address }}</div>
            </div>

            <div class="section">
                <span class="section-title">Détails Commande</span>
                <div class="info-row"><span class="info-label">Commande :</span> #{{ $order->id_order }}</div>
                <div class="info-row"><span class="info-label">Date achat :</span>
                    {{ $order->created_at->format('d/m/Y H:i') }}</div>
                <div class="info-row"><span class="info-label">Paiement :</span>
                    {{ $order->payment_method === 'cash' ? 'Cash on Delivery' : 'Online (Paid)' }}</div>
            </div>

            <div class="section" style="border-bottom: none;">
                <span class="section-title">Produit commandé</span>
                <div class="product-card">
                    <div style="flex: 1;">
                        <div style="font-weight: 800; font-size: 16px; color: #0f172a;">
                            {{ $product->name_produit ?? 'Produit inconnu' }}</div>
                        <div style="font-size: 14px; color: #64748b; margin-top: 4px;">
                            Quantité : {{ $order->items->first()->quantity ?? 1 }} unité(s)
                        </div>
                    </div>
                    <div style="font-weight: 900; color: #1a1a1a; font-size: 18px;">
                        {{ number_format($order->total_amount, 2) }} DH
                    </div>
                </div>
            </div>

            <div class="total-box">
                <span class="total-label">Montant Total de la Commande</span>
                <span class="total-amount">{{ number_format($order->total_amount, 2) }} DH</span>
            </div>
        </div>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Nouvelle Commande Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
        }

        .header {
            background: #f8f8f8;
            padding: 10px;
            text-align: center;
            border-bottom: 2px solid #ddd;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #555;
        }

        .detail-row {
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #fafafa;
            padding: 10px;
            border-radius: 5px;
        }

        .total {
            font-size: 1.2em;
            font-weight: bold;
            color: #d32f2f;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ $message->embed($logoPath) }}" alt="Logo" style="height: 50px;">
            <h2>Nouvelle commande reçue !</h2>
        </div>

        <div class="section">
            <div class="section-title">Informations Client</div>
            <div class="detail-row"><span class="label">Nom complet :</span> {{ $order->full_name }}</div>
            <div class="detail-row"><span class="label">Email :</span> {{ $order->email }}</div>
            <div class="detail-row"><span class="label">Téléphone :</span> {{ $order->phone }}</div>
            <div class="detail-row"><span class="label">Adresse :</span> {{ $order->address }}</div>
        </div>

        <div class="section">
            <div class="section-title">Détails de la Commande</div>
            <div class="detail-row"><span class="label">ID Commande :</span> #{{ $order->id_order }}</div>
            <div class="detail-row"><span class="label">Date :</span> {{ $order->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="detail-row"><span class="label">Mode paiement :</span>
                {{ $order->payment_method === 'cash' ? 'Paiement à la livraison' : 'Paiement en ligne' }}</div>
            <div class="detail-row"><span class="label">Statut paiement :</span> {{ $order->payment_status }}</div>
        </div>

        <div class="section">
            <div class="section-title">Produit</div>
            <div class="product-info">
                @if($productPath && file_exists($productPath))
                    <img src="{{ $message->embed($productPath) }}" alt="Produit" width="60" height="60"
                        style="object-fit: contain; border: 1px solid #ddd;">
                @else
                    <div
                        style="width: 60px; height: 60px; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">
                        No Image</div>
                @endif
                <div>
                    <div><strong>{{ $produit->name_produit_fr ?? $produit->name_produit }}</strong></div>
                    <div>Prix unitaire : {{ number_format($produit->price, 0) }} DH</div>
                    <div>Quantité : {{ $quantity }}</div>
                    <div class="total">Total Article : {{ number_format($total, 0) }} DH</div>
                </div>
            </div>
        </div>

        <div class="section" style="text-align: right; border-top: 2px solid #eee; padding-top: 10px;">
            <div class="total">MONTANT TOTAL DE LA COMMANDE : {{ number_format($order->total_amount, 0) }} DH</div>
        </div>
    </div>
</body>

</html>
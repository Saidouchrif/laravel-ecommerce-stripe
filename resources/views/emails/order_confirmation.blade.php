<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f7f9fa;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .header {
            background-color: #1a1a1a;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
        }

        .success-icon {
            text-align: center;
            margin-bottom: 20px;
            font-size: 40px;
        }

        .order-details {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            margin: 20px 0;
        }

        .product-card {
            display: flex;
            gap: 15px;
            align-items: flex-start;
            margin-top: 15px;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        .product-image {
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #eee;
            background: white;
        }

        .price {
            color: #4f46e5;
            font-weight: bold;
            font-size: 18px;
            margin-top: 5px;
        }

        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
        }

        .button {
            display: inline-block;
            background-color: #1a1a1a;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                border-radius: 0;
                margin-top: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ $message->embed($logoPath) }}" alt="{{ config('app.name') }}"
                style="height: 60px; margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;">
            <h1>Confirmation de Commande</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="success-icon">✅</div>

            <h2 style="text-align: center; color: #111; margin-top: 0;">Merci pour votre commande,
                {{ $order->full_name }} !
            </h2>

            <p style="text-align: center; color: #555;">
                Votre commande a été confirmée avec succès.
                <br>
                <strong>Livraison estimée : {{ $deliveryDays }} jours.</strong>
            </p>

            <div class="order-details">
                <h3
                    style="margin-top: 0; font-size: 16px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                    Récapitulatif de la commande</h3>

                <div class="product-card">
                    <div>
                        @if($productPath && file_exists($productPath))
                            <img src="{{ $message->embed($productPath) }}" alt="Produit" width="80" height="80"
                                class="product-image">
                        @else
                            <div
                                style="width: 80px; height: 80px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 10px;">
                                No Image
                            </div>
                        @endif
                    </div>
                    <div>
                        <div style="font-weight: bold; font-size: 16px; color: #111;">
                            {{ app()->getLocale() === 'ar' ? ($produit->name_produit_ar ?? $produit->name_produit) : ($produit->name_produit_fr ?? $produit->name_produit) }}
                        </div>
                        <div class="price">
                            {{ number_format($produit->price, 0) }} DH
                            <span style="color: #666; font-size: 14px; font-weight: normal; margin-left: 10px;">
                                (Quantité : {{ $quantity }})
                            </span>
                        </div>
                        <div style="font-size: 13px; color: #666; margin-top: 4px;">
                            <strong>Total article : {{ number_format($produit->price * $quantity, 0) }} DH</strong>
                        </div>
                        <div style="font-size: 13px; color: #666; margin-top: 4px;">
                            Mode de paiement :
                            <strong>
                                {{ $order->payment_method === 'cash' ? 'Paiement à la livraison' : 'Paiement en ligne' }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 25px;">
                <h3 style="font-size: 16px;">Adresse de livraison :</h3>
                <p style="color: #444; background: #f4f4f5; padding: 15px; border-radius: 8px;">
                    {{ $order->address }}
                    <br>
                    Tél : {{ $order->phone }}
                </p>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('produits.all') }}" class="button">Voir d'autres produits</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>

</html>
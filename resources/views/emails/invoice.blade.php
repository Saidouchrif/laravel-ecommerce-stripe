<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #4f46e5;">Bonjour {{ $order->full_name }},</h2>
        <p>Nous vous remercions pour votre commande chez <strong>OUCHRIF STORE</strong>.</p>
        <p>Vous trouverez ci-joint la facture correspondant à votre commande <strong>#{{ $order->id_order }}</strong>
            passée le {{ $order->created_at->format('d/m/Y') }}.</p>
        <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
        <br>
        <p>Cordialement,<br>L'équipe OUCHRIF</p>
    </div>
</body>

</html>
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;
use App\Mail\NewOrderAdminMail;
use Carbon\Carbon;

class StripeWebhookController extends Controller
{
    /**
     * Handle the incoming Stripe webhook.
     */
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;
            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;
            // Add other event types if necessary
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        $orderId = $session->metadata->order_id ?? null;
        if (!$orderId)
            return;

        $order = Order::with('items.produit')->find($orderId);
        if (!$order)
            return;

        $this->markOrderAsPaid($order, $session->payment_intent);
    }

    protected function handlePaymentIntentSucceeded($paymentIntent)
    {
        $order = Order::with('items.produit')->where('stripe_payment_id', $paymentIntent->id)->first();
        if (!$order) {
            // If the order wasn't found by ID, it might not have been recorded yet, 
            // but usually checkout.session.completed is sufficient.
            return;
        }

        $this->markOrderAsPaid($order, $paymentIntent->id);
    }

    protected function markOrderAsPaid(Order $order, $paymentId)
    {
        // Avoid duplicate processing
        if ($order->payment_status === 'paid')
            return;

        $order->update([
            'payment_status' => 'paid',
            'stripe_payment_id' => $paymentId,
            'paid_at' => Carbon::now(),
            'is_validated' => true,
        ]);

        $this->sendConfirmationEmails($order);
    }

    protected function sendConfirmationEmails(Order $order)
    {
        $item = $order->items->first();
        if (!$item)
            return;

        $produit = $item->produit;
        $quantity = $item->quantity;

        $logoPath = public_path('images/ouchrif_icons.png');
        $productPath = ($produit->images && $produit->images->first())
            ? public_path(ltrim($produit->images->first()->image_path, '/'))
            : null;

        try {
            // Client Email
            Mail::to($order->email)->send(new OrderConfirmationMail($order, $produit, $quantity));

            // Admin Email
            $adminEmail = config('mail.admin_email') ?? 'saidouchrif16@gmail.com';
            Mail::to($adminEmail)->send(new NewOrderAdminMail(
                $order,
                $produit,
                $quantity,
                $order->total_amount,
                $logoPath,
                $productPath
            ));
        } catch (\Exception $e) {
            Log::error('Stripe Webhook Email Error: ' . $e->getMessage());
        }
    }
}

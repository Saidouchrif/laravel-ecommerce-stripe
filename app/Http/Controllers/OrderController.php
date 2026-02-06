<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produit' => 'required|exists:produits,id_produit',
            'quantity' => 'required|integer|min:1',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|in:cash,online',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $produit = \App\Models\Produit::findOrFail($request->id_produit);
            $user = auth()->user();
            $quantity = (int) $request->quantity;
            $totalAmount = $produit->price * $quantity;

            // Create Order
            $order = Order::create([
                'id_user' => $user->id,
                'full_name' => $request->full_name,
                'email' => $user->email, // Always use auth email
                'phone' => $request->phone,
                'address' => $request->address,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'is_validated' => false,
                'total_amount' => $totalAmount,
            ]);

            // Create Order Item
            \App\Models\OrderItem::create([
                'id_order' => $order->id_order,
                'id_produit' => $produit->id_produit,
                'quantity' => $quantity,
                'price' => $produit->price,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            if ($request->payment_method === 'online') {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => 'mad',
                                'product_data' => [
                                    'name' => app()->getLocale() === 'ar' ? ($produit->name_produit_ar ?? $produit->name_produit) : ($produit->name_produit_fr ?? $produit->name_produit),
                                ],
                                'unit_amount' => $produit->price * 100,
                            ],
                            'quantity' => $quantity,
                        ]
                    ],
                    'mode' => 'payment',
                    'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('produits.commande', ['id' => $produit->id_produit]),
                    'metadata' => [
                        'order_id' => $order->id_order,
                    ],
                    'customer_email' => $user->email,
                ]);

                // Save Stripe Session ID
                $order->update(['stripe_session_id' => $session->id]);

                return redirect($session->url);
            }

            // --- CASH ON DELIVERY FLOW (Immediate confirmation) ---
            $this->sendOrderEmails($order, $produit, $quantity, $totalAmount);
            return back()->with('success', true);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage())->withInput();
        }
    }

    public function checkoutSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect()->route('home');
        }

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $orderId = $session->metadata->order_id;

            // Re-fetch order strictly
            $order = Order::with('items.produit')->findOrFail($orderId);
            $produit = $order->items->first()->produit;

            // Wait/Retry logic (Max 2 seconds) if not yet marked as paid by webhook
            $attempts = 0;
            while ($order->payment_status !== 'paid' && $attempts < 2) {
                sleep(1);
                $order->refresh();
                $attempts++;
            }

            // Fallback: If webhook didn't update it yet, we update it at least for the UI
            // (Standard behavior if webhook is late)
            if ($order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'stripe_payment_id' => $session->payment_intent,
                    'paid_at' => now(),
                    'is_validated' => true,
                ]);
                $this->sendOrderEmails($order, $produit, $order->items->first()->quantity, $order->total_amount);
            }

            // Use session()->now() to flash the success message for CURRENT request
            session()->now('success', 'Commande Validée !');

            return view('home.Produits.commande', [
                'produit' => $produit,
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Checkout Success Error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Erreur lors de la validation du paiement.');
        }
    }

    private function sendOrderEmails($order, $produit, $quantity, $totalAmount)
    {
        $logoPath = public_path('images/ouchrif_icons.png');
        $productPath = $produit->images->first()
            ? public_path(ltrim($produit->images->first()->image_path, '/'))
            : null;

        // Client
        try {
            \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderConfirmationMail($order, $produit, $quantity, $totalAmount));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Order Confirmation Email failed: ' . $e->getMessage());
        }

        // Admin
        try {
            $adminEmail = config('mail.admin_email');
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\NewOrderAdminMail(
                $order,
                $produit,
                $quantity,
                $totalAmount,
                $logoPath,
                $productPath
            ));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Admin Order Notification failed: ' . $e->getMessage());
        }
    }

    public function checkoutCancel()
    {
        return redirect()->route('home')->with('error', 'Le paiement a été annulé.');
    }
}

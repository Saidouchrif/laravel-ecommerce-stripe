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

            // Prepare paths for emails
            $logoPath = public_path('images/ouchrif_icons.png');
            $productPath = $produit->images->first()
                ? public_path(ltrim($produit->images->first()->image_path, '/'))
                : null;

            // Send Confirmation Email to Client
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OrderConfirmationMail($order, $produit, $quantity));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Order Confirmation Email failed: ' . $e->getMessage());
            }

            // Send Notification Email to Admin
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

            return back()->with('success', true);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage())->withInput();
        }
    }
}

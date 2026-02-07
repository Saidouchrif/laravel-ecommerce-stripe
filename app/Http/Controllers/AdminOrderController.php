<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produit;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['items.produit.categorie']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('items.produit', function ($pq) use ($search) {
                        $pq->where('name_produit', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('category')) {
            $category_id = $request->category;
            $query->whereHas('items.produit', function ($q) use ($category_id) {
                $q->where('id_categorie', $category_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $categories = \App\Models\Categorie::all();

        return view('admin.Commandes.index', compact('orders', 'categories'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $produits = Produit::all();
        return view('admin.Commandes.create', compact('produits'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'id_produit' => 'required|exists:produits,id_produit',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,online',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $produit = Produit::findOrFail($request->id_produit);
        $totalAmount = $produit->price * $request->quantity;

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $produit, $totalAmount) {
            $order = Order::create([
                'id_user' => auth()->id(), // Admin as creator or map to a user if needed
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'is_validated' => $request->payment_status === 'paid',
                'total_amount' => $totalAmount,
            ]);

            OrderItem::create([
                'id_order' => $order->id_order,
                'id_produit' => $produit->id_produit,
                'quantity' => $request->quantity,
                'price' => $produit->price,
            ]);
        });

        return redirect()->route('admin.orders.index')->with('success', 'Commande créée avec succès.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('items.produit');
        return view('admin.Commandes.show', compact('order'));
    }

    /**
     * Show the form for editing the order.
     */
    public function edit(Order $order)
    {
        $order->load('items.produit');
        return view('admin.Commandes.edit', compact('order'));
    }

    /**
     * Update the order.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_status' => 'required|in:pending,paid,failed,cancelled',
            'status' => 'required|in:en cours,annuler,livree',
        ]);

        $oldStatus = $order->status;
        $order->update($request->only(['full_name', 'phone', 'address', 'payment_status', 'status']));

        // Notify Admin if status changed to 'annuler' or 'livree' manually
        if ($oldStatus !== $order->status && in_array($order->status, ['annuler', 'livree'])) {
            try {
                $label = $order->status === 'annuler' ? 'Annulée' : 'Livrée';
                $adminEmail = config('mail.admin_email');
                \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminOrderStatusUpdateMail($order, $label));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Admin Manual Update Notification failed: ' . $e->getMessage());
            }
        }

        if ($request->payment_status === 'paid' && !$order->paid_at) {
            $order->update(['paid_at' => now(), 'is_validated' => true]);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Commande mise à jour.');
    }

    /**
     * Cancel the order (instead of hard delete).
     */
    public function destroy(Order $order)
    {
        $order->update(['status' => 'annuler']);

        // Notify Admin
        try {
            $adminEmail = config('mail.admin_email');
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminOrderStatusUpdateMail($order, 'Annulée'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Admin Cancel Notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Commande annulée avec succès.');
    }

    /**
     * View the invoice PDF.
     */
    public function viewInvoice(Order $order)
    {
        $order->load(['items.produit', 'items.produit.categorie']);
        $pdf = Pdf::loadView('admin.Commandes.facteurs.index', compact('order'));
        return $pdf->download('facture-' . $order->id_order . '.pdf');
    }

    /**
     * Send the invoice PDF via email.
     */
    public function sendInvoice(Order $order)
    {
        $order->load('items.produit');
        $pdf = Pdf::loadView('admin.Commandes.facteurs.index', compact('order'));

        try {
            Mail::send('emails.invoice', ['order' => $order], function ($message) use ($order, $pdf) {
                $message->to($order->email)
                    ->subject('Votre facture - Commande #' . $order->id_order)
                    ->attachData($pdf->output(), 'facture-' . $order->id_order . '.pdf');
            });
            return back()->with('success', 'Facture envoyée avec succès au client.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send invoice: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'envoi de la facture.');
        }
    }

    /**
     * Mark an order as delivered.
     */
    public function markAsDelivered(Order $order)
    {
        $order->update(['status' => 'livree']);

        // Notify Admin
        try {
            $adminEmail = config('mail.admin_email');
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminOrderStatusUpdateMail($order, 'Livrée'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Admin Delivery Notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'La commande a été marquée comme livrée.');
    }
}

<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Produit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $produit;
    public $quantity;
    public $deliveryDays;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, Produit $produit, int $quantity = 1, int $deliveryDays = 5)
    {
        $this->order = $order;
        $this->produit = $produit;
        $this->quantity = $quantity;
        $this->deliveryDays = $deliveryDays;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $productImage = $this->produit->images->first()
            ? public_path($this->produit->images->first()->image_path)
            : null;

        return $this->subject('Confirmation de votre commande - ' . config('app.name'))
            ->view('emails.order_confirmation')
            ->with([
                'logoPath' => public_path('images/ouchrif_icons.png'),
                'productPath' => $productImage,
            ]);
    }
}

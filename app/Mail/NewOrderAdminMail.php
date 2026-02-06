<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Produit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $produit;
    public $quantity;
    public $total;
    public $logoPath;
    public $productPath;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, Produit $produit, int $quantity, float $total, string $logoPath, ?string $productPath)
    {
        $this->order = $order;
        $this->produit = $produit;
        $this->quantity = $quantity;
        $this->total = $total;
        $this->logoPath = $logoPath;
        $this->productPath = $productPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Nouvelle commande : {$this->order->full_name} - #{$this->order->id_order}")
            ->view('emails.admin.new_order');
    }
}

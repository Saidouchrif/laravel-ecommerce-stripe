<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminOrderStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $statusLabel;
    public $product;
    public $logoPath;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $statusLabel)
    {
        $this->order = $order->load('items.produit');
        $this->statusLabel = $statusLabel;
        $this->product = $order->items->first()?->produit;
        $this->logoPath = public_path('images/ouchrif_icons.png');
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        $subject = "Mise à jour Commande : {$this->statusLabel} - #{$this->order->id_order}";

        return $this->subject($subject)
            ->view('emails.admin.order_status_update');
    }
}

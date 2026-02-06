<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
        protected $table = 'order_items';
    protected $primaryKey = 'id_order_item';

    protected $fillable = [
        'id_order',
        'id_produit',
        'quantity',
        'price',
    ];

    // Item → Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    // Item → Produit
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit', 'id_produit');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
        protected $table = 'orders';
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_user',
        'full_name',
        'email',
        'phone',
        'address',
        'payment_method',
        'payment_status',
        'is_validated',
        'total_amount',
    ];

    // Order → User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Order → Items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_order');
    }
}

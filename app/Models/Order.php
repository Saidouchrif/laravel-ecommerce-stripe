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
        'stripe_payment_id',
        'stripe_session_id',
        'paid_at',
        'status',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'is_validated' => 'boolean',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'delivery_address', 'delivery', 'address', 'phone', 'subtotal', 'delivery_fee',
        'total', 'total_amount', 'payment_method', 'payment_status', 'payment_status_normalized',
        'status', 'order_status', 'stripe_session_id', 'stripe_payment_intent_id', 'driver',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer', 'delivery_fee' => 'integer', 'total' => 'integer',
            'total_amount' => 'integer',
        ];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

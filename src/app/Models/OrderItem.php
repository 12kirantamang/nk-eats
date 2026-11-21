<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'name', 'price', 'quantity'];

    protected function casts(): array
    {
        return ['price' => 'integer', 'quantity' => 'integer'];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'restaurant_id', 'name', 'description', 'price', 'image', 'image_path',
        'category', 'in_stock', 'is_available',
    ];

    protected function casts(): array
    {
        return ['price' => 'integer', 'in_stock' => 'boolean', 'is_available' => 'boolean'];
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}

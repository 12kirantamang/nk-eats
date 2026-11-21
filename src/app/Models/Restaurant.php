<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['name', 'is_open'];

    protected function casts(): array
    {
        return ['is_open' => 'boolean'];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

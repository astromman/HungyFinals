<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    // Define the orders relationship (One-to-Many)
    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'product_id', 'id');
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // // Define the products relationship (Many-to-Many)
    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
    //         ->withPivot('quantity', 'price'); // Assuming pivot contains quantity and price
    // }

    // // Example: If Order belongs to a User (like a buyer)
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // // Example: If Order belongs to a specific Shop (indirectly via Product)
    // public function shop()
    // {
    //     return $this->hasOneThrough(Shop::class, Product::class, 'id', 'id', 'product_id', 'shop_id');
    // }
}

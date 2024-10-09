<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productOrder()
    {
        return $this->belongsTo(ProductOrder::class, 'product_orders_id', 'id');
    }

    // Example: If Order belongs to a User (like a buyer)
    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_id', 'id');
    }
    
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

}

<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NewOrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function broadcastOn()
    {
        // Get the shop_id via the product associated with the order
        $shopId = $this->order->product->shop_id; // Ensure relationship exists between Order and Product

        // Broadcast to a specific shop’s private channel
        return new PrivateChannel('orders.' . $shopId);
    }

    public function broadcastWith()
    {
        return [
            'order' => $this->order->load('product'), // Make sure products are included
        ];
    }
}

<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $encryptedId;

    public function __construct(Order $order, $encryptedId)
    {
        $this->order = $order;
        $this->encryptedId = $encryptedId;
    }

    public function broadcastOn()
    {
        return new Channel('orders.' . $this->order->user_id); // The buyer will listen on this channel
    }

    public function broadcastAs()
    {
        return 'order.status.updated';
    }
}

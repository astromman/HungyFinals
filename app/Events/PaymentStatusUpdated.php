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

class PaymentStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $paymentStatus;
    public $feedback;

    public function __construct(Order $order, $paymentStatus, $feedback = null)
    {
        $this->order = $order;
        $this->paymentStatus = $paymentStatus;
        $this->feedback = $feedback;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('payment.' . $this->order->user_id);
    }

    public function broadcastAs()
    {
        return 'payment.status.updated';
    }
}

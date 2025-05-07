<?php

namespace App\Events;

use App\Models\Order;
use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->message = "New order #{$order->id} has been placed!";
        
        // Save notification for admin
        Notification::create([
            'user_id' => null, // null for all admins
            'type' => 'order',
            'title' => 'New Order',
            'message' => $this->message,
            'data' => json_encode($order->toArray()),
            'icon' => 'shopping_cart',
            'color' => 'blue',
            'link' => "/admin/orders/{$order->id}",
            'is_admin' => true
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('admin-notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.order';
    }
} 
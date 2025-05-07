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

class OrderStatusChangedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $message;
    public $status;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order, $previousStatus)
    {
        $this->order = $order;
        $this->status = $order->status;
        $this->message = "Your order #{$order->id} status has been updated from {$previousStatus} to {$order->status}";
        
        // Create notification for user
        Notification::create([
            'user_id' => $order->user_id,
            'type' => 'status',
            'title' => 'Order Update',
            'message' => $this->message,
            'data' => json_encode([
                'order_id' => $order->id,
                'previous_status' => $previousStatus,
                'new_status' => $order->status
            ]),
            'icon' => 'local_shipping',
            'color' => $this->getStatusColor($order->status),
            'link' => "/orders/{$order->id}",
            'is_admin' => false
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
            new PrivateChannel('user.'.$this->order->user_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'order.status.changed';
    }
    
    /**
     * Get color based on order status
     */
    private function getStatusColor($status): string
    {
        return match($status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'shipped' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }
} 
<?php

namespace App\Events;

use App\Models\Product;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewProductEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->message = "New product added: {$product->name}";
        
        // Create notification for all users
        $users = User::all();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'product',
                'title' => 'New Product',
                'message' => $this->message,
                'data' => json_encode($product->toArray()),
                'icon' => 'shopping_bag',
                'color' => 'green',
                'link' => "/shop/{$product->id}",
                'is_admin' => false
            ]);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('general'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.product';
    }
} 
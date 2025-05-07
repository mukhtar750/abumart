<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'shipping_address',
        'phone',
        'status',
        'payment_method',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot(['quantity', 'price']);
    }

    // If you have a Product model, you can define a relationship here
    // public function products()
    // {
    //     return $this->belongsToMany(Product::class);
    // }
}

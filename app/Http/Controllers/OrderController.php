<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('customer.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create'); // Show order creation form
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_amount' => 'required|numeric',
            'products' => 'required|array', // Assuming you send an array of product IDs
        ]);

        $order = new Order();
        $order->user_id = auth()->id();
        $order->total_amount = $request->total_amount;
        $order->status = 'pending'; // Set initial status
        $order->save();

        // Attach products to the order
        foreach ($request->products as $productId => $quantity) {
            $order->products()->attach($productId, ['quantity' => $quantity]);
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function show(Order $order)
    {
        return view('customer.orders.show', compact('order'));
    }
} 
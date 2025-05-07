<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Events\OrderStatusChangedEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $previousStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // Dispatch the event for real-time notification
        event(new OrderStatusChangedEvent($order, $previousStatus));

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order status updated successfully');
    }
} 
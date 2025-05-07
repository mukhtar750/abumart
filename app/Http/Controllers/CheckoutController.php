<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Events\NewOrderEvent;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }
        
        $total = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'shipping_address' => 'required|string',
                'phone' => 'required|string',
                'payment_method' => 'required|in:card',
            ]);

            $cart = session()->get('cart', []);
            
            if (empty($cart)) {
                return redirect()->route('cart')->with('error', 'Your cart is empty');
            }

            // Log the cart data
            \Log::info('Cart data:', ['cart' => $cart]);

            DB::beginTransaction();

            // Calculate total
            $total = array_reduce($cart, function($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            // Log the order data being created
            \Log::info('Creating order with data:', [
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method
            ]);

            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            // Log the created order
            \Log::info('Order created:', ['order' => $order->toArray()]);

            // Create order items
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            // Log successful order creation
            \Log::info('Order created successfully, redirecting to payment');

            // Dispatch the NewOrderEvent
            event(new NewOrderEvent($order));

            // Redirect to payment page
            return redirect()->route('payment.process', ['order' => $order->id]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Checkout error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Checkout failed: ' . $e->getMessage())->withInput();
        }
    }

    public function success($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }
}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto text-center">
        <div class="bg-white p-8 rounded-lg shadow">
            <div class="text-green-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold mb-4">Order Placed Successfully!</h1>
            <p class="text-gray-600 mb-6">Thank you for your purchase. Your order number is #{{ $order->id }}</p>
            
            <div class="text-left mb-6">
                <h2 class="font-bold mb-2">Order Details:</h2>
                <p>Total Amount: ₦{{ number_format($order->total_amount, 2) }}</p>
                <p>Status: {{ ucfirst($order->status) }}</p>
                <p>Payment Method: {{ ucfirst($order->payment_method) }}</p>
            </div>

            <div class="space-x-4">
                <a href="{{ route('orders.show', $order->id) }}" 
                   class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                    View Order Details
                </a>
                <a href="{{ route('shop.index') }}" 
                   class="inline-block bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 
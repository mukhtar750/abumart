@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Details</h1>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Total Amount:</strong> ₦{{ number_format($order->total_amount, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>

    <h3>Products</h3>
    <ul>
        @foreach($order->products as $product)
            <li>{{ $product->name }} - ₦{{ number_format($product->price, 2) }} x {{ $product->pivot->quantity }}</li>
        @endforeach
    </ul>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>
@endsection 
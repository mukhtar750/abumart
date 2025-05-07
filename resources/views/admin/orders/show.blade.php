@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center bg-gray-100 dark:bg-gray-900 p-6">
    <div class="w-full max-w-4xl bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Order #{{ $order->id }}</h2>
            <a href="{{ route('admin.orders.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                Back to Orders
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Order Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Order Information</h3>
                <div class="space-y-2">
                    <p class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Order Date:</span>
                        <span>{{ $order->created_at->format('F d, Y h:i A') }}</span>
                    </p>
                    <p class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Order Status:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-bold 
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status == 'delivered') bg-green-100 text-green-800
                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Payment Method:</span>
                        <span>{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
                    </p>
                    <p class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Total Amount:</span>
                        <span class="font-bold">₦{{ number_format($order->total_amount, 2) }}</span>
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Customer Information</h3>
                <div class="space-y-2">
                    <p class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Name:</span>
                        <span>{{ $order->user->name ?? 'N/A' }}</span>
                    </p>
                    <p class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Email:</span>
                        <span>{{ $order->user->email ?? 'N/A' }}</span>
                    </p>
                    <p class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Phone:</span>
                        <span>{{ $order->phone ?? 'N/A' }}</span>
                    </p>
                    <p class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Shipping Address:</span>
                        <span class="text-right">{{ $order->shipping_address ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Update Order Status</h3>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center space-x-4">
                @csrf
                @method('PATCH')
                <select name="status" class="form-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-white flex-grow">
                    <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                    <option value="processing" @if($order->status == 'processing') selected @endif>Processing</option>
                    <option value="shipped" @if($order->status == 'shipped') selected @endif>Shipped</option>
                    <option value="delivered" @if($order->status == 'delivered') selected @endif>Delivered</option>
                    <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                </select>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Order Items -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Order Items</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-right">Price</th>
                            <th class="px-4 py-3 text-center">Quantity</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-3 text-gray-800 dark:text-white">
                                {{ $item->product->name ?? 'Product #'.$item->product_id }}
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-white text-right">
                                ₦{{ number_format($item->price, 2) }}
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-white text-center">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-white text-right font-medium">
                                ₦{{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 dark:bg-gray-700">
                            <td colspan="3" class="px-4 py-3 text-gray-800 dark:text-white text-right font-bold">
                                Total:
                            </td>
                            <td class="px-4 py-3 text-gray-800 dark:text-white text-right font-bold">
                                ₦{{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 
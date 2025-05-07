@extends('customer.layouts.customer')

@section('page-title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 py-6">
        <!-- Welcome Banner -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-2">Welcome Back, {{ Auth::user()->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Track your orders, manage your wishlists, and discover our newest products.</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Recent Orders Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover-up">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Orders</p>
                        @php
                            $pendingOrders = Auth::user()->orders()->where('status', 'pending')->count();
                        @endphp
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $pendingOrders }}</h3>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="space-y-3 mb-4">
                    @foreach(Auth::user()->orders()->latest()->take(3)->get() as $order)
                    <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <span class="text-gray-800 dark:text-white font-medium">Order #{{ $order->id }}</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ 
                            $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 
                            ($order->status == 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                            ($order->status == 'shipped' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                            ($order->status == 'delivered' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'))) 
                        }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                
                <a href="{{ route('orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    Track All Orders
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Wishlist Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover-up">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Wishlist Items</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                            <!-- Replace with actual wishlist count when available -->
                            <span>0</span>
                        </h3>
                    </div>
                    <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="flex flex-col items-center justify-center py-8 mb-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-center">Save your favorite items<br>for later</p>
                </div>
                
                <a href="{{ route('wishlist') }}" class="inline-flex items-center text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                    View Wishlist
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Cart Items Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover-up">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Cart Items</p>
                        @php
                            $cart = session('cart', []);
                            $cartCount = count($cart);
                            $cartTotal = array_reduce($cart, function($carry, $item) {
                                return $carry + ($item['price'] * $item['quantity']);
                            }, 0);
                        @endphp
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $cartCount }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                
                @if($cartCount > 0)
                <div class="space-y-3 mb-4">
                    @foreach($cart as $id => $item)
                    <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-gray-800 dark:text-white font-medium truncate max-w-[150px]">{{ $item['name'] }}</span>
                        <div class="text-right">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">x{{ $item['quantity'] }}</span>
                            <p class="text-green-600 dark:text-green-400 font-medium">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900 rounded-lg">
                        <span class="text-blue-800 dark:text-blue-300 font-bold">Total</span>
                        <span class="text-blue-800 dark:text-blue-300 font-bold">₦{{ number_format($cartTotal, 2) }}</span>
                    </div>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 mb-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-center">Your cart is empty</p>
                </div>
                @endif
                
                <a href="{{ route('cart') }}" class="inline-flex items-center text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                    Go to Cart
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Recent Notifications -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Recent Notifications</h2>
                <a href="{{ route('notifications.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm">View All</a>
            </div>
            
            @php
                $unreadNotifications = \App\Models\Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->where('is_admin', false)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
                $unreadCount = $unreadNotifications->count();
            @endphp
            
            @if($unreadCount > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-left">
                            <tr>
                                <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Type</th>
                                <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Title</th>
                                <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Message</th>
                                <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Date</th>
                                <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($unreadNotifications as $notification)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3">
                                        <span class="inline-block px-2 py-1 text-xs rounded-full {{ 
                                            $notification->color == 'green' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                            ($notification->color == 'blue' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                                            ($notification->color == 'red' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 
                                            ($notification->color == 'purple' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'))) 
                                        }}">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-800 dark:text-white">{{ $notification->title }}</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ Str::limit($notification->message, 50) }}</td>
                                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-sm">{{ $notification->created_at->diffForHumans() }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <a href="{{ $notification->link }}" class="px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                                View
                                            </a>
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                                    Mark Read
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No unread notifications</p>
                    <p class="text-gray-400 dark:text-gray-500 mt-1">We'll notify you when something new arrives</p>
                </div>
            @endif
        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Recent Orders</h2>
                <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm">View All</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left">
                        <tr>
                            <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Order ID</th>
                            <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Date</th>
                            <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Total</th>
                            <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Status</th>
                            <th class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach(Auth::user()->orders()->latest()->take(5)->get() as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 text-gray-800 dark:text-white">#{{ $order->id }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-green-600 dark:text-green-400 font-medium">₦{{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-1 text-xs rounded-full {{ 
                                        $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 
                                        ($order->status == 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                                        ($order->status == 'shipped' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                                        ($order->status == 'delivered' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'))) 
                                    }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('orders.show', $order) }}" class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-md text-sm hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

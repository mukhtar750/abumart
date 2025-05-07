<!-- Vendor Dependencies -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
<script src="{{ asset('js/script.js') }}"></script>

<!-- Custom CSS -->
<style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Chart Customization */
    .chart-container {
        position: relative;
        height: 100%;
        width: 100%;
    }

    /* Card Hover Effects */
    .hover-scale {
        transition: transform 0.2s ease-in-out;
    }
    
    .hover-scale:hover {
        transform: scale(1.02);
    }

    /* Dark Mode Transitions */
    .dark-mode-transition {
        transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
    }
</style>

<!-- Custom JavaScript -->
<script>
    // Dark Mode Toggle
    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
    }

    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'true') {
        document.documentElement.classList.add('dark');
    }

    // Chart Configuration
    const chartConfig = {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Sales',
                data: [],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    };

    // Initialize Chart
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, chartConfig);
    });
</script>

@extends('admin.layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section with improved styling -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-2">Admin Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Welcome back, {{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>

        <!-- Stats Cards with enhanced animations -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover-up">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Products</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalProducts }}</h3>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('admin.products.create') }}" class="mt-4 inline-flex items-center text-blue-600 hover:text-blue-700">
                    Add New Product
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover-up">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Orders</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalOrders }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="mt-4 inline-flex items-center text-green-600 hover:text-green-700">
                    View Orders
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover-up">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Users</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalUsers }}</h3>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('users.index') }}" class="mt-4 inline-flex items-center text-purple-600 hover:text-purple-700">
                    Manage Users
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover-up">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Sales</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">₦{{ number_format($totalSales, 2) }}</h3>
                    </div>
                    <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <a href="#" class="mt-4 inline-flex items-center text-red-600 hover:text-red-700">
                    View Revenue Report
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Featured Products Grid -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Featured Products</h2>
                <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">View All Products</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $featuredProducts = \App\Models\Product::take(5)->get();
                @endphp
                
                @foreach($featuredProducts as $product)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden hover-scale">
                    <div class="h-40 overflow-hidden bg-gray-200 dark:bg-gray-600">
                        @if($product->image)
                            <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-gray-800 dark:text-white truncate">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-blue-600 dark:text-blue-400 font-bold">₦{{ number_format($product->price, 2) }}</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->stock > 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-400' }}">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                                {{ $product->stock > 0 ? 'Stock: ' . $product->stock : 'Out of Stock' }}
                            </span>
                        </div>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="mt-2 text-xs text-blue-600 hover:text-blue-700 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Sales and Revenue at a Glance -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Sales Chart -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Sales Overview</h3>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 text-sm bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-lg">Weekly</button>
                        <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg">Monthly</button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Recent Orders Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Recent Orders</h3>
                <div class="space-y-4">
                    @foreach(\App\Models\Order::latest()->take(5)->get() as $order)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800 dark:text-white">₦{{ number_format($order->total_amount, 2) }}</p>
                            <span class="inline-block px-2 py-1 text-xs rounded-full {{ 
                                $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                ($order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : 
                                ($order->status == 'delivered' ? 'bg-green-100 text-green-800' : 
                                'bg-red-100 text-red-800'))) 
                            }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.orders.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700">
                    View All Orders →
                </a>
            </div>
        </div>

        <!-- Recent Activity and Notifications -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Recent Activity</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <tbody>
                            @foreach($recentActivities as $activity)
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <td class="py-4 text-gray-800 dark:text-white">{{ $activity->description }}</td>
                                <td class="py-4 text-gray-600 dark:text-gray-400 text-right">{{ $activity->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Unread Notifications -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Unread Notifications</h2>
                    <a href="{{ route('admin.notifications.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">View All</a>
                </div>
                @php
                    $unreadNotifications = \App\Models\Notification::where('is_admin', true)
                        ->where('is_read', false)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                @endphp
                
                @if($unreadNotifications->isEmpty())
                    <div class="flex flex-col items-center justify-center py-8">
                        <span class="material-icons text-5xl text-gray-400 mb-2">notifications_off</span>
                        <p class="text-gray-500 dark:text-gray-400">No unread notifications</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($unreadNotifications as $notification)
                        <div class="p-3 border-l-4 border-{{ $notification->color }}-500 bg-gray-50 dark:bg-gray-700 rounded-r-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-{{ $notification->color }}-600 dark:text-{{ $notification->color }}-400">
                                    <i class="material-icons text-lg align-middle">{{ $notification->icon }}</i>
                                    <span class="font-semibold ml-1">{{ $notification->title }}</span>
                                </span>
                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mt-2 text-gray-700 dark:text-gray-300">{{ Str::limit($notification->message, 120) }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <a href="{{ $notification->link }}" class="text-sm text-{{ $notification->color }}-600 hover:text-{{ $notification->color }}-700">
                                    View Details
                                </a>
                                <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                        Mark as Read
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Configuration for Charts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Format the data for Chart.js
        const labels = {!! json_encode($formattedSalesData['labels'] ?? []) !!};
        const data = {!! json_encode($formattedSalesData['data'] ?? []) !!};
        
        const chartConfig = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales',
                    data: data,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        };
        
        new Chart(ctx, chartConfig);
    });
</script>
@endsection

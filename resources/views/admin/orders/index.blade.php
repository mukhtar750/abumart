@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center bg-gray-100 dark:bg-gray-900 p-6">
    <div class="w-full max-w-6xl bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Order Management</h2>
            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                Back to Dashboard
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Options -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex items-center">
                <label for="status-filter" class="mr-2 text-gray-700 dark:text-gray-300">Status:</label>
                <select id="status-filter" class="form-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <!-- Search Input -->
            <div class="flex-grow">
                <input type="text" id="search" placeholder="Search by order ID, customer name or email..."
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    onkeyup="searchTable()">
            </div>
        </div>

        <!-- Orders Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-3">Order ID</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                    @foreach($orders as $order)
                    <tr class="border-b dark:border-gray-700" data-status="{{ $order->status }}">
                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">#{{ $order->id }}</td>
                        <td class="px-4 py-3 text-gray-800 dark:text-white">
                            {{ $order->user->name ?? 'N/A' }}<br>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $order->user->email ?? '' }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-800 dark:text-white">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-gray-800 dark:text-white">₦{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-bold 
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<!-- JavaScript for Search & Filter -->
<script>
    function searchTable() {
        let input = document.getElementById("search").value.toLowerCase();
        let statusFilter = document.getElementById("status-filter").value;
        let rows = document.querySelectorAll("#orderTable tr");
        
        rows.forEach(row => {
            let orderId = row.cells[0].textContent.toLowerCase();
            let customer = row.cells[1].textContent.toLowerCase();
            let rowStatus = row.getAttribute('data-status');
            
            let statusMatch = statusFilter === '' || rowStatus === statusFilter;
            let searchMatch = orderId.includes(input) || customer.includes(input);
            
            row.style.display = (statusMatch && searchMatch) ? "" : "none";
        });
    }

    // Add event listener for status filter
    document.getElementById('status-filter').addEventListener('change', searchTable);
</script>
@endsection 
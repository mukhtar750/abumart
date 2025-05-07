@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="max-w-xs">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Filter by Category</label>
            <select id="category" onchange="window.location.href=this.value" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="{{ route('shop.index') }}" {{ !request('category') ? 'selected' : '' }}>
                    All Products
                </option>
                @foreach($categories as $category)
                    <option value="{{ route('shop.index', ['category' => $category->id]) }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <a href="{{ route('shop.show', $product->id) }}" class="block">
                    <img src="{{ url($product->image) }}" alt="{{ $product->name }}" 
                            class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                        <p class="text-gray-600 mb-2">{{ Str::limit($product->description, 100) }}</p>
                        <p class="text-lg font-bold text-blue-600">${{ number_format($product->price, 2) }}</p>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="add-to-cart">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product added to cart!');
                        // Optionally, update the cart count or redirect
                    } else {
                        alert('Error adding product to cart.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            });
        });
    });
</script>
@endsection
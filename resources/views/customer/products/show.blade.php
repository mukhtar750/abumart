@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Product Image -->
            <div class="md:w-1/2">
                <img src="{{ url($product->image) }}" alt="{{ $product->name }}" 
                    class="w-full h-auto object-cover rounded-lg shadow-lg">
            </div>

            <!-- Product Details -->
            <div class="md:w-1/2">
                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-4">Category: {{ $product->category->name }}</p>
                <p class="text-2xl font-bold text-blue-600 mb-6">${{ number_format($product->price, 2) }}</p>
                
                <div class="prose max-w-none mb-6">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p>{{ $product->description }}</p>
                </div>

                @auth
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="add-to-cart">
                            Add to Cart
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="add-to-cart">
                        Login to Buy
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<style>
.add-to-cart {
    display: inline-block;
    width: 100%;
    padding: 1rem;
    background-color: #2563eb;
    color: white;
    text-align: center;
    border-radius: 8px;
    font-weight: 500;
    transition: background-color 0.2s;
}

.add-to-cart:hover {
    background-color: #1d4ed8;
}
</style>
@endsection


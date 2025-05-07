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
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Quantity</label>
                            <input type="number" name="quantity" value="1" min="1" 
                                class="w-24 border rounded px-3 py-2">
                        </div>
                        <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 ease-in-out transform hover:-translate-y-1">
                            Add to Cart
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                        class="block text-center w-full bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 ease-in-out transform hover:-translate-y-1">
                        Login to Purchase
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<style>
/* Additional button hover effects and animations */
button[type="submit"], 
a.block {
    position: relative;
    overflow: hidden;
}

button[type="submit"]:after,
a.block:after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.2),
        transparent
    );
    transition: 0.5s;
}

button[type="submit"]:hover:after,
a.block:hover:after {
    left: 100%;
}

/* Ensure button text is always visible */
button[type="submit"],
a.block {
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}
</style>
@endsection 
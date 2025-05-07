@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">All Products</h1>
    
    <!-- Categories Filter (optional) -->
    <div class="mb-8">
        <select class="form-select" onchange="window.location.href=this.value">
            <option value="{{ route('products.index') }}">All Categories</option>
            @foreach($categories ?? [] as $category)
                <option value="{{ route('products.index', ['category' => $category->id]) }}" 
                    {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Products Grid -->
    <div class="products-grid">
        @foreach($products as $product)
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                </div>
                <div class="product-info p-4">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <p class="product-category">{{ $product->category->name }}</p>
                    <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                    <p class="product-price">${{ number_format($product->price, 2) }}</p>
                    
                    @auth
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4 add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="add-to-cart" onclick="addToCart(event, this)">
                                Add to Cart
                            </button>
                            <span class="confirmation-message" style="display:none; color: green;">Added to Cart!</span>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="add-to-cart">
                            Login to Buy
                        </a>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>

<style>
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 2rem;
}

.product-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.product-info {
    padding: 1rem;
}

.product-title {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.product-category {
    color: #666;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.product-description {
    color: #444;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.product-price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2563eb;
    margin-bottom: 1rem;
}

.add-to-cart {
    width: 100%;
    padding: 0.75rem;
    background-color: #2563eb;
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.add-to-cart:hover {
    background-color: #1d4ed8;
}

.form-select {
    width: 200px;
    padding: 0.5rem;
    border-radius: 4px;
    border: 1px solid #ddd;
    margin-bottom: 1rem;
}
</style>

<script>
function addToCart(event, button) {
    event.preventDefault(); // Prevent the form from submitting immediately
    const form = button.closest('form');
    const confirmationMessage = form.querySelector('.confirmation-message');

    // Disable the button to prevent multiple clicks
    button.disabled = true;
    button.textContent = 'Adding...';

    // Simulate an AJAX request (you would replace this with an actual AJAX call)
    setTimeout(() => {
        // Here you would typically send the form data via AJAX
        // For example, using fetch or XMLHttpRequest

        // Show confirmation message
        confirmationMessage.style.display = 'inline';
        button.textContent = 'Added to Cart!';

        // Optionally, reset the button after a few seconds
        setTimeout(() => {
            button.disabled = false;
            button.textContent = 'Add to Cart';
            confirmationMessage.style.display = 'none';
        }, 2000);
    }, 1000); // Simulate network delay
}
</script>
@endsection 
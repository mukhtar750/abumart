@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="relative bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Discover Our Exclusive Collection</h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">Elevate your style with our carefully curated selection of premium products</p>
                <button class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-50 transition-colors duration-200 shadow-lg" onclick="window.location.href='#products'">Shop Now</button>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="products" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Featured Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="aspect-w-1 aspect-h-1">
                            <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-2xl font-bold text-blue-600 mb-4">${{ number_format($product->price, 2) }}</p>
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200">Add to Cart</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 text-center">Login to Buy</a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Us -->
    <section id="about" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-3xl font-bold text-gray-900">About Us</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">Welcome to AbuMart, where quality meets convenience. We are a modern online store committed to providing you with the best shopping experience. Our mission is to bring you top-notch products, excellent customer service, and a seamless journey from browsing to checkout. At AbuMart, we believe in making every purchase memorable, ensuring you find exactly what you need with just a click.</p>
                    <div class="text-center">
                        <img src="{{ asset('images/qr.PNG')}}" alt="AbuMart QR Code" class="w-32 h-32 mx-auto mb-4 rounded-lg shadow-lg">
                        <p class="text-gray-600 font-medium">Scan to verify our products</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?q=80&w=2070" alt="Premium Fashion Collection" class="w-full h-64 object-cover rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1523170335258-f5ed11844a49?q=80&w=1180" alt="Luxury Watch Collection" class="w-full h-48 object-cover rounded-lg shadow-lg">
                    </div>
                    <div class="space-y-4 pt-8">
                        <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=1180" alt="Designer Shoe Collection" class="w-full h-48 object-cover rounded-lg shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">What Our Customers Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                    <div class="w-20 h-20 mx-auto mb-6">
                        <img src="{{ asset('images/aa.PNG')}}" alt="Customer 1" class="w-full h-full object-cover rounded-full">
                    </div>
                    <p class="text-lg text-gray-600 mb-4 italic">"Amazing quality and exceptional service. I'm a happy returning customer!"</p>
                    <p class="font-semibold text-gray-900">- Sarah Johnson</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                    <div class="w-20 h-20 mx-auto mb-6">
                        <img src="https://img.freepik.com/free-photo/beautiful-happy-arabian-female-touches-cheeks-gently-has-charming-smile-wears-traditional-pink-veil-head_273609-27300.jpg?t=st=1736424114~exp=1736427714~hmac=3fb31b0e89894805347efb478e91a230379a751c1f3cbe364e02ccd1350ef196&w=740" alt="Customer 2" class="w-full h-full object-cover rounded-full">
                    </div>
                    <p class="text-lg text-gray-600 mb-4 italic">"The best online shopping experience I've ever had. Highly recommended!"</p>
                    <p class="font-semibold text-gray-900">- Michael Brown</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section id="newsletter" class="py-16 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
            <p class="text-xl text-blue-100 mb-8">Subscribe to our newsletter for exclusive offers and updates</p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Enter your email address" required class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <button type="submit" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors duration-200">Subscribe</button>
            </form>
        </div>
    </section>

    <!-- Cart Modal -->
    <div class="cart-modal" id="cartModal">
        <div class="cart-content">
            <div class="cart-header">
                <h3>Your Cart</h3>
                <button class="close-cart" id="closeCart">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="cart-items" id="cartItems">
                @if(session()->has('cart') && count(session('cart')) > 0)
                    @foreach(session('cart') as $id => $item)
                        <div class="cart-item" data-id="{{ $id }}">
                            <img src="{{ url($item['image']) }}" alt="{{ $item['name'] }}" class="cart-item-image">
                            <div class="cart-item-details">
                                <h4>{{ $item['name'] }}</h4>
                                <p class="cart-item-price">₦{{ number_format($item['price'], 2) }}</p>
                                <div class="cart-item-quantity">
                                    <button class="quantity-btn minus" data-id="{{ $id }}">-</button>
                                    <span class="quantity">{{ $item['quantity'] }}</span>
                                    <button class="quantity-btn plus" data-id="{{ $id }}">+</button>
                                </div>
                            </div>
                            <button class="remove-item" data-id="{{ $id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <p class="empty-cart-message">Your cart is empty</p>
                @endif
            </div>
            <div class="cart-footer">
                <div class="cart-total">
                    <span>Total:</span>
                    <span class="total-amount" id="cartTotal">
                        @if(session()->has('cart'))
                            ₦{{ number_format(array_reduce(session('cart'), function($carry, $item) {
                                return $carry + ($item['price'] * $item['quantity']);
                            }, 0), 2) }}
                        @else
                            ₦0.00
                        @endif
                    </span>
                </div>
                @if(session()->has('cart') && count(session('cart')) > 0)
                    <a href="{{ route('cart') }}" class="checkout-button">
                        View Cart
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <a href="{{ route('checkout.index') }}" class="checkout-button">
                        Proceed to Checkout
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
                <button class="continue-shopping" id="continueShopping">
                    Continue Shopping
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartIcon = document.getElementById('cartIcon');
    const cartModal = document.getElementById('cartModal');
    const closeCart = document.getElementById('closeCart');
    const continueShopping = document.getElementById('continueShopping');

    // Toggle cart modal
    if (cartIcon) {
        cartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            cartModal.style.display = 'block';
        });
    }

    // Close cart modal
    if (closeCart) {
        closeCart.addEventListener('click', function() {
            cartModal.style.display = 'none';
        });
    }

    if (continueShopping) {
        continueShopping.addEventListener('click', function() {
            cartModal.style.display = 'none';
        });
    }

    // Close cart when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === cartModal) {
            cartModal.style.display = 'none';
        }
    });

    // Handle quantity changes
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const isPlus = this.classList.contains('plus');
            
            fetch(`/cart/update/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity: isPlus ? 1 : -1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });

    // Handle remove item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            
            fetch(`/cart/remove/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });
});
</script>
@endpush

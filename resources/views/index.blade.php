<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Store | Discover Our Exclusive Collection</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
</head>
<body>
        <!-- Navigation -->
        <nav>
        <div class="container nav-container">
            <div class="logo">
                <span class="logo-icon"><i class="fas fa-shopping-bag"></i></span>
                <span class="logo-text">Abu<span class="logo-highlight">Mart</span></span>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                @if (Auth::check())
                    <li><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('orders.index') }}">Orders</a></li>
                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                    <li><a href="{{ route('cart') }}">Cart</a></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @endif
            </ul>
            <div class="cart-icon" id="cartIcon">
                <a href="{{ route('cart') }}" class="relative inline-block">
                    <i class="fas fa-shopping-cart text-white"></i>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        <span class="cart-count absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section id="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <h1>Discover Our Exclusive Collection</h1>
                <p>Elevate your style with our carefully curated selection of premium products</p>
                <button class="cta-button" onclick="window.location.href='#products'">Shop Now</button>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="products">
        <div class="container">
            <h2>Featured Products</h2>
            <div class="products-grid">
                @foreach($featuredProducts as $product)
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ url($product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <h3>{{ $product->name }}</h3>
                        <p class="price">${{ number_format($product->price, 2) }}</p>
                        @auth
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="add-to-cart">Add to Cart</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="add-to-cart">Login to Buy</a>
                        @endauth
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Us -->
    <section id="about">
        <div class="container about-container">
            <div class="about-content">
                <h2>About Us</h2>
                <p>Welcome to AbuMart, where quality meets convenience. We are a modern online store committed to providing you with the best shopping experience. Our mission is to bring you top-notch products, excellent customer service, and a seamless journey from browsing to checkout. At AbuMart, we believe in making every purchase memorable, ensuring you find exactly what you need with just a click.</p>
                <div class="qr-code-container">
                    <img src="{{ asset('images/qr.PNG')}}" alt="AbuMart QR Code" class="qr-code">
                    <p class="qr-text">Scan to verify our products</p>
                </div>
            </div>
            <div class="about-image-grid">
                <div class="about-image feature-image">
                    <img src="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?q=80&w=2070" alt="Premium Fashion Collection">
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1523170335258-f5ed11844a49?q=80&w=1180" alt="Luxury Watch Collection">
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=1180" alt="Designer Shoe Collection">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials">
        <div class="container">
            <h2>What Our Customers Say</h2>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-image">
                        <img src="{{ asset('images/aa.PNG')}}" alt="Customer 1">
                    </div>
                    <p class="testimonial-text">"Amazing quality and exceptional service. I'm a happy returning customer!"</p>
                    <p class="customer-name">- Sarah Johnson</p>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-image">
                        <img src="https://img.freepik.com/free-photo/beautiful-happy-arabian-female-touches-cheeks-gently-has-charming-smile-wears-traditional-pink-veil-head_273609-27300.jpg?t=st=1736424114~exp=1736427714~hmac=3fb31b0e89894805347efb478e91a230379a751c1f3cbe364e02ccd1350ef196&w=740" alt="Customer 2">
                    </div>
                    <p class="testimonial-text">"The best online shopping experience I've ever had. Highly recommended!"</p>
                    <p class="customer-name">- Michael Brown</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section id="newsletter">
        <div class="container newsletter-container">
            <h2>Stay Updated</h2>
            <p>Subscribe to our newsletter for exclusive offers and updates</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit" class="subscribe-button">Subscribe</button>
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

    <style>
    .cart-modal {
        display: none;
        position: fixed;
        top: 0;
        right: 0;
        width: 400px;
        height: 100vh;
        background: white;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 1000;
    }

    .cart-content {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .cart-header {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .cart-item-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin-right: 1rem;
    }

    .cart-item-details {
        flex: 1;
    }

    .cart-item-quantity {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .quantity-btn {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: white;
        cursor: pointer;
    }

    .cart-footer {
        padding: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .cart-total {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        font-weight: bold;
    }

    .checkout-button {
        display: block;
        width: 100%;
        padding: 0.75rem;
        background: #4299e1;
        color: white;
        text-align: center;
        border-radius: 0.375rem;
        margin-bottom: 0.5rem;
        text-decoration: none;
    }

    .continue-shopping {
        display: block;
        width: 100%;
        padding: 0.75rem;
        background: #48bb78;
        color: white;
        text-align: center;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
    }

    .empty-cart-message {
        text-align: center;
        color: #718096;
        padding: 2rem;
    }

    .remove-item {
        color: #e53e3e;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartIcon = document.getElementById('cartIcon');
        const cartModal = document.getElementById('cartModal');
        const closeCart = document.getElementById('closeCart');
        const continueShopping = document.getElementById('continueShopping');

        // Toggle cart modal
        cartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            cartModal.style.display = 'block';
        });

        // Close cart modal
        closeCart.addEventListener('click', function() {
            cartModal.style.display = 'none';
        });

        continueShopping.addEventListener('click', function() {
            cartModal.style.display = 'none';
        });

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

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section brand-section">
                    <div class="footer-logo">
                        <span class="logo-icon"><i class="fas fa-shopping-bag"></i></span>
                        <span class="logo-text">Abu<span class="logo-highlight">Mart</span></span>
                    </div>
                    <p class="footer-tagline">Your Premier Destination for Fashion, Watches & Footwear</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Categories</h3>
                    <ul class="footer-links">
                        <li><a href="#clothing">Clothing</a></li>
                        <li><a href="#watches">Watches</a></li>
                        <li><a href="#shoes">Shoes</a></li>
                        <li><a href="#accessories">Accessories</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <ul class="footer-contact">
                        <li><i class="fas fa-phone"></i> +234 90 7796 7626</li>
                        <li><i class="fas fa-envelope"></i> info@abumart.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> 17 Olumbe Bassir, New Bodija Estate, Ibadan</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 AbuMart. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js')}}"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'AbuMart') }}</title>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Pusher -->
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
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
                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    @auth
                        <li><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('orders.index') }}">Orders</a></li>
                        <li>
                            <a href="{{ route('notifications.index') }}" class="relative">
                                <span>Notifications</span>
                                <span id="notification-count" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full h-4 w-4 flex items-center justify-center text-xs{{ \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count() === 0 ? ' hidden' : '' }}">
                                    {{ \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count() }}
                                </span>
                            </a>
                        </li>
                        <li><a href="{{ route('cart') }}">Cart</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

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
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('shop.index') }}">Shop</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <h3>Categories</h3>
                        <ul class="footer-links">
                            <li><a href="{{ route('shop.index', ['category' => 1]) }}">Clothing</a></li>
                            <li><a href="{{ route('shop.index', ['category' => 2]) }}">Watches</a></li>
                            <li><a href="{{ route('shop.index', ['category' => 3]) }}">Shoes</a></li>
                            <li><a href="{{ route('shop.index', ['category' => 4]) }}">Accessories</a></li>
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

        <script src="{{ asset('js/script.js') }}"></script>
        
        <!-- Pusher Configuration and Notifications -->
        <script>
            const PUSHER_APP_KEY = '{{ env("PUSHER_APP_KEY") }}';
            const PUSHER_APP_CLUSTER = '{{ env("PUSHER_APP_CLUSTER") }}';
            const USER_ID = {{ auth()->id() ?? 'null' }};
            const USER_ROLE = '{{ auth()->user() && auth()->guard("admin")->check() ? "admin" : "customer" }}';
        </script>
        <script src="{{ asset('js/notifications.js') }}"></script>
    </body>
</html>

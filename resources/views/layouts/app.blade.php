<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'AbuMart') }}</title>
        
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <!-- Vite Assets (commented out for production) -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        
        <!-- Pusher -->
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        
        <!-- Stack for additional styles -->
        @stack('styles')
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
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-pinterest-p"></i></a>
                        </div>
                    </div>
                    <div class="footer-section links-section">
                        <h3>Quick Links</h3>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('shop.index') }}">Shop</a></li>
                            <li><a href="#about">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="footer-section contact-section">
                        <h3>Contact Us</h3>
                        <p><i class="fas fa-map-marker-alt"></i> 123 Fashion Street, Lagos, Nigeria</p>
                        <p><i class="fas fa-phone-alt"></i> +234 123 456 7890</p>
                        <p><i class="fas fa-envelope"></i> info@abumart.com</p>
                        <p><i class="fas fa-clock"></i> Mon-Fri: 9am - 6pm</p>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} AbuMart. All Rights Reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Custom Scripts -->
        <script src="{{ asset('js/script.js') }}"></script>

        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Pusher Configuration and Notifications -->
        <script>
            const PUSHER_APP_KEY = '{{ env("PUSHER_APP_KEY") }}';
            const PUSHER_APP_CLUSTER = '{{ env("PUSHER_APP_CLUSTER") }}';
            const USER_ID = {{ auth()->id() ?? 'null' }};
            const USER_ROLE = '{{ auth()->user() && auth()->guard("admin")->check() ? "admin" : "customer" }}';
        </script>
        <script src="{{ asset('js/notifications.js') }}"></script>
        
        <!-- Stack for additional scripts -->
        @stack('scripts')
    </body>
</html>

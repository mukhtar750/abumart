<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'AbuMart') }}</title>
        
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Pusher -->
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        
        <!-- Stack for additional styles -->
        @stack('styles')
    </head>
    <body class="bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl text-blue-600"><i class="fas fa-shopping-bag"></i></span>
                        <span class="text-xl font-bold text-gray-900">Abu<span class="text-blue-600">Mart</span></span>
                    </div>
                    
                    <ul class="hidden md:flex space-x-8">
                        <li><a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Home</a></li>
                        <li><a href="#about" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">About</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Contact</a></li>
                        @if (Auth::check())
                            <li><a href="{{ route('customer.dashboard') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Dashboard</a></li>
                            <li><a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Orders</a></li>
                            <li><a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Shop</a></li>
                            <li><a href="{{ route('cart') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Cart</a></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Register</a></li>
                        @endif
                    </ul>
                    
                    <div class="relative">
                        <a href="{{ route('cart') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @if(session()->has('cart') && count(session('cart')) > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl text-blue-400"><i class="fas fa-shopping-bag"></i></span>
                            <span class="text-xl font-bold">Abu<span class="text-blue-400">Mart</span></span>
                        </div>
                        <p class="text-gray-300">Your Premier Destination for Fashion, Watches & Footwear</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-200"><i class="fab fa-facebook-f text-xl"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-200"><i class="fab fa-twitter text-xl"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-200"><i class="fab fa-instagram text-xl"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-200"><i class="fab fa-pinterest-p text-xl"></i></a>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">Home</a></li>
                            <li><a href="{{ route('shop.index') }}" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">Shop</a></li>
                            <li><a href="#about" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">About Us</a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">Contact</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">Privacy Policy</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Contact Us</h3>
                        <div class="space-y-2 text-gray-300">
                            <p class="flex items-center space-x-2"><i class="fas fa-map-marker-alt text-blue-400"></i> <span>123 Fashion Street, Lagos, Nigeria</span></p>
                            <p class="flex items-center space-x-2"><i class="fas fa-phone-alt text-blue-400"></i> <span>+234 123 456 7890</span></p>
                            <p class="flex items-center space-x-2"><i class="fas fa-envelope text-blue-400"></i> <span>info@abumart.com</span></p>
                            <p class="flex items-center space-x-2"><i class="fas fa-clock text-blue-400"></i> <span>Mon-Fri: 9am - 6pm</span></p>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-400">&copy; {{ date('Y') }} AbuMart. All Rights Reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Custom Scripts -->
        <script src="{{ asset('js/script.js') }}"></script>

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

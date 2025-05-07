<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Customer Dashboard') - AbuMart</title>
    
    <!-- Styles & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
    
    <style>
        /* Base styles */
        :root {
            --primary-color: #2a9d8f;
            --secondary-color: #264653;
            --accent-color: #e76f51;
            --text-color: #2c3e50;
            --light-gray: #f8f9fa;
            --white: #ffffff;
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Sidebar styling */
        .sidebar {
            width: 250px;
            transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
            background: var(--secondary-color);
        }
        
        .sidebar-collapsed {
            width: 80px;
        }
        
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
        }
        
        .main-content-expanded {
            margin-left: 80px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(0);
                position: fixed;
                z-index: 50;
                width: 250px;
            }
            
            .sidebar.sidebar-mobile-hidden {
                transform: translateX(-100%);
            }
            
            .sidebar-collapsed {
                width: 80px;
            }
            
            .main-content, .main-content-expanded {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
        
        /* Menu item transitions */
        .menu-item {
            transition: all 0.2s ease-in-out;
        }
        
        .menu-item:hover {
            transform: translateX(5px);
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Card hover effects */
        .hover-up {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-up:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Hover scale effect for product cards */
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        
        .hover-scale:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Dark mode transitions */
        .dark-transition {
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }
        
        /* Logo icon styling */
        .logo-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
            color: white;
            transform: rotate(-10deg);
            transition: transform 0.3s ease;
        }
        
        .logo:hover .logo-icon {
            transform: rotate(0deg);
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            letter-spacing: -0.5px;
        }
        
        .logo-highlight {
            color: var(--primary-color);
            position: relative;
        }
        
        .logo-highlight::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        
        .logo:hover .logo-highlight::after {
            transform: scaleX(1);
        }
        
        /* In dark mode, adjust colors */
        .dark .logo-text {
            color: #ffffff;
        }
        
        .dark .logo-highlight {
            color: var(--primary-color);
        }
        
        /* Hide Alpine elements during load */
        [x-cloak] { 
            display: none !important; 
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 dark-transition"
      x-init="
        $watch('darkMode', val => localStorage.setItem('darkMode', val));
        window.matchMedia('(prefers-color-scheme: dark)').matches && !localStorage.getItem('darkMode') ? darkMode = true : null;
      ">
    
    <div class="min-h-screen flex" 
         x-data="{ 
            sidebarOpen: window.innerWidth >= 768, 
            isMobile: window.innerWidth < 768
         }"
         x-init="
            // Initialize mobile detection
            isMobile = window.innerWidth < 768;
            
            // Default sidebar state based on screen size
            sidebarOpen = window.innerWidth >= 768;
            
            // Update on resize
            window.addEventListener('resize', () => {
                const wasMobile = isMobile;
                isMobile = window.innerWidth < 768;
                
                // Only auto-open sidebar when transitioning from mobile to desktop
                if (wasMobile && !isMobile) {
                    sidebarOpen = true;
                }
                
                // Auto-close sidebar when transitioning to mobile
                if (!wasMobile && isMobile) {
                    sidebarOpen = false;
                }
            });
         ">
        <!-- Mobile Overlay -->
        <div 
            x-show="isMobile && sidebarOpen" 
            @click="sidebarOpen = false" 
            class="fixed inset-0 bg-black bg-opacity-50 z-40"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>
        
        <!-- Sidebar -->
        <aside :class="[
                 sidebarOpen ? 'sidebar' : 'sidebar sidebar-collapsed',
                 isMobile && !sidebarOpen ? 'sidebar-mobile-hidden' : ''
               ]" 
               class="fixed top-0 left-0 z-30 h-screen text-white shadow-lg overflow-hidden" 
               :style="darkMode ? 'background-color: #1e293b;' : 'background-color: var(--secondary-color);'">
            
            <!-- Logo Section -->
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center space-x-2 logo" :class="{ 'justify-center w-full': !sidebarOpen || !isMobile }">
                    <div class="logo-icon w-10 h-10 flex items-center justify-center text-xl">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <span x-show="sidebarOpen" class="logo-text text-white dark:text-white">Abu<span class="logo-highlight">Mart</span></span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none" x-show="sidebarOpen && !isMobile">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>
            
            <!-- User Info -->
            <div x-show="sidebarOpen" class="px-4 py-2 border-b border-opacity-20" :class="darkMode ? 'border-gray-700' : 'border-blue-800'">
                <p class="text-sm opacity-75">Welcome,</p>
                <p class="font-semibold truncate">{{ Auth::user()->name }}</p>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="mt-4">
                <div class="px-4 py-2" x-show="!sidebarOpen">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none mx-auto flex justify-center w-full">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
                
                <a href="{{ route('home') }}" class="menu-item flex items-center text-white opacity-75 hover:opacity-100 py-3 px-4" :class="{'bg-opacity-20 bg-white': '{{ request()->routeIs('home') }}'}">
                    <i class="fas fa-home" :class="sidebarOpen ? 'w-6' : 'w-full text-center'"></i>
                    <span x-show="sidebarOpen" class="ml-3">Home</span>
                </a>
                
                <a href="{{ route('customer.dashboard') }}" class="menu-item flex items-center text-white opacity-75 hover:opacity-100 py-3 px-4" :class="{'bg-opacity-20 bg-white': '{{ request()->routeIs('customer.dashboard') }}'}">
                    <i class="fas fa-th-large" :class="sidebarOpen ? 'w-6' : 'w-full text-center'"></i>
                    <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                </a>
                
                <a href="{{ route('orders.index') }}" class="menu-item flex items-center text-white opacity-75 hover:opacity-100 py-3 px-4" :class="{'bg-opacity-20 bg-white': '{{ request()->routeIs('orders.*') }}'}">
                    <i class="fas fa-box" :class="sidebarOpen ? 'w-6' : 'w-full text-center'"></i>
                    <span x-show="sidebarOpen" class="ml-3">My Orders</span>
                </a>
                
                <a href="{{ route('cart') }}" class="menu-item flex items-center text-white opacity-75 hover:opacity-100 py-3 px-4" :class="{'bg-opacity-20 bg-white': '{{ request()->routeIs('cart') }}'}">
                    <i class="fas fa-shopping-cart" :class="sidebarOpen ? 'w-6' : 'w-full text-center'"></i>
                    <span x-show="sidebarOpen" class="ml-3">Shopping Cart</span>
                    @php
                        $cart = session('cart', []);
                        $cartCount = count($cart);
                    @endphp
                    @if($cartCount > 0)
                        <span x-show="sidebarOpen" class="ml-auto bg-red-500 text-white px-2 py-0.5 rounded-full text-xs">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                
                <a href="{{ route('wishlist') }}" class="menu-item flex items-center text-white opacity-75 hover:opacity-100 py-3 px-4" :class="{'bg-opacity-20 bg-white': '{{ request()->routeIs('wishlist') }}'}">
                    <i class="fas fa-heart" :class="sidebarOpen ? 'w-6' : 'w-full text-center'"></i>
                    <span x-show="sidebarOpen" class="ml-3">Wishlist</span>
                </a>
                
                <a href="{{ route('notifications.index') }}" class="menu-item flex items-center text-white opacity-75 hover:opacity-100 py-3 px-4 relative" :class="{'bg-opacity-20 bg-white': '{{ request()->routeIs('notifications.*') }}'}">
                    <i class="fas fa-bell" :class="sidebarOpen ? 'w-6' : 'w-full text-center'"></i>
                    <span x-show="sidebarOpen" class="ml-3">Notifications</span>
                    @php
                        $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->where('is_admin', false)
                            ->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="absolute bg-red-500 text-white rounded-full flex items-center justify-center"
                              :class="sidebarOpen ? 'top-2.5 left-4 transform translate-x-2 -translate-y-1/2 h-5 w-5 text-xs' : 'top-1 right-1 h-4 w-4 text-[10px]'">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
                
                <a href="{{ route('profile.edit') }}" class="menu-item flex items-center text-white opacity-75 hover:opacity-100 py-3 px-4" :class="{'bg-opacity-20 bg-white': '{{ request()->routeIs('profile.edit') }}'}">
                    <i class="fas fa-user" :class="sidebarOpen ? 'w-6' : 'w-full text-center'"></i>
                    <span x-show="sidebarOpen" class="ml-3">Profile</span>
                </a>
                
                <div x-data="{ open: false }" class="menu-item">
                    <button @click="open = !open" class="w-full flex items-center text-white opacity-75 hover:opacity-100 py-3 px-4">
                        <i class="fas fa-cog" :class="sidebarOpen ? 'w-6' : 'w-full text-center'"></i>
                        <span x-show="sidebarOpen" class="ml-3">Settings</span>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down ml-auto transform transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    
                    <div x-show="open" x-cloak class="pl-8 pr-4 py-1 text-sm">
                        <a href="#" @click="darkMode = !darkMode" class="menu-item block text-white opacity-75 hover:opacity-100 py-2">
                            <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                            <span class="ml-2" x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                        </a>
                        <a href="#" class="menu-item block text-white opacity-75 hover:opacity-100 py-2">
                            <i class="fas fa-shield-alt"></i>
                            <span class="ml-2">Privacy</span>
                        </a>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="menu-item w-full flex items-center text-white opacity-75 hover:opacity-100 py-3 px-4">
                        <i class="fas fa-sign-out-alt" :class="sidebarOpen ? 'w-6' : 'w-full text-center'"></i>
                        <span x-show="sidebarOpen" class="ml-3">Logout</span>
                    </button>
                </form>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main :class="[
                 !isMobile && sidebarOpen ? 'main-content' : '',
                 !isMobile && !sidebarOpen ? 'main-content-expanded' : '',
                 isMobile ? 'w-full' : ''
               ]" 
               class="min-h-screen pt-4 pb-16 px-4 sm:px-6 transition-all duration-300">
            <!-- Top Navigation Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 mb-6">
                <div class="flex justify-between items-center">
                    <!-- Mobile menu button -->
                    <div class="flex items-center">
                      <button @click="sidebarOpen = !sidebarOpen" class="md:hidden rounded-md p-2 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none mr-2">
                          <i class="fas" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
                      </button>
                      
                      <h1 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white truncate">
                          @yield('page-title', 'Dashboard')
                      </h1>
                    </div>
                    
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <!-- Search -->
                        <div class="hidden md:block relative">
                            <input type="text" placeholder="Search..." class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200" :class="darkMode ? 'bg-gray-700 text-yellow-500' : 'bg-gray-100 text-blue-600'">
                            <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                        </button>
                        
                        <!-- Notifications -->
                        <div class="relative">
                            <a href="{{ route('notifications.index') }}" class="block p-2 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200 relative">
                                <i class="fas fa-bell text-gray-600 dark:text-gray-300"></i>
                                @if($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 h-5 w-5 flex items-center justify-center bg-red-500 text-white text-xs rounded-full">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        </div>
                        
                        <!-- User Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center focus:outline-none">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white"
                                     :class="darkMode ? 'bg-gray-600' : 'bg-gradient-to-r from-primary-color to-secondary-color'"
                                     style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                                    @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                </div>
                                <span class="hidden md:inline text-gray-800 dark:text-white ml-2">{{ Str::limit(Auth::user()->name, 10) }}</span>
                                <i class="fas fa-chevron-down text-sm text-gray-600 dark:text-gray-400 hidden md:inline ml-1"></i>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-700 origin-top-right">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-user-circle mr-2"></i> Profile
                                </a>
                                <a href="#" @click="darkMode = !darkMode" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                                    <span class="ml-2" x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // This script handles client-side functionality
        document.addEventListener('alpine:init', () => {
            Alpine.store('ui', {
                isMobile: window.innerWidth < 768,
                updateScreenSize() {
                    this.isMobile = window.innerWidth < 768;
                }
            });
            
            // Listen for resize events to update screen size state
            window.addEventListener('resize', () => {
                Alpine.store('ui').updateScreenSize();
            });
        });
        
        // Handle navigation and mark-as-read actions
        document.addEventListener('DOMContentLoaded', function() {
            // Handle any notification read actions to prevent navigation issues
            const notificationForms = document.querySelectorAll('form[action*="notifications/read"]');
            notificationForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Submit form via fetch API
                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(new FormData(this))
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Refresh the page to show updated notifications
                        window.location.reload();
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</body>
</html> 
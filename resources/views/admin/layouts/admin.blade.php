<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'AbuMart') }} - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Pusher -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
    
    <style>
        /* General styles */
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        /* Sidebar styles */
        .sidebar {
            width: 260px;
            transition: width 0.3s;
        }
        
        .sidebar-collapsed {
            width: 80px;
        }
        
        .main-content {
            margin-left: 260px;
            transition: margin-left 0.3s;
        }
        
        .main-content-expanded {
            margin-left: 80px;
        }
        
        .nav-item {
            position: relative;
        }
        
        .nav-item .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .nav-item.active .submenu {
            max-height: 500px;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Card animations */
        .hover-up {
            transition: transform 0.2s, box-shadow 0.2s;
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
        .dark-mode-transition {
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            height: 1.5rem;
            width: 1.5rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body x-data="{ sidebarOpen: true, darkMode: localStorage.getItem('darkMode') === 'true' }" 
      :class="darkMode ? 'dark bg-gray-900 text-white' : 'bg-gray-100'"
      class="transition-colors duration-200">
    
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'sidebar' : 'sidebar sidebar-collapsed'" 
           class="fixed top-0 left-0 h-screen bg-blue-800 dark:bg-gray-800 text-white z-20 overflow-hidden">
        
        <!-- Logo Section -->
        <div class="flex items-center justify-between p-4 border-b border-blue-700 dark:border-gray-700">
            <div class="flex items-center space-x-2">
                <i class="fas fa-shopping-bag text-white text-2xl"></i>
                <span x-show="sidebarOpen" class="text-xl font-semibold transition-opacity duration-200">AbuMart</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none">
                <i class="fas" :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
            </button>
        </div>
        
        <!-- Admin Info -->
        <div class="flex items-center p-4 border-b border-blue-700 dark:border-gray-700">
            <div class="w-10 h-10 rounded-full bg-blue-600 dark:bg-gray-600 flex items-center justify-center">
                <i class="fas fa-user"></i>
            </div>
            <div x-show="sidebarOpen" class="ml-3 transition-opacity duration-200">
                <p class="font-semibold">{{ Auth::user()->name }}</p>
                <p class="text-xs text-blue-200 dark:text-gray-300">Administrator</p>
            </div>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="mt-4">
            <ul>
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-4 text-white hover:bg-blue-700 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 dark:bg-gray-700' : '' }}">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span x-show="sidebarOpen" class="ml-2 transition-opacity duration-200">Dashboard</span>
                    </a>
                </li>
                
                <!-- Products -->
                <li class="nav-item" x-data="{ open: {{ request()->routeIs('admin.products.*') ? 'true' : 'false' }} }">
                    <a @click="open = !open" class="flex items-center justify-between py-3 px-4 text-white hover:bg-blue-700 dark:hover:bg-gray-700 cursor-pointer transition-colors duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-blue-700 dark:bg-gray-700' : '' }}">
                        <div class="flex items-center">
                            <i class="fas fa-box w-6"></i>
                            <span x-show="sidebarOpen" class="ml-2 transition-opacity duration-200">Products</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                    </a>
                    <ul x-show="open" class="submenu bg-blue-900 dark:bg-gray-900 transition-all duration-200 ease-in-out">
                        <li>
                            <a href="{{ route('admin.products.index') }}" class="py-2 pl-12 pr-4 block text-blue-200 dark:text-gray-300 hover:bg-blue-700 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.products.index') ? 'bg-blue-700 dark:bg-gray-700 text-white' : '' }}">
                                All Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.create') }}" class="py-2 pl-12 pr-4 block text-blue-200 dark:text-gray-300 hover:bg-blue-700 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.products.create') ? 'bg-blue-700 dark:bg-gray-700 text-white' : '' }}">
                                Add New
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center py-3 px-4 text-white hover:bg-blue-700 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-blue-700 dark:bg-gray-700' : '' }}">
                        <i class="fas fa-shopping-cart w-6"></i>
                        <span x-show="sidebarOpen" class="ml-2 transition-opacity duration-200">Orders</span>
                    </a>
                </li>
                
                <!-- Users -->
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="flex items-center py-3 px-4 text-white hover:bg-blue-700 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('users.*') ? 'bg-blue-700 dark:bg-gray-700' : '' }}">
                        <i class="fas fa-users w-6"></i>
                        <span x-show="sidebarOpen" class="ml-2 transition-opacity duration-200">Users</span>
                    </a>
                </li>
                
                <!-- Notifications -->
                <li class="nav-item">
                    <a href="{{ route('admin.notifications.index') }}" class="relative flex items-center py-3 px-4 text-white hover:bg-blue-700 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.notifications.*') ? 'bg-blue-700 dark:bg-gray-700' : '' }}">
                        <i class="fas fa-bell w-6"></i>
                        <span x-show="sidebarOpen" class="ml-2 transition-opacity duration-200">Notifications</span>
                        @php
                            $notificationCount = \App\Models\Notification::where('is_admin', true)
                                ->where('is_read', false)
                                ->count();
                        @endphp
                        @if($notificationCount > 0)
                            <span class="absolute top-2 left-4 h-5 w-5 flex items-center justify-center bg-red-500 text-white text-xs rounded-full">
                                {{ $notificationCount }}
                            </span>
                        @endif
                    </a>
                </li>
                
                <!-- Settings -->
                <li class="nav-item" x-data="{ open: false }">
                    <a @click="open = !open" class="flex items-center justify-between py-3 px-4 text-white hover:bg-blue-700 dark:hover:bg-gray-700 cursor-pointer transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-cog w-6"></i>
                            <span x-show="sidebarOpen" class="ml-2 transition-opacity duration-200">Settings</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                    </a>
                    <ul x-show="open" class="submenu bg-blue-900 dark:bg-gray-900 transition-all duration-200 ease-in-out">
                        <li>
                            <a href="#" class="py-2 pl-12 pr-4 block text-blue-200 dark:text-gray-300 hover:bg-blue-700 dark:hover:bg-gray-700 transition-colors duration-200">
                                Site Settings
                            </a>
                        </li>
                        <li>
                            <a href="#" @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="py-2 pl-12 pr-4 block text-blue-200 dark:text-gray-300 hover:bg-blue-700 dark:hover:bg-gray-700 transition-colors duration-200">
                                Toggle Theme
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <!-- Logout -->
        <div class="absolute bottom-0 w-full border-t border-blue-700 dark:border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full py-3 px-4 text-white hover:bg-blue-700 dark:hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span x-show="sidebarOpen" class="ml-2 transition-opacity duration-200">Logout</span>
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main :class="sidebarOpen ? 'main-content' : 'main-content main-content-expanded'" class="min-h-screen pt-4 pb-16 px-6">
        <!-- Top Navigation Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="mr-4 text-gray-600 dark:text-gray-300 lg:hidden focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <div class="hidden md:block relative">
                    <input type="text" placeholder="Search..." class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                    <i class="fas" :class="darkMode ? 'fa-sun text-yellow-500' : 'fa-moon text-blue-600'"></i>
                </button>
                
                <!-- Notifications -->
                <div class="relative">
                    <a href="{{ route('admin.notifications.index') }}" class="block p-2 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200 relative">
                        <i class="fas fa-bell text-gray-600 dark:text-gray-300"></i>
                        @if($notificationCount > 0)
                            <span class="absolute -top-1 -right-1 h-5 w-5 flex items-center justify-center bg-red-500 text-white text-xs rounded-full">
                                {{ $notificationCount }}
                            </span>
                        @endif
                    </a>
                </div>
                
                <!-- User Menu -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-blue-600 dark:bg-gray-600 flex items-center justify-center text-white">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="hidden md:inline text-gray-800 dark:text-white">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-sm text-gray-600 dark:text-gray-400"></i>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-700">
                        <a href="#" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                        <a href="#" @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                            <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Page Content -->
        @yield('content')
    </main>
    
    <!-- Pusher Configuration and Notifications -->
    <script>
        const PUSHER_APP_KEY = '{{ env("PUSHER_APP_KEY") }}';
        const PUSHER_APP_CLUSTER = '{{ env("PUSHER_APP_CLUSTER") }}';
        const USER_ID = {{ auth()->id() ?? 'null' }};
        const USER_ROLE = 'admin';
    </script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html> 
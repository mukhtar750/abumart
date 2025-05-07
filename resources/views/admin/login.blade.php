@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-6">Admin Login</h2>

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-white font-semibold">Email Address</label>
                <input type="email" name="email" id="email"
                    class="w-full px-4 py-3 mt-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                    placeholder="Enter your email" required>
            </div>

            <!-- Password Input with Toggle -->
            <div class="mb-4 relative">
                <label for="password" class="block text-gray-700 dark:text-white font-semibold">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-3 mt-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                    placeholder="Enter your password" required>
                <button type="button" onclick="togglePassword()" class="absolute top-10 right-4 text-gray-500 dark:text-gray-300">
                    👁
                </button>
            </div>

            <!-- Forgot Password & Remember Me -->
            <div class="flex justify-between items-center mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" class="text-blue-500">
                    <span class="ml-2 text-gray-700 dark:text-gray-300">Remember me</span>
                </label>
                <a href="#" class="text-blue-500 hover:underline">Forgot password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300">
                Login
            </button>
        </form>

        <!-- Dark Mode Toggle -->
        <div class="mt-6 text-center">
            <button id="toggleDarkMode" class="text-gray-600 dark:text-gray-300 hover:text-blue-500">
                Toggle Dark Mode
            </button>
        </div>
    </div>
</div>

<!-- Scripts for Password Toggle & Dark Mode -->
<script>
    function togglePassword() {
        let password = document.getElementById('password');
        password.type = password.type === "password" ? "text" : "password";
    }

    document.getElementById('toggleDarkMode').addEventListener('click', function() {
        document.documentElement.classList.toggle('dark');
    });
</script>
@endsection

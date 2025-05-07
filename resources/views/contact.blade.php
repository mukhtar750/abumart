@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-center">Contact Us</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" id="name" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                        required value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                        required value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-gray-700 font-semibold mb-2">Subject</label>
                    <input type="text" name="subject" id="subject" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                        required value="{{ old('subject') }}">
                    @error('subject')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-gray-700 font-semibold mb-2">Message</label>
                    <textarea name="message" id="message" rows="6" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                        required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                    Send Message
                </button>
            </form>
        </div>

        <!-- Contact Information -->
        <div class="mt-12 grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                </div>
                <h3 class="font-semibold mb-2">Address</h3>
                <p class="text-gray-600">17 Olumbe Bassir, New Bodija Estate, Ibadan</p>
            </div>

            <div class="text-center">
                <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-phone text-blue-600 text-xl"></i>
                </div>
                <h3 class="font-semibold mb-2">Phone</h3>
                <p class="text-gray-600">+234 90 7796 7626</p>
            </div>

            <div class="text-center">
                <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                </div>
                <h3 class="font-semibold mb-2">Email</h3>
                <p class="text-gray-600">info@abumart.com</p>
            </div>
        </div>
    </div>
</div>
@endsection 
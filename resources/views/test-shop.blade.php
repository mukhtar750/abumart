@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Test Shop Page</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Test Product 1 -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-2">Test Product 1</h2>
            <p class="text-gray-600 mb-4">This is a test product description.</p>
            <p class="text-blue-600 font-bold">$99.99</p>
        </div>

        <!-- Test Product 2 -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-2">Test Product 2</h2>
            <p class="text-gray-600 mb-4">Another test product description.</p>
            <p class="text-blue-600 font-bold">$149.99</p>
        </div>

        <!-- Test Product 3 -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-2">Test Product 3</h2>
            <p class="text-gray-600 mb-4">Yet another test product description.</p>
            <p class="text-blue-600 font-bold">$199.99</p>
        </div>
    </div>
</div>
@endsection 
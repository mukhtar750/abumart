@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
            
            @foreach($cart as $productId => $item)
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        @if(isset($item['image']))
                            <img src="{{ url($item['image']) }}" 
                                 alt="{{ $item['name'] }}" 
                                 class="w-16 h-16 object-cover rounded mr-4">
                        @endif
                        <div>
                            <h3 class="font-semibold">{{ $item['name'] }}</h3>
                            <p class="text-gray-600">Quantity: {{ $item['quantity'] }}</p>
                        </div>
                    </div>
                    <p class="font-semibold">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                </div>
            @endforeach

            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between font-bold">
                    <span>Total:</span>
                    <span>₦{{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Shipping Information</h2>

            <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="shipping_address">
                        Shipping Address
                    </label>
                    <textarea name="shipping_address" id="shipping_address" rows="3" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                        Phone Number
                    </label>
                    <input type="text" name="phone" id="phone" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required value="{{ old('phone') }}">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Payment Method
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="card" class="mr-2" checked>
                            Pay with Card
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <button type="submit" 
                    class="w-full bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition duration-200"
                    id="submitButton">
                    Place Order
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    
    const submitButton = document.getElementById('submitButton');
    submitButton.disabled = true;
    submitButton.textContent = 'Processing...';

    // Submit the form
    this.submit();
});
</script>
@endsection 
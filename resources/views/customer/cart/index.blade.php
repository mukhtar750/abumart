@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Your Cart</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('cart') as $productId => $product)
                    <tr>
                        <td class="px-4 py-2">
                            <div class="flex items-center">
                                @if(isset($product['image']))
                                    <img src="{{ url($product['image']) }}" 
                                         alt="{{ $product['name'] }}" 
                                         class="w-16 h-16 object-cover rounded mr-4">
                                @endif
                                <span>{{ $product['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-2">₦{{ number_format($product['price'], 2) }}</td>
                        <td class="px-4 py-2">
                            <input type="number" 
                                   min="1" 
                                   value="{{ $product['quantity'] }}" 
                                   class="form-control quantity-input w-20 px-2 py-1 border rounded" 
                                   data-id="{{ $productId }}">
                        </td>
                        <td class="px-4 py-2">₦{{ number_format($product['price'] * $product['quantity'], 2) }}</td>
                        <td class="px-4 py-2">
                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 remove-from-cart" 
                                    data-id="{{ $productId }}">
                                Remove
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right px-4 py-2 font-bold">Total:</td>
                    <td class="px-4 py-2 font-bold">
                        ₦{{ number_format(array_reduce(session('cart'), function($carry, $item) {
                            return $carry + ($item['price'] * $item['quantity']);
                        }, 0), 2) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-8 flex justify-between">
            <a href="{{ route('shop.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Continue Shopping
            </a>
            <a href="{{ route('checkout.index') }}" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                Proceed to Checkout (₦{{ number_format(array_reduce(session('cart'), function($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0), 2) }})
            </a>
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-600 mb-4">Your cart is empty.</p>
            <a href="{{ route('shop.index') }}" 
               class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Start Shopping
            </a>
        </div>
    @endif
</div>

<!-- Cart Modal -->
<div class="cart-modal" id="cartModal" style="display:none;">
    <div class="cart-content">
        <h3>Success!</h3>
        <p id="cartMessage"></p>
        <button id="closeCart">Close</button>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.getAttribute('data-id');
            const quantity = this.value;

            // Make an AJAX request to update the cart
            fetch(`/cart/update/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload the page to see updated cart
                }
            });
        });
    });

    document.querySelectorAll('.remove-from-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');

            // Make an AJAX request to remove the item from the cart
            fetch(`/cart/remove/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload the page to see updated cart
                }
            });
        });
    });

    $(document).ready(function() {
        $('.add-to-cart-form').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    // Check if the response contains a redirect URL
                    if (response.redirect) {
                        // Redirect to the cart page
                        window.location.href = response.redirect;
                    } else {
                        // Show success message (you can customize this)
                        alert(response.success);
                    }
                },
                error: function(xhr) {
                    // Handle error
                    alert('Error adding product to cart.');
                }
            });
        });
    });

    function showCartModal(message) {
        $('#cartMessage').text(message);
        $('#cartModal').show();
    }

    $('#closeCart').on('click', function() {
        $('#cartModal').hide();
    });
</script>
@endsection
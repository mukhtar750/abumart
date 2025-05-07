@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Process Payment</h2>
        
        <div class="text-center">
            <p class="mb-4">Total Amount: ₦{{ number_format($data['amount'], 2) }}</p>
            
            <button type="button" 
                    id="payButton"
                    class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                Pay Now
            </button>
        </div>
    </div>
</div>

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
    function makePayment() {
        try {
            FlutterwaveCheckout({
                public_key: "FLWPUBK_TEST-7a26ecf9dc3fe3d5e3eaece49d0fd333-X",
                tx_ref: "{{ $data['tx_ref'] }}",
                amount: {{ $data['amount'] }},
                currency: "NGN",
                country: "NG",
                payment_options: "card",
                redirect_url: "{{ $data['redirect_url'] }}",
                customer: {
                    email: "{{ $data['customer']['email'] }}",
                    name: "{{ $data['customer']['name'] }}"
                },
                customizations: {
                    title: "{{ $data['customizations']['title'] }}",
                    description: "{{ $data['customizations']['description'] }}",
                    logo: "{{ $data['customizations']['logo'] }}"
                },
                callback: function(response) {
                    console.log('Payment response:', response);
                    if(response.status === "successful") {
                        window.location.href = "{{ $data['redirect_url'] }}?status=successful&transaction_id=" + response.transaction_id;
                    } else {
                        window.location.href = "{{ $data['redirect_url'] }}?status=failed";
                    }
                },
                onclose: function() {
                    window.location.href = "{{ route('cart') }}";
                }
            });
        } catch (error) {
            console.error('Payment initialization error:', error);
            alert('Error initializing payment. Please try again.');
        }
    }

    // Add click event listener to the button
    document.getElementById('payButton').addEventListener('click', makePayment);
</script>
@endsection 
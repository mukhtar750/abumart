<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    public function process($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Generate a unique transaction reference
        $reference = 'ABM_'.time().'_'.$order->id;

        // Prepare the payment data
        $data = [
            "public_key" => config('services.flutterwave.public_key'),
            "tx_ref" => $reference,
            "amount" => $order->total_amount,
            "currency" => "NGN",
            "payment_options" => "card,banktransfer",
            "redirect_url" => route('payment.callback'),
            "customer" => [
                "email" => auth()->user()->email,
                "name" => auth()->user()->name
            ],
            "meta" => [
                "order_id" => $order->id
            ],
            "customizations" => [
                "title" => "AbuMart Order Payment",
                "description" => "Payment for order #" . $order->id,
                "logo" => asset('images/logo.png')
            ]
        ];

        // Return view with payment data
        return view('payment.process', compact('data'));
    }

    public function callback(Request $request)
    {
        \Log::info('Payment callback received:', $request->all());

        try {
            if ($request->status === 'successful') {
                $transactionId = $request->transaction_id;
                \Log::info('Transaction ID:', ['id' => $transactionId]);
                
                // Verify the transaction
                $response = $this->verifyTransaction($transactionId);
                \Log::info('Transaction verification response:', (array)$response);
                
                if ($response && isset($response['status']) && $response['status'] === 'success') {
                    $orderId = $response['data']['meta']['order_id'] ?? null;
                    
                    if ($orderId) {
                        $order = Order::find($orderId);
                        
                        if ($order) {
                            $order->status = 'paid';
                            $order->save();
                            
                            session()->forget('cart');
                            
                            return redirect()->route('checkout.success', ['order' => $order->id])
                                ->with('success', 'Payment successful!');
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Payment callback error:', ['error' => $e->getMessage()]);
        }

        return redirect()->route('checkout.index')
            ->with('error', 'Payment failed or was cancelled. Please try again.');
    }

    private function verifyTransaction($transactionId)
    {
        $secretKey = config('services.flutterwave.secret_key');
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$transactionId}/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer " . $secretKey
            ]
        ]);
        
        $response = curl_exec($curl);
        curl_close($curl);
        
        return json_decode($response, true);
    }
}

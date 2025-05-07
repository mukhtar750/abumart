<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Assuming you have a Product model
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Add product to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = Session::get('cart', []);
        $productId = $request->input('product_id');
        
        // Get the product details
        $product = Product::find($productId);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'quantity' => 1,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        Session::put('cart', $cart);
        
        // Redirect back with success message
        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    // Update product quantity in cart
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found in cart']);
    }

    // Remove product from cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found in cart']);
    }

    // View cart page
    public function index()
    {
        return view('customer.cart.index');
    }
}

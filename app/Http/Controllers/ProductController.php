<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with('category')->latest();
        
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
        
        $products = $query->paginate(12);
        $categories = Category::all();
        
        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category');
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        return view('shop.show', compact('product', 'relatedProducts'));
    }

    // ... other public product display methods ...
}
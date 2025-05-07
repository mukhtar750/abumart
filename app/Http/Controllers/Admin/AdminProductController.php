<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Events\NewProductEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Important!

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10); // Eager load category
        return view('admin.products.index', compact('products'));
    }
    

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:1000',
        ]);

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Move the file directly to public/products
                $file->move(public_path('products'), $filename);
                
                // Store the relative path in the database
                $imagePath = 'products/' . $filename;

                \Log::info('Image upload debug:', [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_path' => $imagePath,
                    'full_path' => public_path($imagePath)
                ]);
            }

            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $imagePath ?? null,
                'category_id' => $request->category_id,
                'description' => $request->description,
            ]);

            // Dispatch event for real-time notification
            event(new NewProductEvent($product));

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            \Log::error('Product creation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories')); // Make sure this view exists
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:1000',
        ]);

        try {
            $product = Product::findOrFail($id);
            
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Move the file directly to public/products
                $file->move(public_path('products'), $filename);
                
                // Store the relative path in the database
                $imagePath = 'products/' . $filename;
                $product->image = $imagePath;
            }

            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Product update failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
    
}
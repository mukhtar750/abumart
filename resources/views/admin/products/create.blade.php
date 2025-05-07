@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Upload New Product</h1>
        <button id="toggleDarkMode" class="px-4 py-2 bg-blue-600 text-white rounded-md">
            Toggle Dark Mode
        </button>
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 p-6 shadow-lg rounded-lg">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="name">
                    Product Name
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                    placeholder="Enter product name" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="price">
                    Price (₦)
                </label>
                <input type="number" name="price" id="price" value="{{ old('price') }}"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                    placeholder="Enter product price" required>
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="stock">
                    Stock Quantity
                </label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                    placeholder="Enter stock quantity" min="0" required>
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Description -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="description">
                    Product Description
                </label>
                <textarea name="description" id="description"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                    rows="4" placeholder="Enter product description" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Selection -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="category_id">
                    Select Category
                </label>
                <select name="category_id" id="category_id"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white" required>
                    <option value="">Choose a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="image">
                    Product Image
                </label>
                <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(event)">
                <label for="image" class="cursor-pointer flex flex-col items-center justify-center border-dashed border-2 border-gray-400 dark:border-gray-600 p-6 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-300">Click to upload an image</span>
                </label>
                <div class="mt-4">
                    <img id="preview" class="hidden w-40 h-40 object-cover rounded-lg">
                </div>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300">
                Upload Product
            </button>
        </form>
    </div>
</div>

<!-- Dark Mode & Image Preview Script -->
<script>
    // Toggle Dark Mode
    document.getElementById('toggleDarkMode').addEventListener('click', function() {
        document.documentElement.classList.toggle('dark');
    });

    // Image Preview Function
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection

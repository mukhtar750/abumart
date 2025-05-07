<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;

// Public routes
Route::get('/', function () {
    // Get featured products for the landing page
    $featuredProducts = \App\Models\Product::with('category')
        ->latest()
        ->take(4)  // Since your index shows 4 featured products
        ->get();
    return view('index', compact('featuredProducts'));
})->name('home');

Route::view('/contact', 'contact')->name('contact');
Route::view('/about', 'about')->name('about');

// Public product routes (accessible to everyone)
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ProductController::class, 'show'])->name('shop.show');

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard')->middleware('auth');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/purchase', [PurchaseController::class, 'purchase'])->name('purchase');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');

    // Other authenticated routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // Payment Routes
    Route::get('/payment/process/{order}', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
});

// Test profile upload
Route::view('/test-upload', 'test_upload');
Route::post('/test-upload', [ProfileController::class, 'uploadTest'])->name('profile.upload.test');

// Purchase routes
Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');

// Authentication routes (for regular users)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [AdminController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Admin Product Routes using AdminProductController
        Route::resource('products', AdminProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);

        // Admin Order Routes
        Route::get('orders', [App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('orders/{order}', [App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('orders/{order}/status', [App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');

        // Admin Notification Routes
        Route::get('notifications', [App\Http\Controllers\Admin\AdminNotificationController::class, 'index'])->name('admin.notifications.index');
        Route::post('notifications/{id}/read', [App\Http\Controllers\Admin\AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.read');
        Route::post('notifications/read-all', [App\Http\Controllers\Admin\AdminNotificationController::class, 'markAllAsRead'])->name('admin.notifications.read-all');
        Route::get('notifications/unread-count', [App\Http\Controllers\Admin\AdminNotificationController::class, 'getUnreadCount'])->name('admin.notifications.unread-count');

        Route::resource('users', UserController::class);

        // Change Password Routes (moved inside auth:admin middleware)
        Route::get('/change-password', [AdminController::class, 'showChangePasswordForm'])->name('admin.change-password');
        Route::post('/change-password', [AdminController::class, 'changePassword'])->name('admin.change-password.update');

    });
});

// Test route
Route::get('/test-shop', function () {
    return view('test-shop');
})->name('test.shop');

// Contact routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

require __DIR__ . '/auth.php';
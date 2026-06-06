<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\CouponAdminController;
use App\Http\Controllers\Admin\ChatAdminController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/shop/category/{category}', [HomeController::class, 'shop'])->name('shop.category');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/product/{product}/reviews', [ProductController::class, 'addReview'])
    ->middleware('auth')
    ->name('reviews.store');

// Chat Widget Routes (Public so guests can chat as well)
Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
Route::get('/chat/unread', [ChatController::class, 'getUnreadCount'])->name('chat.unread');

// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Checkout Routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Payment Routes
    Route::get('/payment/vnpay/{order}', [PaymentController::class, 'vnpay'])->name('payment.vnpay');
    Route::get('/payment/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('payment.vnpay.return');
});

// Wishlist Routes
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/order/{order}', [ProfileController::class, 'orderDetail'])->name('profile.orderDetail');
    Route::post('/profile/order/{order}/cancel', [ProfileController::class, 'cancelOrder'])->name('profile.order.cancel');
    Route::get('/profile/wishlist', [ProfileController::class, 'wishlist'])->name('profile.wishlist');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products Management
    Route::resource('products', ProductAdminController::class);
    
    // Categories Management
    Route::resource('categories', CategoryAdminController::class);
    
    // Orders Management
    Route::resource('orders', OrderAdminController::class)->only(['index', 'show', 'update', 'destroy']);
    
    // Users Management
    Route::resource('users', UserAdminController::class);
    
    // Coupons Management
    Route::resource('coupons', CouponAdminController::class);

    // Support Chat Management
    Route::get('/chats', [ChatAdminController::class, 'index'])->name('chats.index');
    Route::get('/chats/sessions', [ChatAdminController::class, 'getSessions'])->name('chats.sessions');
    Route::get('/chats/messages/{sessionId}', [ChatAdminController::class, 'getMessages'])->name('chats.messages');
    Route::post('/chats/send/{sessionId}', [ChatAdminController::class, 'sendMessage'])->name('chats.send');
});

// Auth Routes (Laravel Breeze)
require __DIR__.'/auth.php';

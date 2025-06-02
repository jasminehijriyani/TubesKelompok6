<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PublicProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (should be outside 'auth' middleware)
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login']);

Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AdminController::class, 'register']);

// Admin Routes (Grouped) - Only accessible by authenticated users (will add admin check later)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::resource('/products', ProductController::class);

    // Order Management Route
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

});

// Public Routes
Route::get('/products', [PublicProductController::class, 'index'])->name('public.products.index');
Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('public.products.show');

// Cart Routes
Route::post('/cart/add', [PublicProductController::class, 'addToCart'])->name('public.cart.add');

// Route for the Cart Page
Route::get('/cart', [PublicProductController::class, 'showCart'])->name('public.cart.index');

// Cart Update and Remove Routes (Add this section)
Route::patch('/cart/update/{id}', [PublicProductController::class, 'updateCart'])->name('public.cart.update'); // Route to update item quantity in cart
Route::delete('/cart/remove/{id}', [PublicProductController::class, 'removeFromCart'])->name('public.cart.remove'); // Route to remove item from cart

// Checkout Route
Route::post('/checkout', [CheckoutController::class, 'process'])->name('public.checkout.process');
Route::post('/checkout/buy-now', [CheckoutController::class, 'buyNow'])->name('public.checkout.buy-now'); // Route for instant purchase

// Buy Now Confirmation and Finalization
Route::get('/checkout/buy-now/confirm', [CheckoutController::class, 'showBuyNowConfirmation'])->name('public.checkout.buy-now.confirm');
Route::post('/checkout/buy-now/finalize', [CheckoutController::class, 'finalizeBuyNow'])->name('public.checkout.buy-now.finalize');

// Buy Now (Redirect to Confirmation)
Route::post('/checkout/buy-now', [CheckoutController::class, 'buyNow'])->name('public.checkout.buy-now'); // This route now redirects to confirmation

// Public Routes Group (Authenticated - for logged-in customers)
Route::middleware(['auth'])->group(function () {
    // Customer Order History Route
    Route::get('/my-orders', [CustomerOrderController::class, 'showMyOrders'])->name('public.orders.history');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('public.orders.show');

    // Customer Profile Routes
    Route::get('/profile', [CustomerOrderController::class, 'showProfile'])->name('public.profile');
    Route::post('/logout', [AdminController::class, 'logout'])->name('public.logout');
});

// General Authentication Routes (Used for customer login/registration now)
// Using Laravel Fortify or Breeze authentication views/logic is recommended for full features
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware('guest')
            ->name('login'); // This is the public login route

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth')
            ->name('logout'); // This is the public logout route

Route::get('/register', [RegisteredUserController::class, 'create'])
            ->middleware('guest')
            ->name('register'); // This is the public register route

Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware('guest');

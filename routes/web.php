<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PublicProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// AUTHENTICATION ROUTES (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Logout route (authenticated users)
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->middleware('auth')->name('logout');

// ADMIN AUTHENTICATION ROUTES
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'register']);

// ADMIN ROUTES with middleware protection
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::resource('/products', ProductController::class);

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// PUBLIC PRODUCT ROUTES
Route::get('/products', [PublicProductController::class, 'index'])->name('public.products.index');
Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('public.products.show');

// Cart routes
Route::post('/cart/add', [PublicProductController::class, 'addToCart'])->name('public.cart.add');
Route::get('/cart', [PublicProductController::class, 'showCart'])->name('public.cart.index');
Route::patch('/cart/update/{id}', [PublicProductController::class, 'updateCart'])->name('public.cart.update');
Route::delete('/cart/remove/{id}', [PublicProductController::class, 'removeFromCart'])->name('public.cart.remove');

// Checkout routes
Route::post('/checkout', [CheckoutController::class, 'process'])->name('public.checkout.process');
Route::post('/checkout/buy-now', [CheckoutController::class, 'buyNow'])->name('public.checkout.buy-now');
Route::get('/checkout/buy-now/confirm', [CheckoutController::class, 'showBuyNowConfirmation'])->name('public.checkout.buy-now.confirm');
Route::post('/checkout/buy-now/finalize', [CheckoutController::class, 'finalizeBuyNow'])->name('public.checkout.buy-now.finalize');

// CUSTOMER AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [CustomerOrderController::class, 'showMyOrders'])->name('public.orders.history');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('public.orders.show');

    Route::get('/profile', [CustomerOrderController::class, 'showProfile'])->name('public.profile');
});

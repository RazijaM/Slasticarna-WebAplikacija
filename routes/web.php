<?php

use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StatsController as AdminStatsController;
use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\RestaurantLocation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Internal/external API endpoints
Route::prefix('api')->group(function () {
    Route::get('/location', function () {
        $location = RestaurantLocation::first();

        if (! $location) {
            return response()->json(null, 404);
        }

        return response()->json([
            'name' => $location->name,
            'address' => $location->address,
            'lat' => (float) $location->lat,
            'lng' => (float) $location->lng,
            'phone' => $location->phone,
            'delivery_radius_km' => $location->delivery_radius_km !== null ? (float) $location->delivery_radius_km : null,
        ]);
    });

    Route::get('/weather', WeatherController::class);
});

// Public page with map
Route::view('/location', 'location.index')->name('location.index');

Route::middleware('auth')->group(function () {
    // Customer shop
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/item/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/item/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Customer orders
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Admin
    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('products', AdminProductController::class)->except(['show']);

            Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
            Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
            Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

            Route::get('stats', [AdminStatsController::class, 'index'])->name('stats.index');

            Route::get('location', [AdminLocationController::class, 'edit'])->name('location.edit');
            Route::put('location', [AdminLocationController::class, 'update'])->name('location.update');
        });
});

require __DIR__.'/auth.php';

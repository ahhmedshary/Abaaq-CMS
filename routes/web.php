<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// ───────────── Storefront ─────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

// ───────────── Admin ─────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show']);

        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');

        Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

        // Page Builder
        Route::get('page-builder', [\App\Http\Controllers\Admin\PageBuilderController::class, 'index'])->name('page-builder.index');
        Route::get('page-builder/{section}/edit', [\App\Http\Controllers\Admin\PageBuilderController::class, 'edit'])->name('page-builder.edit');
        Route::put('page-builder/{section}', [\App\Http\Controllers\Admin\PageBuilderController::class, 'update'])->name('page-builder.update');
        Route::patch('page-builder/{section}/toggle', [\App\Http\Controllers\Admin\PageBuilderController::class, 'toggle'])->name('page-builder.toggle');
        Route::post('page-builder/reorder', [\App\Http\Controllers\Admin\PageBuilderController::class, 'reorder'])->name('page-builder.reorder');
        Route::post('upload-image', [\App\Http\Controllers\Admin\PageBuilderController::class, 'uploadImage'])->name('upload-image');
    });
});

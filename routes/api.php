<?php

use App\Http\Controllers\Api\StoreController;
use Illuminate\Support\Facades\Route;

// Public read endpoints — consumed by the Next.js storefront
Route::get('/store/home', [StoreController::class, 'home']);
Route::get('/store/products', [StoreController::class, 'products']);
Route::get('/store/products/{slug}', [StoreController::class, 'product']);

// Cart & checkout — stateless (Next.js manages cart in localStorage)
Route::post('/store/checkout', [StoreController::class, 'checkout']);
Route::get('/store/order/{orderNumber}', [StoreController::class, 'order']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/fetch-products', [ProductController::class, 'fetchProducts']);
Route::get('/products', [ProductController::class, 'getProducts']);
Route::view('/', 'products');

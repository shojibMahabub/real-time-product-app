<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::view('/', 'products');
Route::get('/fetch-products', [ProductController::class, 'fetchProducts']);
Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/update-product/{id}', [ProductController::class, 'updateProduct']);

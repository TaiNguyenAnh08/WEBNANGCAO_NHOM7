<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

// Routes cho Categories (CRUD)
Route::resource('categories', CategoryController::class);

// Routes cho Products (CRUD)
Route::resource('products', ProductController::class);

// Routes cho Sizes (CRUD)
Route::resource('sizes', SizeController::class);

// Routes cho Orders (CRUD + Xem đơn)
Route::resource('orders', OrderController::class);


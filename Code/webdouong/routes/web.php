<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    $categories = \App\Models\Category::all();
    $products = \App\Models\Product::all();
    return view('home', compact('categories', 'products'));
})->name('home');

// Admin routes - require authentication and admin role
Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('sizes', SizeController::class);
});

// Protected routes - require authentication
Route::middleware('auth')->group(function () {
    // Orders - accessible by all authenticated users
    Route::resource('orders', OrderController::class);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function (Illuminate\Http\Request $request) {
    $categories = \App\Models\Category::all();
    $query = \App\Models\Product::where('is_active', true);
    
    // Search by name
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('name', 'LIKE', "%{$search}%");
    }
    
    // Filter by category
    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }
    
    $products = $query->get();
    
    return view('home', compact('categories', 'products'));
})->name('home');

// Admin routes - require authentication and admin role
Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/add-product', [CategoryController::class, 'addProduct'])->name('categories.addProduct');
    Route::resource('products', ProductController::class);
    Route::resource('sizes', SizeController::class);
});

// Protected routes - require authentication
Route::middleware('auth')->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/confirm/{order}', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    
    // Orders - accessible by all authenticated users
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve')->middleware(\App\Http\Middleware\IsAdmin::class);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// API route for product search suggestions
Route::get('/api/products/search', function (Illuminate\Http\Request $request) {
    $search = $request->query('q', '');
    if (strlen($search) < 2) {
        return response()->json([]);
    }
    
    $products = \App\Models\Product::where('is_active', true)
        ->where('name', 'LIKE', "%{$search}%")
        ->select('id', 'name')
        ->limit(8)
        ->get();
    
    return response()->json($products);
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

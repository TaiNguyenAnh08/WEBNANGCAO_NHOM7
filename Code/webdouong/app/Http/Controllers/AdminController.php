<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $categories_count = Category::count();
        $products_count = Product::count();
        $sizes_count = Size::count();
        $orders_count = Order::count();

        return view('admin.dashboard', compact(
            'categories_count',
            'products_count',
            'sizes_count',
            'orders_count'
        ));
    }
}

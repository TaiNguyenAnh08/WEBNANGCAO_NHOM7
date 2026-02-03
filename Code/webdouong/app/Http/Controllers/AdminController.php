<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        
        // Doanh thu thống kê
        // Tổng doanh thu (từ các đơn completed)
        $total_revenue = Order::where('status', 'completed')->sum('total_price');
        
        // Doanh thu hôm nay
        $today_revenue = Order::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');
        
        // Doanh thu tuần này
        $week_revenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total_price');
        
        // Doanh thu tháng này
        $month_revenue = Order::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');
        
        // Số đơn hàng theo trạng thái
        $orders_pending = Order::where('status', 'pending')->count();
        $orders_completed = Order::where('status', 'completed')->count();
        $orders_cancelled = Order::where('status', 'cancelled')->count();

        return view('admin.dashboard', compact(
            'categories_count',
            'products_count',
            'sizes_count',
            'orders_count',
            'total_revenue',
            'today_revenue',
            'week_revenue',
            'month_revenue',
            'orders_pending',
            'orders_completed',
            'orders_cancelled'
        ));
    }
}

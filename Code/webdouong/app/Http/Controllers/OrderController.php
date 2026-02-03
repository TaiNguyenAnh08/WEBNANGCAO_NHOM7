<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng
     * GET /orders
     */
    public function index()
    {
        // Admin xem tất cả, User xem chỉ đơn của mình
        // Sắp xếp mới nhất lên trên
        $orders = auth()->user()->isAdmin() 
            ? Order::latest()->paginate(10)
            : auth()->user()->orders()->latest()->paginate(10);
        
        return view('orders.index', ['orders' => $orders]);
    }

    
    /**
     * Hiển thị chi tiết đơn hàng
     * GET /orders/{id}
     */
    public function show(Order $order)
    {
        // Kiểm tra quyền: chỉ user của đơn hoặc admin mới xem được
        if (auth()->user()->id !== $order->user_id && !auth()->user()->isAdmin()) {
            return redirect('/orders')->withErrors(['error' => 'Không có quyền truy cập']);
        }

        $order->load('user', 'items.product', 'items.size', 'payment');
        return view('orders.show', ['order' => $order]);
    }

    /**
     * Cập nhật trạng thái đơn hàng (chỉ Admin)
     * PUT /orders/{id}
     */
    public function update(Request $request, Order $order)
    {
        // Chỉ admin được cập nhật
        if (!auth()->user()->isAdmin()) {
            return back()->withErrors(['error' => 'Không có quyền cập nhật']);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order)->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Hủy đơn hàng (User hoặc Admin)
     * DELETE /orders/{id}
     */
    public function destroy(Order $order)
    {
        // Kiểm tra quyền
        if (auth()->user()->id !== $order->user_id && !auth()->user()->isAdmin()) {
            return back()->withErrors(['error' => 'Không có quyền xóa']);
        }

        // Chỉ hủy đơn chưa hoàn thành
        if ($order->status !== 'pending') {
            return back()->withErrors(['error' => 'Chỉ có thể hủy đơn đang chờ xử lý']);
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index')->with('success', 'Hủy đơn hàng thành công!');
    }

    /**
     * Duyệt/Xác nhận đơn hàng (Admin only)
     * POST /orders/{id}/approve
     */
    public function approve(Order $order)
    {
        // Chỉ admin mới có quyền duyệt
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Chỉ duyệt đơn đang pending
        if ($order->status !== 'pending') {
            return back()->withErrors(['error' => 'Chỉ có thể duyệt đơn đang chờ xử lý']);
        }

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Duyệt đơn hàng thành công!');
    }
}

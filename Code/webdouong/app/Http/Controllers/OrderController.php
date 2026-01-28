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
        $orders = auth()->user()->isAdmin() 
            ? Order::paginate(10)
            : auth()->user()->orders()->paginate(10);
        
        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * Hiển thị form tạo đơn hàng mới
     * GET /orders/create
     */
    public function create()
    {
        $products = Product::where('is_active', true)->get();
        $sizes = Size::all();
        return view('orders.create', ['products' => $products, 'sizes' => $sizes]);
    }

    /**
     * Lưu đơn hàng mới vào database
     * POST /orders
     */
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validated = $request->validate([
            'customer_notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.size_id' => 'required|exists:sizes,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            // Tạo order number duy nhất
            $orderNumber = 'ORD' . time();

            // Tính tổng giá
            $totalPrice = 0;
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $totalPrice += $product->price * $item['quantity'];
            }

            // Tạo đơn hàng
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'customer_notes' => $validated['customer_notes'] ?? null,
            ]);

            // Thêm chi tiết đơn hàng
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];

                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'size_id' => $item['size_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);
            }

            return redirect()->route('orders.show', $order)->with('success', 'Tạo đơn hàng thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang checkout với giỏ hàng
     * GET /checkout
     */
    public function index(Request $request)
    {
        // Lấy cart từ request (nếu có) hoặc user cần có cart ở localStorage
        $cartJson = $request->input('cart_data', '[]');
        
        // Nếu cart_data trống, user sẽ truyền từ JavaScript
        // Vì vậy ta hiển thị view checkout dengan logic JavaScript để lấy cart từ localStorage
        
        return view('checkout.index', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Xử lý đặt hàng và thanh toán
     * POST /checkout
     */
    public function store(Request $request)
    {
        // Kiểm tra user đã login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục!');
        }

        // Validate dữ liệu
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer',
            'cart_data' => 'required|json',
        ]);

        try {
            $cartJson = $validated['cart_data'];
            $cart = json_decode($cartJson, true);
            
            // Log để debug
            \Log::info('Checkout store called', [
                'user_id' => auth()->id(),
                'payment_method' => $validated['payment_method'],
                'cart_count' => count($cart),
                'cart_data' => $cart,
            ]);

            if (empty($cart)) {
                return back()->with('error', 'Giỏ hàng trống!');
            }

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'status' => 'pending', // Order bắt đầu ở trạng thái pending
                'total_price' => 0,
            ]);

            $totalAmount = 0;

            // Tạo order items
            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    continue;
                }

                $itemTotal = $product->price * $item['quantity'];
                $totalAmount += $itemTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'size_id' => $item['size_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $itemTotal,
                ]);

                // Giảm số lượng tồn kho
                $product->stock -= $item['quantity'];
                $product->save();
            }

            // Cập nhật tổng tiền đơn hàng
            $order->update([
                'total_price' => $totalAmount,
            ]);

            // Tạo payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'transaction_code' => 'TXN-' . date('Ymd') . '-' . strtoupper(uniqid()),
            ]);

            // Giả lập thanh toán thành công (trong thực tế có thể gọi API cổng thanh toán)
            // Ở đây chúng ta coi như thanh toán luôn thành công
            $payment->update(['status' => 'completed']);
            // Lưu ý: order status vẫn là pending, chờ admin duyệt

            // Lưu thông tin giao hàng (sử dụng thông tin user)
            $order->update([
                'shipping_name' => auth()->user()->name,
                'shipping_email' => auth()->user()->email,
                'shipping_phone' => 'N/A',
                'shipping_address' => 'Nhận tại cửa hàng',
                'shipping_city' => 'N/A',
                'shipping_district' => 'N/A',
            ]);

            return redirect()->route('checkout.confirm', ['order' => $order->id])
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Xác nhận đơn hàng sau thanh toán
     * GET /checkout/confirm/{order}
     */
    public function confirm(Order $order)
    {
        // Kiểm tra user có quyền xem đơn hàng này không
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $order->load('items', 'items.product', 'payment');

        return view('checkout.confirm', [
            'order' => $order,
        ]);
    }
}

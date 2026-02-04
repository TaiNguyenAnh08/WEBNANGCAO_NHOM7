@extends('layouts.shop')
@section('title', 'Xác Nhận Đơn Hàng')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Success Message -->
        <div class="text-center mb-12">
            <div class="text-8xl mb-6 animate-bounce">
                @if($order->status === 'pending')
                    ⏳
                @else
                    ✅
                @endif
            </div>
            <h1 class="text-4xl font-display font-bold text-gray-800 mb-4">
                @if($order->status === 'pending')
                    Thanh Toán Thành Công!
                @else
                    Đơn Hàng Được Duyệt!
                @endif
            </h1>
            <p class="text-xl text-gray-600">
                @if($order->status === 'pending')
                    Đơn hàng của bạn đang chờ duyệt từ cửa hàng
                @else
                    Cảm ơn bạn đã mua hàng tại ZINGTEA
                @endif
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Order Info -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">📋 Thông Tin Đơn Hàng</h2>
                    
                    <div class="grid grid-cols-2 gap-6 pb-6 border-b border-gray-200 mb-6">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">Mã Đơn Hàng</p>
                            <p class="text-xl font-bold text-gray-800">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">Ngày Đặt Hàng</p>
                            <p class="text-xl font-bold text-gray-800">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">Trạng Thái</p>
                            <p class="text-lg font-bold">
                                @if($order->status == 'completed')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">✅ Đã Thanh Toán</span>
                                @elseif($order->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">⏳ Đang Xử Lý</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">❌ {{ $order->status }}</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">Tổng Tiền</p>
                            <p class="text-2xl font-bold gradient-text">{{ number_format($order->total_price, 0, ',', '.') }}đ</p>
                        </div>
                    </div>

                    @if($order->payment)
                    <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4">
                        <p class="text-green-700 font-semibold mb-2">💳 Phương Thức Thanh Toán</p>
                        <div class="space-y-2 text-sm text-green-700">
                            <p>Phương thức: <span class="font-semibold">
                                @switch($order->payment->payment_method)
                                    @case('cash')
                                        💵 Tiền Mặt
                                        @break
                                    @case('bank_transfer')
                                        🏦 Chuyển Khoản
                                        @break
                                    @default
                                        {{ $order->payment->payment_method }}
                                @endswitch
                            </span></p>
                            <p>Số Giao Dịch: <span class="font-semibold">{{ $order->payment->transaction_code }}</span></p>
                            <p>Trạng Thái: 
                                @if($order->payment->status == 'completed')
                                    <span class="font-semibold text-green-700">✅ Đã Thanh Toán</span>
                                @else
                                    <span class="font-semibold text-yellow-700">⏳ Đang Xử Lý</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">🏪 Thông Tin Nhận Hàng</h2>
                    
                    <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4">
                        <p class="text-blue-700 font-semibold mb-3">ℹ️ Hướng Dẫn Nhận Hàng</p>
                        <ul class="space-y-2 text-blue-700 text-sm">
                            <li>✓ Vui lòng đến cửa hàng để nhận hàng</li>
                            <li>✓ Mang theo mã đơn hàng: <span class="font-bold">{{ $order->order_number }}</span></li>
                            <li>✓ Thanh toán tại quầy khi nhận hàng</li>
                            <li>✓ Cửa hàng mở từ 8:00 - 22:00 hàng ngày</li>
                        </ul>
                    </div>

                    <div class="mt-6 pt-6 border-t space-y-3">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">Địa Chỉ Cửa Hàng</p>
                            <p class="text-gray-800">Đại học Phenikaa, Hà Nội</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">Hotline</p>
                            <p class="text-gray-800">0866698296</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">🛍️ Sản Phẩm Đặt Hàng</h2>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-3xl">🍵</span>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-600">
                                    Kích thước: <span class="font-semibold">{{ $item->size->name ?? 'N/A' }}</span>
                                </p>
                                <p class="text-sm text-gray-600">
                                    Số lượng: <span class="font-semibold">{{ $item->quantity }} cái</span>
                                </p>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-lg font-bold text-green-600">{{ number_format($item->subtotal, 0, ',', '.') }}đ</p>
                                <p class="text-sm text-gray-600">{{ number_format($item->unit_price, 0, ',', '.') }}đ/cái</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-32">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">💰 Tóm Tắt</h2>
                    
                    <div class="space-y-3 pb-4 border-b border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-gray-700">Trạng Thái:</span>
                            <span class="font-semibold">
                                @if($order->status === 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">⏳ Chờ Duyệt</span>
                                @elseif($order->status === 'completed')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">✅ Đã Duyệt</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">❌ Hủy</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700">Số Sản Phẩm:</span>
                            <span class="font-semibold">{{ $order->items->sum('quantity') }} cái</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700">Tổng Tiền:</span>
                            <span class="font-semibold">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 space-y-3">
                        <a href="{{ route('orders.show', $order) }}" class="w-full text-center block px-4 py-3 btn-primary text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                            📦 Xem Chi Tiết Đơn Hàng
                        </a>
                        <a href="{{ route('home') }}" class="w-full text-center block px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                            🏠 Tiếp Tục Mua Sắm
                        </a>
                    </div>
                </div>

                <!-- Support Card -->
                <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-200">
                    <p class="text-blue-700 font-semibold mb-3">❓ Cần Hỗ Trợ?</p>
                    <p class="text-blue-700 text-sm mb-3">Liên hệ chúng tôi nếu có bất kỳ câu hỏi.</p>
                    <p class="text-blue-900 font-semibold text-sm mb-1">📞 0866898296</p>
                    <p class="text-blue-900 font-semibold text-sm">📧 taidz852005@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    .animate-bounce {
        animation: bounce 1s ease-in-out infinite;
    }
</style>

<script>
    // Clear cart after successful checkout
    document.addEventListener('DOMContentLoaded', function() {
        localStorage.removeItem('cart');
        console.log('Cart cleared after successful checkout');
    });
</script>
@endsection

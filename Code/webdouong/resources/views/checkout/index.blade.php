@extends('layouts.shop')
@section('title', 'Thanh Toán')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-display font-bold text-gray-800 mb-2">💳 Thanh Toán</h1>
            <p class="text-gray-600">Hoàn tất đơn hàng của bạn</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border-2 border-red-300 rounded-lg p-4 mb-8">
                @foreach($errors->all() as $error)
                    <p class="text-red-600 text-sm">❌ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Check cart is empty -->
        <div id="empty-cart-message" class="hidden bg-yellow-50 border-2 border-yellow-300 rounded-lg p-6 mb-8 text-center">
            <p class="text-yellow-700 font-semibold mb-4">⚠️ Giỏ hàng trống!</p>
            <a href="{{ route('home') }}" class="inline-block px-6 py-2 btn-primary text-white rounded-lg font-semibold">
                ← Quay lại mua hàng
            </a>
        </div>

        <form method="POST" action="{{ route('checkout.store') }}" class="space-y-8" id="checkout-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left side - Cart Items -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Cart Items Summary -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">🛒 Sản Phẩm Đã Chọn</h2>
                        
                        <div class="space-y-4 mb-6" id="cart-items-display">
                            <!-- Cart items will be inserted here by JavaScript -->
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">🏪 Phương Thức Thanh Toán Tại Chỗ</h2>
                        
                        <div class="space-y-3 mb-6">
                            <label class="flex items-center gap-3 p-4 border-2 border-gray-300 rounded-lg hover:border-green-600 hover:bg-green-50 cursor-pointer transition-colors">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="cash"
                                    class="w-5 h-5"
                                    checked
                                    required
                                >
                                <span class="flex-1">
                                    <p class="font-semibold text-gray-800">💵 Tiền Mặt</p>
                                    <p class="text-xs text-gray-600">Thanh toán bằng tiền mặt tại quầy</p>
                                </span>
                            </label>

                            <label class="flex items-center gap-3 p-4 border-2 border-gray-300 rounded-lg hover:border-green-600 hover:bg-green-50 cursor-pointer transition-colors">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="bank_transfer"
                                    class="w-5 h-5"
                                    required
                                >
                                <span class="flex-1">
                                    <p class="font-semibold text-gray-800">🏦 Chuyển Khoản</p>
                                    <p class="text-xs text-gray-600">Chuyển khoản ngân hàng tại quầy</p>
                                </span>
                            </label>
                        </div>

                        <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-6">
                            <p class="text-blue-700 font-semibold mb-3">ℹ️ Hướng Dẫn</p>
                            <ul class="space-y-2 text-blue-700 text-sm">
                                <li>✓ Đặt hàng thành công</li>
                                <li>✓ Nhân viên sẽ chuẩn bị đơn hàng</li>
                                <li>✓ Bạn đến cửa hàng để nhận hàng</li>
                                <li>✓ Thanh toán tại quầy (tiền mặt hoặc chuyển khoản)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right side - Order Summary -->
                <div class="space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-32">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">💰 Tóm Tắt Đơn Hàng</h2>
                        
                        <div class="space-y-3 pb-4 border-b border-gray-200">
                            <div class="flex justify-between">
                                <span class="text-gray-700">Tổng sản phẩm:</span>
                                <span class="font-semibold text-gray-800" id="total-quantity">0 cái</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Tổng tiền:</span>
                                <span class="text-2xl font-bold gradient-text" id="total-price">0đ</span>
                            </div>
                        </div>

                        <!-- Hidden cart data -->
                        <input type="hidden" name="cart_data" id="cart_data" value="[]">

                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            class="w-full mt-8 btn-primary text-white py-4 rounded-lg font-bold text-lg hover:shadow-lg transition-all"
                        >
                            💳 Thanh Toán
                        </button>

                        <a 
                            href="{{ route('home') }}" 
                            class="block w-full mt-3 text-center px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors"
                        >
                            ← Quay Lại Mua Hàng
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Load cart từ localStorage và hiển thị
document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const cartItemsDisplay = document.getElementById('cart-items-display');
    const cartDataInput = document.getElementById('cart_data');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    
    if (cart.length === 0) {
        emptyCartMessage.classList.remove('hidden');
        document.getElementById('checkout-form').style.display = 'none';
        return;
    }

    // Hiển thị cart items với nút chỉnh sửa
    renderCart();

    function renderCart() {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        let html = '';
        let totalPrice = 0;
        let totalQuantity = 0;

        if (cart.length === 0) {
            cartItemsDisplay.innerHTML = '<p class="text-center text-gray-500">Giỏ hàng trống</p>';
            return;
        }

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            totalPrice += itemTotal;
            totalQuantity += item.quantity;

            html += `
                <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                    <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center flex-shrink-0">
                        <span class="text-3xl">🍵</span>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800">${item.product_name}</h3>
                        <p class="text-sm text-gray-600">
                            Kích thước: <span class="font-semibold">${item.size_name}</span>
                        </p>
                        <div class="flex items-center gap-2 mt-2">
                            <button type="button" onclick="decreaseQty(${index})" class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm font-bold">−</button>
                            <span class="px-3 py-1 bg-gray-100 rounded text-sm font-semibold">${item.quantity}</span>
                            <button type="button" onclick="increaseQty(${index})" class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm font-bold">+</button>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-lg font-bold text-green-600">${itemTotal.toLocaleString('vi-VN')}đ</p>
                        <p class="text-sm text-gray-600">${item.price.toLocaleString('vi-VN')}đ/cái</p>
                        <button type="button" onclick="removeItem(${index})" class="mt-2 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-sm font-semibold">🗑️ Xóa</button>
                    </div>
                </div>
            `;
        });

        cartItemsDisplay.innerHTML = html;
        document.getElementById('total-quantity').textContent = totalQuantity + ' cái';
        document.getElementById('total-price').textContent = totalPrice.toLocaleString('vi-VN') + 'đ';
        cartDataInput.value = JSON.stringify(cart);
    }

    // Hàm tăng số lượng
    window.increaseQty = function(index) {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        if (cart[index]) {
            cart[index].quantity += 1;
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    // Hàm giảm số lượng
    window.decreaseQty = function(index) {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        if (cart[index] && cart[index].quantity > 1) {
            cart[index].quantity -= 1;
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    // Hàm xóa sản phẩm
    window.removeItem = function(index) {
        if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }
});

// Submit form - đảm bảo cart data được gửi và disable button
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    console.log('Form submit - Cart data:', cart);
    
    if (cart.length === 0) {
        e.preventDefault();
        alert('Giỏ hàng trống! Vui lòng thêm sản phẩm vào giỏ hàng.');
        return false;
    }
    
    const cartDataInput = document.getElementById('cart_data');
    cartDataInput.value = JSON.stringify(cart);
    console.log('Cart data input set to:', cartDataInput.value);
    
    // Disable submit button để tránh double submit
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = '⏳ Đang xử lý...';
    submitButton.style.opacity = '0.6';
    submitButton.style.cursor = 'not-allowed';
    
    // Set timeout để prevent spam click
    setTimeout(() => {
        submitButton.disabled = false;
        submitButton.textContent = '💳 Thanh Toán';
        submitButton.style.opacity = '1';
        submitButton.style.cursor = 'pointer';
    }, 3000);
});
</script>
@endsection

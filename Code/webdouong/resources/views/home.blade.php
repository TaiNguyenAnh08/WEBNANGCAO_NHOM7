@extends('layouts.shop')
@section('title', 'Cửa hàng')

@section('content')
<!-- Hero Section -->
<div class="hero-gradient py-24 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="font-display text-5xl md:text-6xl font-bold mb-4 animate-fade-in">
            ☕ Khám Phá Hương Vị <span class="gradient-text">Đặc Biệt</span>
        </h1>
        <p class="text-xl text-gray-600 mb-8 animate-fade-in" style="animation-delay: 0.2s">
            Thưởng thức những đồ uống tuyệt vời được chế biến từ nguyên liệu tự nhiên
        </p>
        <button id="scroll-menu" class="btn-primary text-white px-8 py-4 rounded-full font-semibold text-lg inline-block animate-float" style="animation-delay: 0.4s">
            ⬇️ Xem Menu
        </button>
    </div>
</div>

<!-- Category Filter -->
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex flex-wrap gap-3 justify-center mb-12" id="category-filters">
        <button class="category-btn active px-6 py-2 rounded-full border-2 border-green-700 text-green-700 font-semibold transition-all" data-category="all">
            Tất cả
        </button>
        @foreach($categories as $category)
        <button class="category-btn px-6 py-2 rounded-full border-2 border-gray-300 text-gray-700 font-semibold transition-all" data-category="{{ $category->id }}">
            {{ $category->name }}
        </button>
        @endforeach
    </div>
</div>

<!-- Products Grid -->
<div class="max-w-7xl mx-auto px-4 pb-12" id="menu">
    <h2 class="font-display text-4xl font-bold mb-12 text-center gradient-text">Danh Sách Sản Phẩm</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="products-grid">
        @forelse($products as $product)
        <div class="product-card bg-white rounded-2xl shadow-lg overflow-hidden cursor-pointer hover:shadow-2xl" data-product-id="{{ $product->id }}" data-category-id="{{ $product->category_id }}">
            <!-- Product Image -->
            <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center overflow-hidden group">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                @else
                    <div class="text-6xl">🍵</div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="p-5">
                <h3 class="font-display font-bold text-lg text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $product->description }}</p>

                <!-- Price -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-2xl font-bold gradient-text">{{ number_format($product->price) }}đ</span>
                    <span class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full font-semibold">Có sẵn</span>
                </div>

                <!-- Sizes -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($product->sizes as $size)
                    <button type="button" class="size-btn text-xs px-3 py-1 rounded-full border-2 border-gray-300 text-gray-600 hover:border-green-600 hover:text-green-600 font-semibold transition-all" data-size-id="{{ $size->id }}" data-size-name="{{ $size->name }}" data-product-id="{{ $product->id }}">
                        {{ $size->name }}
                    </button>
                    @endforeach
                </div>

                <!-- Add to Cart Button -->
                <button type="button" class="add-to-cart w-full btn-primary text-white py-3 rounded-xl font-semibold transition-all" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}">
                    🛒 Thêm vào giỏ
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">Không có sản phẩm nào</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Info Section -->
<div class="bg-gray-50 py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-6xl mb-4">🌿</div>
                <h3 class="font-bold text-xl mb-2">100% Tự Nhiên</h3>
                <p class="text-gray-600">Tất cả sản phẩm được tạo ra từ những nguyên liệu tự nhiên tốt nhất</p>
            </div>
            <div class="text-center">
                <div class="text-6xl mb-4">⚡</div>
                <h3 class="font-bold text-xl mb-2">Giao Hàng Nhanh</h3>
                <p class="text-gray-600">Đơn hàng của bạn sẽ được giao trong vòng 30 phút</p>
            </div>
            <div class="text-center">
                <div class="text-6xl mb-4">🎁</div>
                <h3 class="font-bold text-xl mb-2">Ưu Đãi Lớn</h3>
                <p class="text-gray-600">Nhận giảm giá lên tới 50% cho các đơn hàng đầu tiên</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Cart functionality
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    let selectedSize = {};

    // Size selection
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const productId = this.dataset.productId;
            const sizeId = this.dataset.sizeId;
            const sizeName = this.dataset.sizeName;

            // Clear previous selection for this product
            document.querySelectorAll(`.size-btn[data-product-id="${productId}"]`).forEach(b => {
                b.classList.remove('border-green-600', 'text-green-600', 'bg-green-50');
                b.classList.add('border-gray-300', 'text-gray-600');
            });

            // Select this size
            this.classList.remove('border-gray-300', 'text-gray-600');
            this.classList.add('border-green-600', 'text-green-600', 'bg-green-50');

            selectedSize[productId] = { id: sizeId, name: sizeName };
        });
    });

    // Add to cart
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = parseInt(this.dataset.productPrice);

            if (!selectedSize[productId]) {
                alert('Vui lòng chọn kích thước');
                return;
            }

            const size = selectedSize[productId];
            const existing = cart.find(item => item.product_id == productId && item.size_id == size.id);

            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({
                    product_id: productId,
                    size_id: size.id,
                    size_name: size.name,
                    product_name: productName,
                    price: productPrice,
                    quantity: 1
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart();
            alert('Đã thêm vào giỏ hàng!');
        });
    });

    // Category filter
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.dataset.category;

            document.querySelectorAll('.category-btn').forEach(b => {
                b.classList.remove('active', 'bg-gradient-to-r', 'from-green-600', 'to-green-700', 'text-white', 'border-green-600');
                b.classList.add('border-gray-300', 'text-gray-700');
            });

            this.classList.add('active', 'bg-green-50', 'border-green-600', 'text-green-700');

            document.querySelectorAll('.product-card').forEach(card => {
                const catId = card.dataset.categoryId;
                if (categoryId === 'all' || catId == categoryId) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Cart sidebar
    const cartBtn = document.getElementById('cart-btn');
    const closCartBtn = document.getElementById('close-cart');
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartOverlay = document.getElementById('cart-overlay');

    cartBtn.addEventListener('click', () => {
        cartSidebar.classList.remove('translate-x-full');
        cartOverlay.classList.remove('hidden');
    });

    closCartBtn.addEventListener('click', () => {
        cartSidebar.classList.add('translate-x-full');
        cartOverlay.classList.add('hidden');
    });

    cartOverlay.addEventListener('click', () => {
        cartSidebar.classList.add('translate-x-full');
        cartOverlay.classList.add('hidden');
    });

    // Update cart display
    function updateCart() {
        const count = cart.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById('cart-count').textContent = count;

        const items = cart.length;
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        const cartItemsDiv = document.getElementById('cart-items');
        
        if (items === 0) {
            cartItemsDiv.innerHTML = `
                <div class="text-center py-12 text-gray-500">
                    <span class="text-6xl mb-4 block">🛒</span>
                    <p>Giỏ hàng trống</p>
                </div>
            `;
        } else {
            let html = '';
            cart.forEach((item, index) => {
                html += `
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-semibold">${item.product_name}</h4>
                                <p class="text-sm text-gray-600">${item.size_name}</p>
                            </div>
                            <button class="text-gray-400 hover:text-red-500" onclick="removeFromCart(${index})">✕</button>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">${item.price.toLocaleString('vi-VN')}đ</span>
                            <div class="flex gap-2">
                                <button onclick="decreaseQuantity(${index})" class="px-2 py-1 bg-gray-300 rounded text-sm">-</button>
                                <span class="px-2 py-1 text-sm">${item.quantity}</span>
                                <button onclick="increaseQuantity(${index})" class="px-2 py-1 bg-gray-300 rounded text-sm">+</button>
                            </div>
                        </div>
                    </div>
                `;
            });
            cartItemsDiv.innerHTML = html;
        }

        document.getElementById('cart-total').textContent = total.toLocaleString('vi-VN') + 'đ';
        document.getElementById('cart-items-json').value = JSON.stringify(cart);
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCart();
    }

    function increaseQuantity(index) {
        cart[index].quantity += 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCart();
    }

    function decreaseQuantity(index) {
        if (cart[index].quantity > 1) {
            cart[index].quantity -= 1;
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart();
        }
    }

    // Scroll to menu
    document.getElementById('scroll-menu').addEventListener('click', () => {
        document.getElementById('menu').scrollIntoView({ behavior: 'smooth' });
    });

    // Initialize cart on page load
    updateCart();
</script>
@endsection

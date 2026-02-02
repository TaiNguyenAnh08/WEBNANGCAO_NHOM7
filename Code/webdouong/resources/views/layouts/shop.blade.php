<!doctype html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trà & Cà Phê') - Beverage Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }
        .font-display { font-family: 'Playfair Display', serif; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-fade-in { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-slide-in { animation: slideIn 0.6s ease-out forwards; }
        
        .product-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .product-card:hover {
            transform: translateY(-12px) scale(1.02);
        }
        
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c23 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #fef9f3 0%, #f0e6d3 50%, #e8dcc8 100%);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4a7c23 0%, #2d5016 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a9428 0%, #3d6820 100%);
            box-shadow: 0 10px 30px rgba(74, 124, 35, 0.4);
        }
        
        .category-btn {
            transition: all 0.3s ease;
        }
        .category-btn:hover, .category-btn.active {
            background: linear-gradient(135deg, #4a7c23 0%, #2d5016 100%);
            color: white;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-body bg-white">
    <div id="app" class="h-full w-full">
        <!-- Header -->
        <header class="glass-effect fixed top-0 left-0 right-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center shadow-lg">
                        <span class="text-2xl">🍵</span>
                    </div>
                    <div>
                        <h1 class="font-display text-xl font-bold gradient-text">Trà & Cà Phê</h1>
                        <p class="text-xs text-gray-500">Hương vị tự nhiên</p>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="#menu" class="text-gray-700 hover:text-green-700 font-medium transition-colors">Menu</a>
                    <a href="#about" class="text-gray-700 hover:text-green-700 font-medium transition-colors">Về chúng tôi</a>
                    <a href="#contact" class="text-gray-700 hover:text-green-700 font-medium transition-colors">Liên hệ</a>
                </nav>

                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-600 hover:text-green-700 transition-colors" id="cart-btn">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="cart-count" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">0</span>
                    </button>

                    @if(auth()->check())
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 btn-primary text-white rounded-full font-semibold text-sm">📊 Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-full font-semibold text-sm border-2 border-green-700 text-green-700 hover:bg-green-50 transition-colors">🚪 Đăng xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 btn-primary text-white rounded-full font-semibold text-sm">🔐 Đăng nhập</a>
                    @endif

                    <button class="md:hidden p-2 text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="pt-24">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
                                <span class="text-xl">🍵</span>
                            </div>
                            <span class="font-display text-xl font-bold">Trà & Cà Phê</span>
                        </div>
                        <p class="text-gray-400 text-sm">Mang đến những trải nghiệm đồ uống tuyệt vời nhất cho bạn.</p>
                    </div>
                    <div>
                        <h5 class="font-semibold mb-4">Liên kết</h5>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="#" class="hover:text-white transition-colors">Trang chủ</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Menu</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Về chúng tôi</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Liên hệ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-semibold mb-4">Liên hệ</h5>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li>📍 123 Nguyễn Huệ, Q.1, TP.HCM</li>
                            <li>📞 1900 1234</li>
                            <li>✉️ hello@tracaphe.vn</li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-semibold mb-4">Theo dõi chúng tôi</h5>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">📘</a>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">📸</a>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">🎵</a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-sm">
                    <p>© 2024 Trà & Cà Phê. Tất cả quyền được bảo lưu.</p>
                </div>
            </div>
        </footer>

        <!-- Cart Sidebar -->
        <div id="cart-sidebar" class="fixed top-0 right-0 w-full max-w-md h-full bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300">
            <div class="h-full flex flex-col">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="font-display text-xl font-bold">Giỏ hàng</h3>
                    <button id="close-cart" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-auto p-6" id="cart-items">
                    <div class="text-center py-12 text-gray-500">
                        <span class="text-6xl mb-4 block">🛒</span>
                        <p>Giỏ hàng trống</p>
                    </div>
                </div>
                <div class="p-6 border-t bg-gray-50">
                    <div class="flex justify-between mb-4">
                        <span class="font-semibold">Tổng cộng:</span>
                        <span id="cart-total" class="font-bold text-green-700 text-xl">0đ</span>
                    </div>
                    @if(auth()->check())
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <textarea name="customer_notes" placeholder="Ghi chú đơn hàng..." rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3 text-sm"></textarea>
                            <input type="hidden" id="cart-items-json" name="items_json" value="[]">
                            <button type="submit" class="w-full btn-primary text-white py-4 rounded-full font-semibold text-lg">Thanh toán 💳</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center btn-primary text-white py-4 rounded-full font-semibold text-lg">Đăng nhập để thanh toán</a>
                    @endif
                </div>
            </div>
        </div>
        <div id="cart-overlay" class="fixed inset-0 bg-black/50 z-40 hidden"></div>
    </div>

    @vite(['resources/js/app.js'])
</body>
</html>

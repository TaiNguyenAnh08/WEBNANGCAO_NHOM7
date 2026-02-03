<!doctype html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ZINGTEA') - Beverage Shop</title>
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
                <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center shadow-lg">
                        <span class="text-2xl">🍵</span>
                    </div>
                    <div>
                        <h1 class="font-display text-xl font-bold gradient-text">ZINGTEA</h1>
                        <p class="text-xs text-gray-500">Hương vị tự nhiên</p>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="#menu" class="text-gray-700 hover:text-green-700 font-medium transition-colors">Menu</a>
                    <a href="#about" class="text-gray-700 hover:text-green-700 font-medium transition-colors">Về chúng tôi</a>
                    <a href="#contact" class="text-gray-700 hover:text-green-700 font-medium transition-colors">Liên hệ</a>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ auth()->check() ? route('checkout.index') : route('login') }}" class="relative p-2 text-gray-600 hover:text-green-700 transition-colors group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="cart-count" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">0</span>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ auth()->check() ? 'Đi tới checkout' : 'Đăng nhập để thanh toán' }}
                        </span>
                    </a>

                    @if(auth()->check())
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-4 py-2 rounded-full border-2 border-green-700 text-green-700 hover:bg-green-50 transition-colors font-semibold text-sm">
                                👤 {{ auth()->user()->name }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </button>
                            
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl hidden group-hover:block z-50 border-2 border-gray-200">
                                <div class="p-3 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors text-sm">
                                    ⚙️ Cài đặt tài khoản
                                </a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors text-sm">
                                    📦 Đơn hàng của tôi
                                </a>
                                
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors text-sm border-t border-gray-200">
                                        📊 Quản lý Admin
                                    </a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors text-sm border-t border-gray-200 font-semibold">
                                        🚪 Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
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
                            <span class="font-display text-xl font-bold">ZINGTEA</span>
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
                            <li>📍 Đại học Phenikaa</li>
                            <li>📞 0866698296</li>
                            <li>✉️ taidz852005@gmail.com</li>
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
                    <p>© ZINGTEA - Đem vị trà đến với người Việt</p>
                </div>
            </div>
        </footer>
        <!-- Cart Sidebar dùng nếu cần hiển thị cart preview
        (hiện tại redirect trực tiếp đến checkout page)
        -->

    </div>

    @vite(['resources/js/app.js'])
    
    <script>
        // Dropdown menu - giữ mở lâu hơn
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuButton = document.querySelector('.relative.group button');
            const userDropdown = document.querySelector('.relative.group > div');
            
            if (userMenuButton && userDropdown) {
                let closeTimeout;
                
                // Khi hover button hoặc dropdown
                const container = userMenuButton.parentElement;
                container.addEventListener('mouseenter', function() {
                    clearTimeout(closeTimeout);
                    userDropdown.classList.remove('hidden');
                    userDropdown.classList.add('block');
                });
                
                // Khi rời chuột: đợi 2 giây rồi tắt
                container.addEventListener('mouseleave', function() {
                    closeTimeout = setTimeout(function() {
                        userDropdown.classList.add('hidden');
                        userDropdown.classList.remove('block');
                    }, 2000);
                });
            }
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ZINGTEA') - ZINGTEA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-slide-in { animation: slideIn 0.3s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }

        .gradient-text {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c23 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4a7c23 0%, #2d5016 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a9428 0%, #3d6820 100%);
            box-shadow: 0 10px 30px rgba(74, 124, 35, 0.4);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            transition: all 0.3s ease;
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }

        table {
            width: 100%;
        }

        th {
            background: linear-gradient(135deg, #f0f9ff 0%, #f3f4f6 100%);
            font-weight: 600;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }

        .badge-active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-100">
    <div class="h-full w-full flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-md px-8 py-4 flex items-center justify-between sticky top-0 z-50">
            <a href="{{ route('home') }}" class="flex items-center gap-4 hover:opacity-80 transition-opacity">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center shadow-lg">
                    <span class="text-2xl">🍵</span>
                </div>
                <div>
                    <h1 class="font-bold text-lg gradient-text">ZINGTEA</h1>
                    <p class="text-xs text-gray-500">Quản lý cửa hàng</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8">
                @if(auth()->check())
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-green-700 font-medium transition-colors">📊 Dashboard</a>
                        <a href="{{ route('admin.categories.index') }}" class="text-gray-700 hover:text-green-700 font-medium transition-colors">📁 Danh mục</a>
                        <a href="{{ route('admin.products.index') }}" class="text-gray-700 hover:text-green-700 font-medium transition-colors">📦 Sản phẩm</a>
                        <a href="{{ route('admin.sizes.index') }}" class="text-gray-700 hover:text-green-700 font-medium transition-colors">📏 Kích thước</a>
                        <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-green-700 font-medium transition-colors">🛒 Đơn hàng</a>
                    @else
                        <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-green-700 font-medium transition-colors">📋 Đơn hàng của tôi</a>
                    @endif
                @endif
            </nav>

            <div class="flex items-center gap-4">
                @if(auth()->check())
                    <div class="text-sm text-gray-700">
                        <span class="font-semibold">{{ auth()->user()->name }}</span>
                        @if(auth()->user()->isAdmin())
                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Admin</span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-primary text-white px-4 py-2 rounded-lg font-semibold text-sm">
                            🚪 Đăng xuất
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-semibold text-sm">
                        🔐 Đăng nhập
                    </a>
                @endif
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-8 pt-4">
            @if ($message = Session::get('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg animate-fade-in mb-4">
                    <strong>✓ Thành công!</strong> {{ $message }}
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg animate-fade-in mb-4">
                    <strong>✗ Lỗi!</strong> {{ $message }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg animate-fade-in mb-4">
                    <strong>✗ Lỗi xác thực!</strong>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8 px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xl">🍵</span>
                            <span class="font-bold text-lg">ZINGTEA</span>
                        </div>
                        <p class="text-gray-400 text-sm">Mang đến những trải nghiệm đồ uống tuyệt vời nhất cho bạn.</p>
                    </div>
                    <div>
                        <h5 class="font-semibold mb-3">Liên kết</h5>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="#" class="hover:text-white transition-colors">Trang chủ</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Menu</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Về chúng tôi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-semibold mb-3">Liên hệ</h5>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li>📍 Đại học Phenikaa</li>
                            <li>📞 0866698296</li>
                            <li>✉️ taidz852005@gmail.com</li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-semibold mb-3">Theo dõi</h5>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">📘</a>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">📸</a>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">🎵</a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-6 text-center text-gray-500 text-sm">
                    <p>© ZINGTEA - Đem vị trà đến với người Việt</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

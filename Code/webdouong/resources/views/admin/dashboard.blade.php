@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">📊 Admin Dashboard</h1>
        <p class="text-gray-600">Chào mừng, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Categories -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Danh Mục</p>
                    <p class="text-4xl font-bold gradient-text">{{ $categories_count }}</p>
                </div>
                <div class="text-5xl opacity-30">📁</div>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="text-sm text-green-700 font-semibold hover:text-green-800 mt-4 inline-block">
                Quản lý →
            </a>
        </div>

        <!-- Products -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Sản Phẩm</p>
                    <p class="text-4xl font-bold gradient-text">{{ $products_count }}</p>
                </div>
                <div class="text-5xl opacity-30">📦</div>
            </div>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-green-700 font-semibold hover:text-green-800 mt-4 inline-block">
                Quản lý →
            </a>
        </div>

        <!-- Sizes -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Kích Thước</p>
                    <p class="text-4xl font-bold gradient-text">{{ $sizes_count }}</p>
                </div>
                <div class="text-5xl opacity-30">📏</div>
            </div>
            <a href="{{ route('admin.sizes.index') }}" class="text-sm text-green-700 font-semibold hover:text-green-800 mt-4 inline-block">
                Quản lý →
            </a>
        </div>

        <!-- Orders -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Đơn Hàng</p>
                    <p class="text-4xl font-bold gradient-text">{{ $orders_count }}</p>
                </div>
                <div class="text-5xl opacity-30">🛒</div>
            </div>
            <a href="{{ route('orders.index') }}" class="text-sm text-green-700 font-semibold hover:text-green-800 mt-4 inline-block">
                Xem →
            </a>
        </div>
    </div>

    <!-- Revenue Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">💰 Thống Kê Doanh Thu</h2>
        
        <!-- Revenue Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg p-6 border-2 border-green-300 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-700 text-sm font-semibold">Tổng Doanh Thu</p>
                        <p class="text-3xl font-bold text-green-700">{{ number_format($total_revenue, 0, ',', '.') }}đ</p>
                    </div>
                    <div class="text-4xl opacity-40">💵</div>
                </div>
            </div>

            <!-- Today Revenue -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-lg p-6 border-2 border-blue-300 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-700 text-sm font-semibold">Hôm Nay</p>
                        <p class="text-3xl font-bold text-blue-700">{{ number_format($today_revenue, 0, ',', '.') }}đ</p>
                    </div>
                    <div class="text-4xl opacity-40">📅</div>
                </div>
            </div>

            <!-- Week Revenue -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-lg p-6 border-2 border-purple-300 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-700 text-sm font-semibold">Tuần Này</p>
                        <p class="text-3xl font-bold text-purple-700">{{ number_format($week_revenue, 0, ',', '.') }}đ</p>
                    </div>
                    <div class="text-4xl opacity-40">📊</div>
                </div>
            </div>

            <!-- Month Revenue -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl shadow-lg p-6 border-2 border-orange-300 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-700 text-sm font-semibold">Tháng Này</p>
                        <p class="text-3xl font-bold text-orange-700">{{ number_format($month_revenue, 0, ',', '.') }}đ</p>
                    </div>
                    <div class="text-4xl opacity-40">📈</div>
                </div>
            </div>
        </div>

        <!-- Order Status Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pending Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Chờ Duyệt</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $orders_pending }}</p>
                        <p class="text-xs text-gray-500 mt-1">Đơn hàng</p>
                    </div>
                    <div class="text-4xl opacity-30">⏳</div>
                </div>
                <a href="{{ route('orders.index') }}" class="text-sm text-yellow-600 font-semibold hover:text-yellow-700 mt-4 inline-block">
                    Xem chi tiết →
                </a>
            </div>

            <!-- Completed Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Đã Duyệt</p>
                        <p class="text-3xl font-bold text-green-600">{{ $orders_completed }}</p>
                        <p class="text-xs text-gray-500 mt-1">Đơn hàng</p>
                    </div>
                    <div class="text-4xl opacity-30">✅</div>
                </div>
                <a href="{{ route('orders.index') }}" class="text-sm text-green-600 font-semibold hover:text-green-700 mt-4 inline-block">
                    Xem chi tiết →
                </a>
            </div>

            <!-- Cancelled Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Đã Hủy</p>
                        <p class="text-3xl font-bold text-red-600">{{ $orders_cancelled }}</p>
                        <p class="text-xs text-gray-500 mt-1">Đơn hàng</p>
                    </div>
                    <div class="text-4xl opacity-30">❌</div>
                </div>
                <a href="{{ route('orders.index') }}" class="text-sm text-red-600 font-semibold hover:text-red-700 mt-4 inline-block">
                    Xem chi tiết →
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Add New Product -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border-2 border-blue-200">
            <div class="text-3xl mb-3">📦</div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Thêm Sản Phẩm</h3>
            <p class="text-sm text-gray-600 mb-4">Tạo sản phẩm mới cho cửa hàng</p>
            <a href="{{ route('admin.products.create') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-semibold inline-block">
                Thêm mới →
            </a>
        </div>

        <!-- Add New Category -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border-2 border-purple-200">
            <div class="text-3xl mb-3">📁</div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Thêm Danh Mục</h3>
            <p class="text-sm text-gray-600 mb-4">Tạo danh mục sản phẩm mới</p>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-semibold inline-block">
                Thêm mới →
            </a>
        </div>

        <!-- View Orders -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 border-2 border-orange-200">
            <div class="text-3xl mb-3">🛒</div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Quản Lý Đơn Hàng</h3>
            <p class="text-sm text-gray-600 mb-4">Xem và quản lý tất cả đơn hàng</p>
            <a href="{{ route('orders.index') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-semibold inline-block">
                Xem →
            </a>
        </div>
    </div>
</div>
@endsection

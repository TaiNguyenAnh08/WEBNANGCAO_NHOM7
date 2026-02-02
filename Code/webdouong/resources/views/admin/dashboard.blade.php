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

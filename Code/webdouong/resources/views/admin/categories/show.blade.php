@extends('layouts.app')
@section('title', 'Chi Tiết Danh Mục')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">📁 {{ $category->name }}</h1>
            <p class="text-gray-600">{{ $category->description }}</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
            ← Quay lại
        </a>
    </div>

    <!-- Category Info -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-2">Tên Danh Mục</p>
                <p class="text-xl font-bold text-gray-800">{{ $category->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-2">Số Sản Phẩm</p>
                <p class="text-xl font-bold text-green-700">{{ $category->products->count() }}</p>
            </div>
        </div>
        @if($category->description)
            <div class="mt-6 pt-6 border-t">
                <p class="text-gray-600 text-sm font-semibold mb-2">Mô Tả</p>
                <p class="text-gray-700">{{ $category->description }}</p>
            </div>
        @endif
    </div>

    <!-- Products in Category -->
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">🎁 Sản Phẩm Trong Danh Mục</h2>
        
        @if($category->products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($category->products as $product)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <!-- Image -->
                    <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-6xl">🍵</div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>
                        
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xl font-bold text-green-700">{{ number_format($product->price) }}đ</span>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-semibold">
                                {{ $product->quantity }} còn
                            </span>
                        </div>

                        <!-- Sizes -->
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach($product->sizes as $size)
                            <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded">
                                {{ $size->name }}
                            </span>
                            @endforeach
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 text-center px-3 py-2 bg-yellow-500 text-white rounded text-sm font-semibold hover:bg-yellow-600 transition-colors">
                                ✏️ Sửa
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 bg-red-500 text-white rounded text-sm font-semibold hover:bg-red-600 transition-colors" onclick="return confirm('Xóa sản phẩm này?')">
                                    🗑️ Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-500 text-lg mb-6">Danh mục này chưa có sản phẩm nào</p>
                <a href="{{ route('admin.products.create') }}" class="btn-primary text-white px-6 py-3 rounded-lg font-semibold inline-block">
                    ➕ Thêm sản phẩm mới
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

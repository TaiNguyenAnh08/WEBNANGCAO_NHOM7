@extends('layouts.app')
@section('title', 'Quản Lý Sản Phẩm')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">📦 Quản Lý Sản Phẩm</h1>
            <p class="text-gray-600">Quản lý toàn bộ sản phẩm của cửa hàng</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
            ➕ Thêm sản phẩm
        </a>
    </div>

    @if (Session::has('success'))
        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 p-4 mb-6 rounded">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="bg-red-100 border-l-4 border-red-600 text-red-800 p-4 mb-6 rounded">
            {{ Session::get('error') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if($products->count() > 0)
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Tên Sản Phẩm</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Danh Mục</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Giá</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Số Lượng</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">SKU</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-700 font-semibold">{{ $product->id }}</td>
                        <td class="px-6 py-4 text-gray-700 font-semibold">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 text-gray-700 font-semibold">{{ number_format($product->price) }}đ</td>
                        <td class="px-6 py-4 text-gray-700">
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm font-mono">{{ $product->sku }}</td>
                        <td class="px-6 py-4 flex gap-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition-colors text-sm">
                                ✏️ Sửa
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-colors text-sm" onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                    🗑️ Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-500 text-lg">Không có sản phẩm nào</p>
            </div>
        @endif
    </div>
</div>
@endsection

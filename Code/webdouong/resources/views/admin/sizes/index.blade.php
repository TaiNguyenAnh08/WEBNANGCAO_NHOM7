@extends('layouts.app')
@section('title', 'Quản Lý Kích Thước')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">📏 Quản Lý Kích Thước</h1>
            <p class="text-gray-600">Quản lý kích thước sản phẩm của cửa hàng</p>
        </div>
        <a href="{{ route('admin.sizes.create') }}" class="btn-primary text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
            ➕ Thêm kích thước
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
        @if($sizes->count() > 0)
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Tên Kích Thước</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Số Sản Phẩm</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sizes as $size)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-700 font-semibold">{{ $size->id }}</td>
                        <td class="px-6 py-4 text-gray-700 font-semibold">{{ $size->name }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $size->products->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-3">
                            <a href="{{ route('admin.sizes.edit', $size) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition-colors text-sm">
                                ✏️ Sửa
                            </a>
                            <form method="POST" action="{{ route('admin.sizes.destroy', $size) }}" class="inline">
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
                <p class="text-gray-500 text-lg">Không có kích thước nào</p>
            </div>
        @endif
    </div>
</div>
@endsection

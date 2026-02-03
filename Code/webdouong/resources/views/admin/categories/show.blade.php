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
                <a href="{{ route('admin.products.create') }}?category_id={{ $category->id }}" class="btn-primary text-white px-6 py-3 rounded-lg font-semibold inline-block">
                    ➕ Thêm sản phẩm mới
                </a>
            </div>
        @endif
    </div>

    <!-- Quick Add Existing Product Form -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">➕ Thêm Sản Phẩm Có Sẵn Vào Danh Mục</h2>
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('admin.categories.addProduct', $category) }}" class="space-y-6">
                @csrf

                <!-- Select Product -->
                <div>
                    <label for="product_id" class="block text-gray-700 font-semibold mb-2">Chọn Sản Phẩm</label>
                    <select 
                        id="product_id" 
                        name="product_id"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                        required
                    >
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach($available_products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} 
                            @if($product->category)
                                (Hiện: {{ $product->category->name }})
                            @else
                                (Chưa phân loại)
                            @endif
                        </option>
                        @endforeach
                    </select>
                    @error('product_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6">
                    <button type="submit" class="flex-1 btn-primary text-white py-3 rounded-lg font-semibold transition-all">
                        ✅ Thêm Sản Phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Add New Product Form -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">➕ Thêm Sản Phẩm Mới Vào Danh Mục</h2>
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Tên Sản Phẩm</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                        placeholder="Nhập tên sản phẩm"
                        required
                    >
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-semibold mb-2">Mô Tả</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="2"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                        placeholder="Nhập mô tả sản phẩm"
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Price & SKU -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-gray-700 font-semibold mb-2">Giá (đ)</label>
                        <input 
                            type="number" 
                            id="price" 
                            name="price" 
                            value="{{ old('price') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                            placeholder="Nhập giá"
                            min="0"
                            step="1000"
                            required
                        >
                        @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="sku" class="block text-gray-700 font-semibold mb-2">SKU</label>
                        <input 
                            type="text" 
                            id="sku" 
                            name="sku" 
                            value="{{ old('sku') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                            placeholder="SKU-001"
                            required
                        >
                        @error('sku')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Quantity & Stock -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="quantity" class="block text-gray-700 font-semibold mb-2">Số Lượng</label>
                        <input 
                            type="number" 
                            id="quantity" 
                            name="quantity" 
                            value="{{ old('quantity') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                            min="0"
                            required
                        >
                        @error('quantity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-gray-700 font-semibold mb-2">Tồn Kho</label>
                        <input 
                            type="number" 
                            id="stock" 
                            name="stock" 
                            value="{{ old('stock') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                            min="0"
                            required
                        >
                        @error('stock')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-gray-700 font-semibold mb-2">Hình Ảnh (Tùy chọn)</label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                        accept="image/*"
                    >
                    @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Sizes -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Kích Thước</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($sizes ?? [] as $size)
                        <label class="flex items-center gap-3 p-3 border-2 border-gray-300 rounded-lg hover:border-green-600 cursor-pointer transition-colors">
                            <input 
                                type="checkbox" 
                                name="sizes[]" 
                                value="{{ $size->id }}"
                                {{ in_array($size->id, old('sizes', [])) ? 'checked' : '' }}
                                class="w-5 h-5 rounded"
                            >
                            <span class="text-gray-700 font-medium">{{ $size->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('sizes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Hidden Category ID -->
                <input type="hidden" name="category_id" value="{{ $category->id }}">

                <!-- Buttons -->
                <div class="flex gap-4 pt-6 border-t">
                    <button type="submit" class="flex-1 btn-primary text-white py-3 rounded-lg font-semibold transition-all">
                        ✅ Thêm Sản Phẩm Mới
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-center">
                        ❌ Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

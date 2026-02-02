@extends('layouts.app')
@section('title', 'Sửa Sản Phẩm')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">✏️ Sửa Sản Phẩm</h1>
        <p class="text-gray-600 mb-8">Cập nhật thông tin sản phẩm "{{ $product->name }}"</p>

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Tên Sản Phẩm</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $product->name) }}"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                    placeholder="Nhập tên sản phẩm"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700 font-semibold mb-2">Mô Tả</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                    placeholder="Nhập mô tả sản phẩm"
                    required
                >{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-gray-700 font-semibold mb-2">Danh Mục</label>
                <select 
                    id="category_id" 
                    name="category_id"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                    required
                >
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-gray-700 font-semibold mb-2">Giá (đ)</label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        value="{{ old('price', $product->price) }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                        placeholder="Nhập giá sản phẩm"
                        min="0"
                        step="1000"
                        required
                    >
                    @error('price')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-gray-700 font-semibold mb-2">SKU</label>
                    <input 
                        type="text" 
                        id="sku" 
                        name="sku" 
                        value="{{ old('sku', $product->sku) }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                        placeholder="SKU-001"
                        required
                    >
                    @error('sku')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Quantity -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="quantity" class="block text-gray-700 font-semibold mb-2">Số Lượng</label>
                    <input 
                        type="number" 
                        id="quantity" 
                        name="quantity" 
                        value="{{ old('quantity', $product->quantity) }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                        placeholder="Nhập số lượng"
                        min="0"
                        required
                    >
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-gray-700 font-semibold mb-2">Tồn Kho</label>
                    <input 
                        type="number" 
                        id="stock" 
                        name="stock" 
                        value="{{ old('stock', $product->stock) }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                        placeholder="Nhập tồn kho"
                        min="0"
                        required
                    >
                    @error('stock')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-gray-700 font-semibold mb-2">Hình Ảnh</label>
                @if($product->image)
                    <div class="mb-3 p-3 bg-gray-100 rounded-lg">
                        <p class="text-sm text-gray-600 mb-2">Hình ảnh hiện tại:</p>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-w-xs rounded">
                    </div>
                @endif
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                    accept="image/*"
                >
                <p class="text-sm text-gray-600 mt-2">Để trống nếu không muốn thay đổi hình ảnh</p>
                @error('image')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sizes -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kích Thước</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($sizes as $size)
                    <label class="flex items-center gap-3 p-3 border-2 border-gray-300 rounded-lg hover:border-green-600 cursor-pointer transition-colors">
                        <input 
                            type="checkbox" 
                            name="sizes[]" 
                            value="{{ $size->id }}"
                            {{ $product->sizes->contains($size->id) ? 'checked' : '' }}
                            class="w-5 h-5 rounded"
                        >
                        <span class="text-gray-700 font-medium">{{ $size->name }}</span>
                    </label>
                    @endforeach
                </div>
                @error('sizes')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 btn-primary text-white py-3 rounded-lg font-semibold transition-all">
                    ✅ Cập Nhật
                </button>
                <a href="{{ route('admin.products.index') }}" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-center">
                    ❌ Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

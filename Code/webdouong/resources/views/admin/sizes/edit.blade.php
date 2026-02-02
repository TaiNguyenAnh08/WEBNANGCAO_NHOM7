@extends('layouts.app')
@section('title', 'Sửa Kích Thước')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">✏️ Sửa Kích Thước</h1>
        <p class="text-gray-600 mb-8">Cập nhật thông tin kích thước "{{ $size->name }}"</p>

        <form method="POST" action="{{ route('admin.sizes.update', $size) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Tên Kích Thước</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $size->name) }}"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-600 focus:outline-none transition-colors"
                    placeholder="Ví dụ: M - 350ml"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 btn-primary text-white py-3 rounded-lg font-semibold transition-all">
                    ✅ Cập Nhật
                </button>
                <a href="{{ route('admin.sizes.index') }}" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-center">
                    ❌ Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

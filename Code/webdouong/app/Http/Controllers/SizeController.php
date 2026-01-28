<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Hiển thị danh sách tất cả kích thước
     * GET /sizes
     */
    public function index()
    {
        $sizes = Size::paginate(10);
        return view('sizes.index', ['sizes' => $sizes]);
    }

    /**
     * Hiển thị form tạo kích thước mới
     * GET /sizes/create
     */
    public function create()
    {
        return view('sizes.create');
    }

    /**
     * Lưu kích thước mới vào database
     * POST /sizes
     */
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|unique:sizes,name|max:255',
        ]);

        // Tạo kích thước mới
        Size::create($validated);

        return redirect()->route('sizes.index')->with('success', 'Thêm kích thước thành công!');
    }

    /**
     * Hiển thị chi tiết 1 kích thước
     * GET /sizes/{id}
     */
    public function show(Size $size)
    {
        $size->load('products');
        return view('sizes.show', ['size' => $size]);
    }

    /**
     * Hiển thị form sửa kích thước
     * GET /sizes/{id}/edit
     */
    public function edit(Size $size)
    {
        return view('sizes.edit', ['size' => $size]);
    }

    /**
     * Cập nhật kích thước trong database
     * PUT /sizes/{id}
     */
    public function update(Request $request, Size $size)
    {
        // Kiểm tra dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|unique:sizes,name,' . $size->id . '|max:255',
        ]);

        // Cập nhật kích thước
        $size->update($validated);

        return redirect()->route('sizes.index')->with('success', 'Cập nhật kích thước thành công!');
    }

    /**
     * Xóa kích thước khỏi database
     * DELETE /sizes/{id}
     */
    public function destroy(Size $size)
    {
        // Xóa các liên kết với sản phẩm
        $size->products()->detach();

        // Xóa kích thước
        $size->delete();

        return redirect()->route('sizes.index')->with('success', 'Xóa kích thước thành công!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách tất cả danh mục
     * GET /categories
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Hiển thị form tạo danh mục mới
     * GET /categories/create
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Lưu danh mục mới vào database
     * POST /categories
     */
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
            'description' => 'nullable|string',
        ]);

        // Tạo danh mục mới
        Category::create($validated);

        // Chuyển hướng về trang danh sách kèm thông báo
        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    /**
     * Hiển thị chi tiết 1 danh mục
     * GET /categories/{id}
     */
    public function show(Category $category)
    {
        return view('categories.show', ['category' => $category]);
    }

    /**
     * Hiển thị form sửa danh mục
     * GET /categories/{id}/edit
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * Cập nhật danh mục trong database
     * PUT /categories/{id}
     */
    public function update(Request $request, Category $category)
    {
        // Kiểm tra dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:255',
            'description' => 'nullable|string',
        ]);

        // Cập nhật danh mục
        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Xóa danh mục khỏi database
     * DELETE /categories/{id}
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách tất cả sản phẩm
     * GET /products
     */
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', ['products' => $products]);
    }

    /**
     * Hiển thị form tạo sản phẩm mới
     * GET /products/create
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        return view('admin.products.create', ['categories' => $categories, 'sizes' => $sizes]);
    }

    /**
     * Lưu sản phẩm mới vào database
     * POST /products
     */
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku|max:255',
            'quantity' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sizes' => 'array|exists:sizes,id',
        ]);

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Tạo sản phẩm mới
        $product = Product::create($validated);

        // Gắn kích thước cho sản phẩm
        if ($request->has('sizes')) {
            $product->sizes()->attach($request->sizes);
        }

        // Nếu tạo từ trang category show, redirect trở lại category
        if ($request->has('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                return redirect()->route('admin.categories.show', $category)
                    ->with('success', 'Thêm sản phẩm mới thành công!');
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Hiển thị chi tiết 1 sản phẩm
     * GET /products/{id}
     */
    public function show(Product $product)
    {
        $product->load('category', 'sizes', 'orderItems');
        return view('products.show', ['product' => $product]);
    }

    /**
     * Hiển thị form sửa sản phẩm
     * GET /products/{id}/edit
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $sizes = Size::all();
        $selectedSizes = $product->sizes->pluck('id')->toArray();
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'sizes' => $sizes,
            'selectedSizes' => $selectedSizes,
        ]);
    }

    /**
     * Cập nhật sản phẩm trong database
     * PUT /products/{id}
     */
    public function update(Request $request, Product $product)
    {
        // Kiểm tra dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id . '|max:255',
            'quantity' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sizes' => 'array|exists:sizes,id',
        ]);

        // Xử lý upload ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Cập nhật sản phẩm
        $product->update($validated);

        // Cập nhật kích thước
        if ($request->has('sizes')) {
            $product->sizes()->sync($request->sizes);
        } else {
            $product->sizes()->detach();
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Xóa sản phẩm khỏi database
     * DELETE /products/{id}
     */
    public function destroy(Product $product)
    {
        // Xóa ảnh nếu có
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        // Xóa các kích thước liên kết
        $product->sizes()->detach();

        // Xóa sản phẩm
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}

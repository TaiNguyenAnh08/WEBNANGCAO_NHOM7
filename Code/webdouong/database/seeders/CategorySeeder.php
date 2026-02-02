<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo các danh mục
        Category::create([
            'name' => 'Nước uống cơ bản',
            'description' => 'Nước lọc, nước khoáng, nước suối',
        ]);

        Category::create([
            'name' => 'Nước trái cây',
            'description' => 'Nước cam, nước dâu, nước xoài, nước táo',
        ]);

        Category::create([
            'name' => 'Sinh tố',
            'description' => 'Sinh tố dâu, sinh tố xoài, sinh tố chuối',
        ]);

        Category::create([
            'name' => 'Cà phê',
            'description' => 'Cà phê đen, cà phê sữa, cappuccino',
        ]);

        Category::create([
            'name' => 'Trà',
            'description' => 'Trà xanh, trà đen, trà hoa cúc',
        ]);

        Category::create([
            'name' => 'Nước ngọt',
            'description' => 'Coca, Pepsi, Sprite, 7UP',
        ]);

        Category::create([
            'name' => 'Đồ uống khác',
            'description' => 'Các loại đồ uống khác',
        ]);
    }
}

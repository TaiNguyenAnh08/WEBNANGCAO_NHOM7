<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // Tên sản phẩm mẫu
        $productNames = [
            'Nước cam tươi',
            'Nước dâu tươi',
            'Nước xoài tươi',
            'Sinh tố dâu',
            'Sinh tố xoài',
            'Sinh tố chuối',
            'Cà phê đen đá',
            'Cà phê sữa đá',
            'Cappuccino',
            'Espresso',
            'Trà xanh',
            'Trà đen',
            'Nước lọc',
            'Nước khoáng',
            'Coca Cola',
            'Sprite',
        ];

        $categories = Category::all();
        $sizes = Size::all();

        // Tạo sản phẩm
        foreach ($productNames as $index => $name) {
            // Tạo SKU từ index để tránh vấn đề ký tự Việt
            $sku = 'SKU-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT);
            
            $product = Product::create([
                'name' => $name,
                'description' => $faker->sentence(),
                'price' => $faker->numberBetween(15000, 50000),
                'sku' => $sku,
                'quantity' => $faker->numberBetween(10, 100),
                'stock' => $faker->numberBetween(5, 50),
                'category_id' => $categories->random()->id,
                'is_active' => $faker->boolean(90), // 90% sẽ là true
            ]);

            // Gắn ngẫu nhiên 1-3 kích thước cho mỗi sản phẩm
            $randomSizes = $sizes->random(rand(1, 3));
            $product->sizes()->attach($randomSizes);
        }
    }
}

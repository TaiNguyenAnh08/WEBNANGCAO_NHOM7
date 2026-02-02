<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo các kích thước
        Size::create(['name' => 'S - Nhỏ (250ml)']);
        Size::create(['name' => 'M - Vừa (350ml)']);
        Size::create(['name' => 'L - Lớn (500ml)']);
        Size::create(['name' => 'XL - Rất lớn (750ml)']);
    }
}

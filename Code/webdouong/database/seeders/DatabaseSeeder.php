<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo user test với is_admin = false
        User::create([
            'name' => 'Test User',
            'email' => 'hahaha@gmail.com',
            'password' => Hash::make('hihihi'),
            'is_admin' => false,
        ]);

        // Tạo user admin
        User::create([
            'name' => 'Admin User',
            'email' => 'taidz852005@gmail.com',
            'password' => Hash::make('Tai12345'),
            'is_admin' => true,
        ]);

        // Chạy các seeder khác
        $this->call([
            CategorySeeder::class,
            SizeSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán trực tiếp
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Quan hệ: 1 Category có nhiều Products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

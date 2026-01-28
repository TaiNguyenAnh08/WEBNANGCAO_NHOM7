<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán trực tiếp
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'sku',
        'quantity',
        'stock',
        'image',
        'category_id',
        'is_active',
    ];

    /**
     * Các cột cần cast (chuyển đổi kiểu dữ liệu)
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Quan hệ: 1 Product thuộc 1 Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Quan hệ: 1 Product có nhiều Sizes (many-to-many)
     */
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes');
    }

    /**
     * Quan hệ: 1 Product có nhiều OrderItems
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

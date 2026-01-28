<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán trực tiếp
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'size_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    /**
     * Các cột cần cast
     */
    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Quan hệ: 1 OrderItem thuộc 1 Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Quan hệ: 1 OrderItem thuộc 1 Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Quan hệ: 1 OrderItem thuộc 1 Size
     */
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}

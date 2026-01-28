<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán trực tiếp
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'total_price',
        'status',
        'customer_notes',
    ];

    /**
     * Các cột cần cast
     */
    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Quan hệ: 1 Order thuộc 1 User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ: 1 Order có nhiều OrderItems
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Quan hệ: 1 Order có thể có 1 Payment
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

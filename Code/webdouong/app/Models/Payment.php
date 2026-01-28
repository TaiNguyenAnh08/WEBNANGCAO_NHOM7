<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán trực tiếp
     */
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'status',
        'transaction_code',
        'notes',
    ];

    /**
     * Các cột cần cast
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Quan hệ: 1 Payment thuộc 1 Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

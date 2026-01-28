<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán trực tiếp
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Quan hệ: 1 Size có nhiều Products (many-to-many)
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes');
    }
}

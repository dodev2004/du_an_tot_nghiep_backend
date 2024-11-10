<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Tên bảng nếu cần thiết
    protected $table = 'order_items';

    // Các thuộc tính có thể gán
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'total',
    ];

    // Định nghĩa mối quan hệ với model Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Định nghĩa mối quan hệ với model Product (nếu cần)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function product_reviews()
    {
        return $this->hasOne(ProductReview::class, 'order_item_id');
    }
}


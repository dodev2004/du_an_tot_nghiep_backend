<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'product_id', 'product_variant_id', 'quantity'];

    /**
     * Liên kết với bảng Product (Sản phẩm không có biến thể).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Liên kết với bảng ProductVariant (Sản phẩm có biến thể).
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Liên kết với bảng User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

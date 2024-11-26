<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_reviews';

    protected $fillable = [
        'order_item_id',
        'product_id',
        'user_id',
        'rating',
        'review',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(ProductComment::class, 'review_id');
    }
}

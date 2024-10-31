<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_comments';

    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
        'review_id'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function review()
    {
        return $this->belongsTo(ProductReview::class, 'review_id');
    }
}

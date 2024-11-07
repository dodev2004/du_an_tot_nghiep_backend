<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_variants_id', 'quantity'];

    // Mối quan hệ với bảng Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mối quan hệ với bảng ProductVariants
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variants_id');
    }
}

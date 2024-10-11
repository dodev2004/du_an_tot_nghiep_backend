<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    protected $fillable = [
        'catalogue_id', 'brand_id', 'name', 'slug', 'sku', 'detailed_description',
        'image_url', 'price', 'discount_price', 'discount_percentage', 'stock',
        'weight', 'ratings_avg', 'ratings_count', 'is_active', 'is_featured'
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function users(){
        return $this->belongsTo(User::class,"user_id");
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);   
    }
    public static function boot(){
        parent::boot();
        static::deleting(function($model){
            $model->catelogues()->detach();
        });
    }
    public function catelogues(){
        return  $this->belongsToMany(ProductCatelogue::class,"product_product_catalogue");
    }
   

}

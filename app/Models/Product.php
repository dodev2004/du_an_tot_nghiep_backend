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
        'weight', 'ratings_avg', 'ratings_count', 'status', 'is_featured'
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function users(){
        return $this->belongsTo(User::class,"user_id");
    }
    public function product_comments()
    {
        return $this->hasMany(ProductComment::class, 'product_id'); 
    }
    public function product_reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);   
    }

    public function attributeVariants()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attribute_values', 'product_variant_id', 'attribute_value_id');
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
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }

}

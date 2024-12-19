<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', 'price', 'weight', 'dimension', 'stock', 'sku', 'image_url',"discount_price"
    ];
    protected $table = "product_variants";
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attribute_values', 'product_variant_id', 'attribute_value_id');
    }
    public function variantAttributeValues()
    {
        return $this->hasMany(VariantAttributeValue::class);
    }
}

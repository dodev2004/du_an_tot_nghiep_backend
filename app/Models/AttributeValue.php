<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "attribute_id"
    ];
    protected $table = "attribute_values";
    public function attributes(){
        return $this->belongsTo(Attribute::class,'attribute_id');
    }
    public function productVariants()
    {
        return $this->belongsToMany(ProductVariant::class, 'variant_attribute_values', 'attribute_value_id', 'product_variant_id');
    }
}

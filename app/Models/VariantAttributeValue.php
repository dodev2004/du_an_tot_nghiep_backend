<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'attribute_value_id',
    ];

    protected $table = 'variant_attribute_values';

    // Mối quan hệ với ProductVariant
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // Mối quan hệ với AttributeValue
    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}

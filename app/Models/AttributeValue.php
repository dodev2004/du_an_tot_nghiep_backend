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
}

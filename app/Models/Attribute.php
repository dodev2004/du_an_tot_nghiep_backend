<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
    ];
    protected $table = "attributes";
    public function attributevalues(){
        return $this->hasMany(AttributeValue::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Brand extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        "name",
        "description",
        "status",
    ];
    protected $dates = ['deleted_at'];
    protected $table = "brands";
    public function products(){
        return $this->hasMany(Product::class,"brand_id","id");
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class ProductCatelogue extends Model
{
    use HasFactory,SoftDeletes, NodeTrait;
    protected $table = "product_catelogues";
    protected $fillable = [
        "name",
        "description",
        "slug",
        "meta_description",
        "parent_id",
        "meta_keywords",
        "description",
        "user_id",
        "level"
    ];
    public static function boot(){
        parent::boot();
        static::saving(function($model){
            if($model->parent_id){
                $level = $model::query()-> where("id",$model->parent_id)->get()[0]->level + 1;
                $model->level = $level;
               
            }
            
        });
    }
}

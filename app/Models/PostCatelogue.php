<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class PostCatelogue extends Model
{
    use HasFactory,NodeTrait,SoftDeletes;
    protected $table = "post_catelogues";
    protected $fillable = [
        "name",
        "description",
        "slug",
        "avatar",
        "meta-description",
        "meta-keywords",
        "user_id",
        "status",
        "level",
        "parent_id"
    ];
    public function post()
    {
        return $this->belongsToMany(Post::class,"post_post_catelogue");
    }
    public static function boot(){
        parent::boot();
        static::saving(function($model){
            if($model->parent_id){
                $parent = PostCatelogue::find($model->parent_id);
                $model->level = $parent ? $parent->level + 1 : 0;
            }
            else {
                $model->level = 0 ;
            }
        });
        static::deleting(function($model){
            if($model->descendants()){
                $model->deleteDescendants();
            }
             
        });
        static::forceDeleting(function($model){
            if($model->descendants()){
               
            }
        });
    }
}

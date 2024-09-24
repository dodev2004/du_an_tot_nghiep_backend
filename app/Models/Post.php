<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "content",
        "user_id",
        "image",
        "folow",
        "meta_keywords",
        "meta_description",
        "status",
        "slug"
    ];
    public function catelogues(){
       return  $this->belongsToMany(PostCatelogue::class,"post_post_catelogue");
    }
    public function users(){
        return $this->belongsTo(User::class,"user_id");
    }
    public static function boot(){
        parent::boot();
        static::deleting(function($model){
            $model->catelogues()->detach();
        });
    }

}

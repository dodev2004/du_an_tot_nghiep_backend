<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Repositories\BaseRespository;
use App\Repositories\Interfaces\PostCatelogueRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
/**
 * Class UserService
 * @package App\Services
 */
class PostRepository extends BaseRespository  implements PostRepositoryInterface
{
    protected $model;
     private $catelogue;
    public function __construct(
        Post $model,
        PostCatelogueRepositoryInterface $catelogue

        
    ){
        $this->model = $model;
        $this->catelogue = $catelogue;    
    }
    public function create($data)
    {
        return  $this->model::create($data);
    }
    public function getAllPost()
    {
        $query = Post::with(["catelogues","users"])
         ->where(function(Builder $query) {
            if(request()->has(["keywords"])){
                $query->where("title","like",'%'. request()->keywords . '%');
              }
        })->paginate(15)->appends(request()->query());
    
        return $query;
    }
    public function getParentCatelogue($catelogue_id){
        return $this->catelogue->getParent($catelogue_id);
    }
    public function updatePostById($id,$data)
    {
;
    $post =  $this->model::findOrFail($id);
    return $post->update($data);
    }
    public function findPostById($id)
    {
        return $this->model::findOrFail($id);       
    }
    public function delete($request)
    {
        $id = $request->id;
        $this->model::find($id)->delete();
      
    }       
    public function getCatelogueByPost(){
        $post = $this->model::with('catelogues')->findOrFail(request()->id);
        return $post->catelogues->pluck("id");
       
    }
}


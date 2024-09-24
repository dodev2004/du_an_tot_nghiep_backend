<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Repositories\BaseRespository;
use App\Repositories\Interfaces\PostCatelogueRepositoryInterface;
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
        $posts = Post::with(["catelogues","users"])->get();
       
        $posts = $posts->map(function($post){
            
            return [
                "title" => $post->title,
                "catelogues" =>$post->catelogues->pluck("name"),
                "author" => $post->users->Fullname,
                "created_at" => $post->created_at,
                "updated_at" => $post->updated_at,
                "id" => $post->id,
                "description" => $post->description,
                "status" => $post->status,  

            ];
        });
        return $posts;
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


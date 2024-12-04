<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Repositories\BaseRespository;
use App\Repositories\Interfaces\PostCatelogueRepositoryInterface;
use DateTime;
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
            if(request()->has(["ky_tu"]) && !empty(request()->ky_tu)){
            
                $query->where("title","like",'%'. request()->ky_tu . '%');
            }
            if(request()->has(["trang_thai"]) && (request()->trang_thai == 0 ||request()->trang_thai  )){
                if(request()->has("trang_thai")) {
                    // Kiểm tra nếu trang_thai là 0 hoặc 1
               
                    if (request()->trang_thai === '0' || request()->trang_thai === '1') {
                   
                        $query->where('status', request()->trang_thai);
                    }
                }
            }
            if(request()->has("chuyen_muc") && !empty(request()->chuyen_muc)){
                $query->whereHas("catelogues",function($query){
                    $query->where("name","like","%".request()->chuyen_muc . "%");
                });
            }
            if(request()->has(["ngay_dang"]) && !empty(request()->ngay_dang)){
              
             
                $query->where("created_at","=",date("Y-m-d H:i:s",strtotime(request()->ngay_dang)));
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

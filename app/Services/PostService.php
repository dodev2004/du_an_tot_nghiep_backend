<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use  App\Services\Interfaces\PostCatelogueServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Classes\NestedSetBuild;
use Illuminate\Support\Facades\DB;
/**
 * Class UserCatelogueService
 * @package App\Services
 */
class PostService implements PostServiceInterface
{
    private $post;
    private $nestedSetBuild;
  
    private $catelogueRespository;
    protected $table_name = "Quản lý bài viết";
    
    public function __construct(PostRepositoryInterface $post,NestedSetBuild $nestedSetBuild,PostCatelogueServiceInterface $catelogue){
          $this->post = $post;
        $this->nestedSetBuild = $nestedSetBuild;
        $this->catelogueRespository = $catelogue;

    }
    public function getAll(){
       return $this->post->getAllPost();
    }
    public function getCatelogueByPost(){    
        return $this->post->getCatelogueByPost();
    }
    public  function getPostByPostId($postId){
        return $this->post->findPostById($postId);
    }
    public function dropdownPostCatelogue($target = "create",$catelogue= []){
        $this->nestedSetBuild->_set("post_catelogues"); 
        return $this->nestedSetBuild->renderDropdownCreate($this->nestedSetBuild->Get($target),0,$target, $catelogue,"post_catelogue_id");
    }
    public function postStore ($request){
       
        
        DB::beginTransaction();
        try{
        $data = $request->except(["_token","post_catelogue_id"]);
        $item =$this->post->create($data);
        $catelogue = explode(",",$request->post_catelogue_id);
        if(count($catelogue) > 0){
            $item->catelogues()->sync($catelogue);
        }
        DB::commit();   
            return true;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
            DB::rollBack();
            return false;
        }
    }
    public function PostUpdate($request){
        DB::beginTransaction();
        try{
            $catelogue = [];
           $data = $request->except(["id","catelogues"]);
          
          $catelogue = explode(",",$request->catelogues);
         $post = $this->getPostByPostId($request->id);
          if(count($catelogue) > 0){
              $post->catelogues()->sync($catelogue);
          }
            DB::commit();
            return true;
        }
        catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }
    public function PostCatelogueDelete($request){
        try{
            $this->post->delete($request);
            return true;
        }
        catch(\Exception $e){
            return false;
        }
       
    }
    // public function getAll(){
    //     return $this->postCatelogue->
    // }
    // public function create($data)
    // {
    //     try{
    //          $this->postCatelogue->create($data);  
    //         return true;
    //     }
    //     catch(\Exception $e){
    //         return false;
    //     }
    // }

}

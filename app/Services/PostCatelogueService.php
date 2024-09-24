<?php

namespace App\Services;

use App\Repositories\Interfaces\PostCatelogueRepositoryInterface;;
use  App\Services\Interfaces\PostCatelogueServiceInterface;
use App\Classes\NestedSetBuild;
use Illuminate\Support\Facades\DB;
/**
 * Class UserCatelogueService
 * @package App\Services
 */
class PostCatelogueService implements PostCatelogueServiceInterface
{
    protected $postCatelogue;
    protected $nestedSetBuild;
    public function __construct(PostCatelogueRepositoryInterface $postCatelogue,NestedSetBuild $nestedSetBuild){
        $this->postCatelogue = $postCatelogue;
        $this->nestedSetBuild = $nestedSetBuild;
    }
    public function getAllPosCatelogue(){
        $this->nestedSetBuild->_set("post_catelogues"); 
      return $post_catelogues =$this->nestedSetBuild->renderListPostCatelogue($this->nestedSetBuild->Get());
    }
    public function dropdownPostCatelogue($target = "create"){
        $this->nestedSetBuild->_set("post_catelogues"); 
        return $this->nestedSetBuild->renderDropdown($this->nestedSetBuild->Get($target),0,"edit");
    }
    public function PostCateloguecreate($request){
        
    }
    public function PostCatelogueStore($request){
        DB::beginTransaction();
        try{
            $data = $request->except(["_token"]);
            $this->postCatelogue->create($data);
            DB::commit();
            return true;
        }
        catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function PostCatelogueEdit($request,$title,$breadcrumbs){
        $id = $request->id;
        $post_catelogues = $this->postCatelogue->findCatelogueById($id);
        $request->merge(['parent_id' => $post_catelogues->parent_id]);
        $this->nestedSetBuild->_set("post_catelogues");
        $catelogues =$this->dropdownPostCatelogue($target = "edit");
        return  view("backend.posts.templates.post_catelogue.edit",compact("breadcrumbs","title","post_catelogues","catelogues","id"));
    }
    public function PostCatelogueUpdate($request){
        DB::beginTransaction();
        try{
            $id = $request->id;
            $post_catelogues = $this->postCatelogue->findCatelogueById($id);
            $data = $request->except(["_token"]);
            $post_catelogues->update($data);
            DB::commit();
            return true;
        }
        catch(\Exception $e){
            DB::rollBack();
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

<?php

namespace App\Services;

use App\Repositories\Interfaces\PostCatelogueRepositoryInterface;;
use  App\Services\Interfaces\PostCatelogueServiceInterface;
use App\Classes\NestedSetBuild;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Kalnoy\Nestedset\NestedSet;

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
    public function getAllPosCatelogue()
    {
        $this->nestedSetBuild->_set("post_catelogues"); 
        $data = $this->nestedSetBuild->Get("list");
        
        // Xây dựng cấu trúc danh mục cha-con
        $nestedCategories = $this->buildNestedCategories($data);
        // Phân trang danh mục cha
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 1; // Số lượng mục trên mỗi trang
        $currentItems = collect($nestedCategories)->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        $paginatedItems = new LengthAwarePaginator($currentItems, count($nestedCategories), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => request()->query(), // Giữ lại các tham số truy vấn
        ]);
        $post_catelogues = $this->nestedSetBuild->renderListPostCatelogue($paginatedItems); // Gọi hàm render với danh sách phân trang
        
        return ["html" => $post_catelogues, "data" => $paginatedItems];
    }
    
    private function buildNestedCategories($categories, $parentId = null)
    {
        $results = []; // Mảng lưu trữ các danh mục đã được tổ chức
    
        foreach ($categories as $category) {
            // Kiểm tra nếu danh mục có parent_id bằng với $parentId
            if ($category->parent_id == $parentId) {
                // Gọi đệ quy để tìm các danh mục con
                $children = $this->buildNestedCategories($categories, $category->id);
                $category->children = $children; // Gán danh sách con vào thuộc tính 'children'
                $results[] = $category; // Thêm danh mục vào kết quả
            }
        }
    
        return $results; // Trả về danh sách các danh mục đã tổ chức
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

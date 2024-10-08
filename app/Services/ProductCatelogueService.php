<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductCatelogueRepositoryInterface as ProductCatelogueRepository;
use  App\Services\Interfaces\ProductCatelogueServiceInterface;
use App\Classes\NestedSetBuild;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
/**
 * Class UserCatelogueService
 * @package App\Services
 */
class ProductCatelogueService implements ProductCatelogueServiceInterface
{
    protected $productCatelogue;
    protected $nestedSetBuild;
    public function __construct(ProductCatelogueRepository $productCatelogue,NestedSetBuild $nestedSetBuild){
        $this->productCatelogue = $productCatelogue;
        $this->nestedSetBuild = $nestedSetBuild;
    }
    public function getAllProductCatelogue(){
        $this->nestedSetBuild->_set("product_catelogues"); 
        // return  $this->nestedSetBuild->renderListProductCatelogue($this->nestedSetBuild->Get());
        $data = $this->nestedSetBuild->Get("list");
        
        // Xây dựng cấu trúc danh mục cha-con
        $nestedCategories = $this->buildNestedCategories($data);
        // Phân trang danh mục cha
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15; // Số lượng mục trên mỗi trang
        $currentItems = collect($nestedCategories)->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        $paginatedItems = new LengthAwarePaginator($currentItems, count($nestedCategories), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => request()->query(), // Giữ lại các tham số truy vấn
        ]);
        $post_catelogues = $this->nestedSetBuild->renderListPostCatelogue($paginatedItems); // Gọi hàm render với danh sách phân trang
        
        return ["html" => $post_catelogues, "data" => $paginatedItems];
    }
    public function dropdownCatelogue($target = "create"){
        $this->nestedSetBuild->_set("product_catelogues"); 
        return $this->nestedSetBuild->renderDropdown($this->nestedSetBuild->Get($target),0,"edit");
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
    public function StoreProductCatelogue($data){
        
        DB::beginTransaction();
        try{
           
            $this->productCatelogue->create($data);
            DB::commit();
            return true;
        }
        catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function EditProductCatelogue($request,$title,$breadcrumbs){
        $id = $request->id;
        $productCatelogue = $this->productCatelogue->findId($id);
        $request->merge(['parent_id' => $productCatelogue->parent_id]);
        $this->nestedSetBuild->_set("product_catelogues");
        $catelogues =$this->dropdownCatelogue($target = "edit");
        return  view("backend.product_catelogues.templates.edit",compact("breadcrumbs","title","productCatelogue","catelogues","id"));
    }
    public function UpdateProductCatelogue($data,$id){
        DB::beginTransaction();
        try{
            $post_catelogues = $this->productCatelogue->findId($id);
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

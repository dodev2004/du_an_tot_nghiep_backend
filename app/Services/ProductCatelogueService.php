<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductCatelogueRepositoryInterface as ProductCatelogueRepository;
use  App\Services\Interfaces\ProductCatelogueServiceInterface;
use App\Classes\NestedSetBuild;
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
        return  $this->nestedSetBuild->renderListProductCatelogue($this->nestedSetBuild->Get());
    }
    public function dropdownCatelogue($target = "create"){
        $this->nestedSetBuild->_set("product_catelogues"); 
        return $this->nestedSetBuild->renderDropdown($this->nestedSetBuild->Get($target),0,"edit");
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

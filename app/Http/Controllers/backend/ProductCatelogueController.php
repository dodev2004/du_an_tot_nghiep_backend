<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\ProductCatelogueServiceInterface;
use App\Http\Requests\StoreProductCatelogueRequest ;
use App\Http\Requests\UpdateProductCatelogueRequest;
use App\Services\ProductCatelogueService;

class ProductCatelogueController extends Controller
{
    private $breadcrumbs = [];
    private $productCatelogueService;
   
    public function __construct(ProductCatelogueServiceInterface  $productCatelogueService){
        $this->productCatelogueService = $productCatelogueService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Quản lý danh mục sản phẩm";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.post-catelogue.create"),
            "name"=>"Quản lý danh mục sản phẩm"
         ]);
         $table_name = "Bảng quản lý danh mục sản phẩm ";
         $productCatelogue = $this->productCatelogueService->getAllProductCatelogue();   
         $pagination = $productCatelogue["data"];     
         $productCatelogue = $productCatelogue["html"];
         $total = 0;
         foreach($pagination as $item) {
            $total += $total +1 + count($item->children); 
         };
         $breadcrumbs = $this->breadcrumbs;
         return view("backend.product_catelogues.templates.index",compact("title","breadcrumbs","pagination","table_name","productCatelogue","total"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Quản lý danh mục sản phẩm";
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.post-catelogue"),
            "name"=>"Quản lý danh mục sản phẩm"
        ],[
            "active"=>true,
            "url"=> route("admin.post-catelogue.create"),
            "name"=>"Thêm mới danh mục bài viết"
         ]);  
         $productCatelogues =$this->productCatelogueService->dropdownCatelogue();
         $breadcrumbs = $this->breadcrumbs;
         return  view("backend.product_catelogues.templates.create",compact("breadcrumbs","title","productCatelogues"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCatelogueRequest $request)
    {
        if($this->productCatelogueService->StoreProductCatelogue($request->except("_token"))){
            return response()->json(["success","Thêm mới danh mục sản phẩm thành công"]);
        }
        else {
            return response()->json(["error","Thêm mới danh mục sản phẩm thất bại"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Quản lý danh mục sản phẩm - Sửa danh mục sản phẩm";
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.post-catelogue"),
            "name"=>"Quản lý danh mục sản phẩm"
        ],[
            "active"=>true,
            "url"=> route("admin.post-catelogue.create"),
            "name"=>"Thêm mới danh mục bài viết"
         ]);  
        $breadcrumbs = $this->breadcrumbs;
       return  $this->productCatelogueService->EditProductCatelogue(request(),$title,$breadcrumbs);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCatelogueRequest $request, string $id)
    {
        if($this->productCatelogueService->UpdateProductCatelogue($request->except("_token"),$id)){
            return response()->json(["success","Sửa danh mục sản phẩm thành công"]);
        }
        else {
            return response()->json(["error","Sửa danh mục sản phẩm thất bại"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}

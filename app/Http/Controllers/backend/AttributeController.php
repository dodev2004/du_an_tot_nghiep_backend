<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use  App\Services\Interfaces\AttributeServiceInterface as AttributeService;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $breadcrumbs = [];
    protected $attribute;
    public function __construct(AttributeService $attribute){
        $this->attribute = $attribute;  // Your implementation here
    }
    public function index()
    {
        $title = "Quản lý danh mục biến thể";
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.variant_catelogue"),
            "name"=>"Quản lý danh mục biến thể",
        ]);  
        $data = $this->attribute->getAllAttribute();
    
         $breadcrumbs = $this->breadcrumbs;
        return view('backend.variant_catelogues.templates.index',compact('breadcrumbs',"title","data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Quản lý danh mục biến thể";
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.variant_catelogue"),
            "name"=>"Quản lý danh mục biến thể",
        ],[
            
                "active"=>true,
                "url"=> route("admin.variant_catelogue.create"),
                "name"=>"Thêm danh mục biến thể",
            
        ]);  
    
         $breadcrumbs = $this->breadcrumbs;
        return view("backend.variant_catelogues.templates.create",compact("title","breadcrumbs"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:App\Models\Attribute"
        ],[
            "name.required" => "Tên danh mục biến thể không được để trống",
            "name.unique" => "Có vẻ tên danh mục biến thể đã tồn tại"
        ]);
        if(  $this->attribute->create($request->only("name"))){
            return response()->json(["success","Thêm mới thành công"]);
        }
        else {
            return response()->json(["error","Thêm mới thất bại"]);
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
        $title = "Quản lý danh mục biến thể - Sửa danh mục biến thể";
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.variant_catelogue"),
            "name"=>"Quản lý danh mục biến thể",
        ],[
            
                "active"=>true,
                "url"=> route("admin.variant_catelogue.create"),
                "name"=>"Thêm Sửa danh mục biến thể",
            
        ]);  
        $data = $this->attribute->getAttributeId($id);
        $breadcrumbs = $this->breadcrumbs;
        return view("backend.variant_catelogues.templates.edit",compact("title","breadcrumbs","data","id"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name"=> ["required", Rule::unique("attributes")->ignore($id)]
        ],
        [
            "name.required" => "Tên danh mục biến thể không được để trống",
            "name.unique" => "Có vẻ tên danh mục biến thể đã tồn tại"
        ]);
        if(  $this->attribute->update($request->only("name"),$id)){
            return response()->json(["success","Cập nhật thành công"]);
        }
        else {
            return response()->json(["error","Cập nhật thất bại"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if(  $this->attribute->delete($request->id)){
            return response()->json(["success","Xóa thành công"]);
        }
        else {
            return response()->json(["error","Xóa thất bại"]);
        }
    }
}

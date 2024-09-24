<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Interfaces\AttributeValueServiceInterface as AttributeValueService;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $breadcrumbs = [];
    protected $attributevalue;
    public function __construct(AttributeValueService $attributevalue){
        $this->attributevalue = $attributevalue;  // Your implementation here
    }
    public function index()
    {
        $title = "Quản lý danh mục biến thể";
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.variant_catelogue"),
            "name"=>"Quản lý danh mục biến thể",
        ]);  
      
        $data = $this->attributevalue->getAllAttributeValue();
    
         $breadcrumbs = $this->breadcrumbs;
        return view('backend.variants.templates.index',compact('breadcrumbs',"title","data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Quản lý biến thể";
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.variant_catelogue"),
            "name"=>"Quản lý biến thể",
        ],[
            
                "active"=>true,
                "url"=> route("admin.variant_catelogue.create"),
                "name"=>"Thêm biến thể",
            
        ]);  
        $attributes = $this->attributevalue->getAttribute();
     
         $breadcrumbs = $this->breadcrumbs;
        return view("backend.variants.templates.create",compact("title","breadcrumbs","attributes"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:App\Models\AttributeValue",
            "attribute_id" => ["required"]
        ],  [
            "name.required" => "Giá trị của biến thể không được để trống",
            "name.unique" => "Có vẻ giá trị của biến thể đã tồn tại",
            "attribute_id.required" => "Vui lòng lựa chọn mục này"
        ]);
        if( $this->attributevalue->create($request->only(["name","attribute_id"]))){
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
    public function edit()
    {
        $id = request()->id;
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
        $data = $this->attributevalue->getAttributeValueId($id);
        $attributes = $this->attributevalue->getAttribute();
        $breadcrumbs = $this->breadcrumbs;
        return view("backend.variants.templates.edit",compact("title","attributes","breadcrumbs","data","id"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      
        $request->validate([
            "name"=> ["required", Rule::unique("attribute_values")->ignore($id)],
            "attribute_id" => ["required"]
        ],
        [
            "name.required" => "Giá trị của biến thể không được để trống",
            "name.unique" => "Có vẻ tên danh mục biến thể đã tồn tại",
            "attribute_id.required" => "Vui lòng lựa chọn mục này"
        ]);
        
        if( $this->attributevalue->update($request->only(["name","attribute_id"]),$id)){
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
        if(  $this->attributevalue->delete($request->id)){
            return response()->json(["success","Xóa thành công"]);
        }
        else {
            return response()->json(["error","Xóa thất bại"]);
        }
    }
}

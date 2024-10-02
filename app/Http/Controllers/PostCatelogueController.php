<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storepost_catelogueRequest;
use App\Http\Requests\Updatepost_catelogueRequest;
use App\Models\PostCatelogue;
use App\Services\Interfaces\PostCatelogueServiceInterface;
use App\Classes\NestedSetBuild;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class PostCatelogueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $breadcrumbs = [];
    private $postcatelogueService;
    protected $model = "null";

    public function __construct(PostCatelogueServiceInterface $post_catelogues , PostCatelogue $model)      
    {
        $this->postcatelogueService = $post_catelogues;
        $this->model = $model;
    }
    public function index()
    {
        $title = "Quản lý chuyên mục bài viết";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.post-catelogue"),
            "name"=>"Quản lý nhóm bài viết"
        ]); 
        $table_name = "Bảng quản lý chuyên mục bài viết";
        $post_catelogues = $this->postcatelogueService->getAllPosCatelogue();
        $breadcrumbs = $this->breadcrumbs;
        return  view("backend.posts.templates.post_catelogue.index",compact("breadcrumbs","title","table_name","post_catelogues"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm mới chuyên mục bài viết";
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.post-catelogue"),
            "name"=>"Quản lý nhóm bài viết"
        ],[
            "active"=>true,
            "url"=> route("admin.post-catelogue.create"),
            "name"=>"Thêm mới nhóm bài viết"
         ]);  
         $post_catelogues =$this->postcatelogueService->dropdownPostCatelogue();
     
         $breadcrumbs = $this->breadcrumbs;
         return  view("backend.posts.templates.post_catelogue.create",compact("breadcrumbs","title","post_catelogues"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storepost_catelogueRequest $request)
    {

        if($this->postcatelogueService->PostCatelogueStore($request)){
            return response()->json(["success","Thêm mới thành công"]);
           }
           else {
            return response()->json(["error","Thêm mới thất bại"]);
           }
    }
    public function PostCatelogueDelete(Request $request){
        DB::beginTransaction();
        try {
           
            $this->model->find($request->id)->delete();
            DB::commit();
            return response()->json(["success","Xoá thành công" ]);
        }
        catch(\Exception $e){
           DB::rollBack();
           return response()->json(["error","Xóa không thành công"]);
        }
     
    }
    public function editPostCatelogue(Request $request){
        $title = "Sửa chuyên mục bài viết";
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.post-catelogue"),
            "name"=>"Quản lý nhóm bài viết"
        ],[
            "active"=>true,
            "url"=> route("admin.post-catelogue.create"),
            "name"=>"Sửa nhóm bài viết"
         ]);  
         $breadcrumbs = $this->breadcrumbs;
         return $this->postcatelogueService->PostCatelogueEdit($request,$title,$breadcrumbs);
        }
    public function PostCatelogueUpdate(Updatepost_catelogueRequest $request){
        if($this->postcatelogueService->PostCatelogueUpdate($request)){
            return response()->json(["success","Cập nhật thành công"]);
           }
           else {
            return response()->json(["error","Cập nhật thất bại"]);
           }
    }
    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
   

    /**
     * Remove the specified resource from storage.
     */
   
}

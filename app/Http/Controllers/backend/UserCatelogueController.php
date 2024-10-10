<?php

namespace App\Http\Controllers\Backend;
use App\Services\Interfaces\UserCatelogueServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCatelogueRequest;
use App\Repositories\Interfaces\UserCatelogueRespositoryInterface;;
class UserCatelogueController extends Controller
{
    protected $userCatelogue;
    protected $userCatelogueModel;
    protected $breadcrumbs = [];
    public function __construct(UserCatelogueServiceInterface $userCatelogue,UserCatelogueRespositoryInterface $userCatelogueModel){
        $this->userCatelogue = $userCatelogue;
        $this->userCatelogueModel = $userCatelogueModel;
    }
    public function listGroupMember(){
       
        $title = "Quản lý nhóm thành viên";
         $this->breadcrumbs[] = [
            "active"=>true,
            "url"=> route("admin.users"),
            "name"=>"Quản lý nhóm thành viên"
         ];
         $table = "Danh sách nhóm thành viên";
        $breadcrumbs = $this->breadcrumbs;
        $data = $this->userCatelogue->getAll();
        $table = "user_catelogues";
       
       
        return  view("backend.user.templates.quanlynhomthanhvien.list",compact('data',"breadcrumbs","title","table"));
    }
    public function create(){
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.users"),
            "name"=>"Quản lý nhóm thành viên"
        ],[
            "active"=>true,
            "url"=> route("admin.user_catelogue.create"),
            "name"=>"Thêm nhóm thành viên"
         ]);   
         $title = "Quản lý nhóm thành viên";
         $breadcrumbs = $this->breadcrumbs;
        
        return view("backend.user.templates.quanlynhomthanhvien.create",compact("breadcrumbs","title"));
    }
    public function store(UserCatelogueRequest $request){
        $data = $request->except("_token");
       if($this->userCatelogue->create($data)){
        return response()->json(["success","Thêm mới thành công"]);
       }
       else {
        return response()->json(["errors","Thêm mới thất bại"]);
       }
    }
    public function edit($id){
        array_push($this->breadcrumbs,[
            "active"=>false,
            "url"=> route("admin.users"),
            "name"=>"Quản lý nhóm thành viên"
        ],[
            "active"=>true,
            "url"=> route("admin.user_catelogue.create"),
            "name"=>"Sửa nhóm thành viên"
         ]);   
         $title = "Quản lý nhóm thành viên - Sửa nhóm thành viên";
         $breadcrumbs = $this->breadcrumbs;
         $data = $this->userCatelogueModel->findUserCatelogueId($id);
    
         return view("backend.user.templates.quanlynhomthanhvien.edit", compact("breadcrumbs","title",'id','data'));
    }
    public function UserCatelogueUpdate(UserCatelogueRequest $request){
        $data = $request->only(["name","description"]);
        $id = $request->id;
        if($this->userCatelogue->update($data,$id)){
            return response()->json(["success","Sửa thành công"]);
        }
    }
    public function UserCatelogueDelete(){
        if($this->userCatelogue->deleteUserCatelogue(request()->id)){
                        return response()->json(["success","Thành công"]);
        }
    }

}

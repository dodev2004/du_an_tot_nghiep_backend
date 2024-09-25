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
        return response()->json(["success","Thêm mới thất bại"]);
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
    // public function editUser ($id){
    //     $title = "Quản lý thành viên";
    //     array_push($this->breadcrumbs,[
    //         "active"=>false,
    //         "url"=> route("admin.users"),
    //         "name"=>"Quản lý thành viên"
    //     ],[
    //         "active"=>true,
    //         "url"=> route("admin.users.edit",$id),
    //         "name"=>"Sửa thành viên"
    //      ]);
    //      $data = $this->users->getUserId($id);
    //      $breadcrumbs = $this->breadcrumbs;
    //      $provinces = $this->provinces->all();
    //      $districts = $this->provinces->findDistrictByIdProvince($data->province_id);
    //      $wards = $this->districts->findwardsByIdDistrict($data->district_id);
    //     return view("backend.user.templates.quanlythanhvien.edit",compact("breadcrumbs","title","data","provinces","districts","wards","id"));
    // }
    // public function updateUser(UpdateUserRequest $update){
    //     $data = request()->except(["_token","avatar"]);
    //     if($this->users->update($data,request()->id)){
    //         return response()->json(["success","Sửa thành công"]);
    //     }
    //     else {
    //         return response()->json(["error","Thêm mới không thành công"]);
    //     }
    // }
    // public function updateUserStatus(){
    //     $data = request()->except(["_token"]);
    //     $this->users->change_status($data["status"],$data["id"]);
    //     return response()->json(["success","okee"]);    
    // }
    // public function deleteUser(){
    //         if($this->users->delete(request()->id)){
    //             return response()->json(["success","thanhf conbg"]);
    //         }
    // }
}

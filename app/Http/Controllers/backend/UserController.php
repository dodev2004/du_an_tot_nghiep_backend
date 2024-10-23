<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictRepository;
use App\Repositories\Interfaces\WardRepositoryInterface as WardRepository;
// Validator
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;

class UserController extends Controller
{
    protected $users;
    protected $provinces, $districts, $wards;
    protected $breadcrumbs = [];
    public function __construct(UserService $users, ProvinceRepository $province, DistrictRepository $district, WardRepository $ward)
    {
        $this->users = $users;
        $this->provinces = $province;
        $this->districts = $district;
        $this->wards = $ward;
    }
    public function listGroupMember()
    {

        $title = "Quản lý thành viên";
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.users"),
            "name" => "Quản lý thành viên"
        ];
        $breadcrumbs = $this->breadcrumbs;

        $data = $this->users->getAllUsers(); // vẫn giữ nguyên như trước
        $data->load('roles'); // eager load mối quan hệ sau khi lấy dữ liệu
        $total = $data->count();
        $table = $data[0]->getTable();
        return  view("backend.user.templates.quanlythanhvien.list", compact('data', 'total', "breadcrumbs", "title", "table"));
    }
    public function create()
    {
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.users"),
            "name" => "Quản lý thành viên"
        ], [
            "active" => true,
            "url" => route("admin.users.create"),
            "name" => "Thêm thành viên"
        ]);
        $roles = Role::all();
        $provinces = $this->provinces->all();
        $title = "Quản lý thành viên";
        $breadcrumbs = $this->breadcrumbs;
        return view("backend.user.templates.quanlythanhvien.create", compact("breadcrumbs", "title", "provinces", "roles"));
    }
    public function store(StoreUserRequest $request)
    {
        $data = $request->except(["re-password", "_token", "avatar", "role_id"]);
        if ($this->users->create($data)) {
            return response()->json(["success", "Thêm mới thành công"]);
        } else {
            return response()->json(["error", "Thêm mới không thành công"]);
        }
    }
    public function editUser($id)
    {
        $title = "Quản lý thành viên";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.users"),
            "name" => "Quản lý thành viên"
        ], [
            "active" => true,
            "url" => route("admin.users.edit", $id),
            "name" => "Sửa thành viên"
        ]);
        $data = $this->users->getUserId($id);
        $roles = Role::all();
        $breadcrumbs = $this->breadcrumbs;
        $provinces = $this->provinces->all();
        $districts = $this->provinces->findDistrictByIdProvince($data->province_id);
        $wards = $this->districts->findwardsByIdDistrict($data->district_id);
        return view("backend.user.templates.quanlythanhvien.edit", compact("breadcrumbs", "title", "data", "provinces", "districts", "wards", "id", "roles"));
    }
    public function updateUser(UpdateUserRequest $update)
    {
        $data = request()->except(["_token", "avatar", "role_id"]);
        if ($this->users->update($data,request()->id)) {
            return response()->json(["success", "Sửa thành công"]);
        } else {
            return response()->json(["error", "Thêm mới không thành công"]);
        }
    }
    public function updateUserStatus()
    {
        $data = request()->except(["_token"]);
        $this->users->change_status($data["status"], $data["id"]);
        return response()->json(["success", "okee"]);
    }
    public function deleteUser()
    {
        if ($this->users->delete(request()->id)) {
            return response()->json(["success", "thanhf conbg"]);
        }
    }
}

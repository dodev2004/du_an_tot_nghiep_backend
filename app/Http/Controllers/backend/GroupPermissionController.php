<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use Illuminate\Http\Request;

class GroupPermissionController extends Controller
{
    protected $breadcrumbs = [];

    public function index()
    {
        $title = "Quản lý nhóm quyền";
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.group_permission"),
            "name" => "Quản lý nhóm quyền"
        ];

        $breadcrumbs = $this->breadcrumbs;
        $searchText = request()->input('seach_text');

        // Tạo truy vấn cho GroupPermission
        $query = GroupPermission::query();

        // Kiểm tra xem có tìm kiếm theo tên không
        if ($searchText) {
            $query->where('name', 'LIKE', '%' . $searchText . '%');
        }

        // Kiểm tra xem có truy vấn trash không
        if (request()->input('trash')) {
            $data = $query->onlyTrashed()->paginate(5);
            return view('backend.trash.trash_group_permission.templates.index', compact('breadcrumbs', "title", "data"));
        }

        // Nếu không có trash, lấy dữ liệu bình thường
        $data = $query->paginate(5);
        return view('backend.group_permissions.templates.index', compact('breadcrumbs', "title", "data"));
    }


    public function create()
    {
        $title = "Thêm nhóm quyền";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.group_permission"),
            "name" => "Quản lý nhóm quyền",
        ], [
            "active" => true,
            "url" => route("admin.group_permission.create"),
            "name" => "Thêm nhóm quyền",
        ]);

        $breadcrumbs = $this->breadcrumbs;
        return view("backend.group_permissions.templates.create", compact("title", "breadcrumbs"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:App\Models\GroupPermission",
            "description" => "required",
        ], [
            "name.required" => "Tên nhóm quyền không được để trống",
            "name.unique" => "Tên nhóm quyền đã tồn tại",
            "description.required" => "Miêu tả không được để trống",
        ]);

        if (GroupPermission::create($request->all())) {
            return response()->json(["success", "Thêm mới thành công"]);
        } else {
            return response()->json(["error", "Thêm mới thất bại"]);
        }
    }

    public function edit(string $id)
    {
        $title = "Sửa nhóm quyền";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.group_permission"),
            "name" => "Quản lý nhóm quyền",
        ], [
            "active" => true,
            "url" => route("admin.group_permission.edit", $id),
            "name" => "Sửa nhóm quyền",
        ]);

        $data = GroupPermission::find($id);
        $breadcrumbs = $this->breadcrumbs;
        return view("backend.group_permissions.templates.edit", compact("title", "breadcrumbs", "data", "id"));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required",
            "description" => "required",
        ], [
            "name.required" => "Tên nhóm quyền không được để trống",
            "description.required" => "Miêu tả không được để trống",
        ]);

        $groupPermission = GroupPermission::find($id);
        if ($groupPermission->update($request->all())) {
            return response()->json(["success", "Cập nhật thành công"]);
        } else {
            return response()->json(["error", "Cập nhật thất bại"]);
        }
    }

    public function destroy(Request $request)
    {
        $groupPermission = GroupPermission::find($request->id);
        if ($groupPermission->delete()) {
            return response()->json(["success", "Xóa thành công"]);
        } else {
            return response()->json(["error", "Xóa thất bại"]);
        }
    }

    public function force_destroy(Request $request)
    {
        $groupPermission = GroupPermission::onlyTrashed()->find($request->id);
        if ($groupPermission) {
            $groupPermission->forceDelete();
            return response()->json(["success" => "Xóa vĩnh viễn thành công"]);
        } else {
            return response()->json(["error" => "Bản ghi không tồn tại"]);
        }
    }

    public function restore($id)
    {
        $groupPermission = GroupPermission::onlyTrashed()->findOrFail($id);
        $groupPermission->restore();
        return redirect()->back()->with('success', 'Nhóm quyền đã được khôi phục thành công!');
    }

    public function trash()
    {
        $title = "Danh sách nhóm quyền đã xóa";
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.group_permission.trash"),
            "name" => "Danh sách nhóm quyền đã xóa"
        ]);

        $breadcrumbs = $this->breadcrumbs;
        $data = GroupPermission::onlyTrashed()->paginate(10);
        return view("backend.trash.trash_group_permission.templates.index", compact("title", "breadcrumbs", "data"));
    }
}

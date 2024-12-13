<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $breadcrumbs = [];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Quản lý quyền";
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.permission"),
            "name" => "Quản lý quyền"
        ];

        $breadcrumbs = $this->breadcrumbs;
        $table="permissions";
        // Tìm kiếm và lọc dữ liệu
        $query = Permission::with('groupPermission')->orderBy('group_permission_id', 'asc');

        // Kiểm tra nếu người dùng muốn xem các bản ghi đã bị xóa mềm


        if ($request->input('seach_text')) {
            $query->where('display_name', 'LIKE', '%' . $request->input('seach_text') . '%');
        }

        if ($request->input('group_permission_id')) {
            $query->where('group_permission_id', $request->input('group_permission_id'));
        }

        if ($request->input('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->input('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        if ($request->input('date_order') == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->input('date_order') == 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
        if (request()->input('status') !== null && request()->input('status') !== '') {
            $query->where('status', request()->input('status'));
        }
        // Lấy tất cả các nhóm quyền để hiển thị trong form tìm kiếm
        $groupPermissions = GroupPermission::all();

        if ($request->input('trash')) {
            if ($request->input('start_date')) {
                $query->whereDate('deleted_at', '>=', $request->input('start_date'));
            }

            if ($request->input('end_date')) {
                $query->whereDate('deleted_at', '<=', $request->input('end_date'));
            }
            $data = $query->onlyTrashed()->paginate(10);
            return view('backend.trash.trash_permission.templates.index', compact('breadcrumbs', "title", "data", "groupPermissions"));
        }

        $data = $query->paginate(10);

        return view('backend.permissions.templates.index', compact('breadcrumbs', "title", "data", "groupPermissions","table"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tạo breadcrumb cho trang thêm quyền
        $title = "Thêm quyền";
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.permission"),
            "name" => "Quản lý quyền"
        ], [

            "active" => true,
            "url" => route("admin.permission.create"),
            "name" => "Thêm quyền",

        ]);

        $breadcrumbs = $this->breadcrumbs;
        $groupPermissions = GroupPermission::all(); // Lấy danh sách nhóm quyền

        return view('backend.permissions.templates.create', compact('title', 'groupPermissions', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
            "description" => "required",
            "display_name" => "required|unique:permissions",
            'group_permission_id' => 'required|exists:group_permission,id',
        ], [
            'name.required' => 'Tên quyền không được để trống',
            'name.unique' => 'Tên quyền đã tồn tại',
            'display_name.required' => 'Tên hiển thị không được để trống',
            'display_name.unique' => 'Tên hiển thị đã tồn tại',
            'description.required' => 'Mô tả không được để trống',
            'group_permission_id.required' => 'Bạn phải chọn nhóm quyền',
            'group_permission_id.exists' => 'Nhóm quyền không tồn tại',
        ]);

        if (Permission::create($request->all())) {
            return response()->json(["success", "Thêm mới thành công"]);
        } else {
            return response()->json(["error", "Thêm mới thất bại"]);
        }
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Sửa quyền";
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.permission"),
            "name" => "Quản lý quyền"
        ], [

            "active" => true,
            "url" => route("admin.permission.edit", $id),
            "name" => "Sửa quyền",

        ]);

        $breadcrumbs = $this->breadcrumbs;
        $data = Permission::findOrFail($id);
        $groupPermissions = GroupPermission::all(); // Lấy danh sách nhóm quyền

        return view('backend.permissions.templates.edit', compact('title', 'data', 'groupPermissions', 'breadcrumbs','id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            "display_name" => "required",
            "description" => "required",
            'group_permission_id' => 'required|exists:group_permission,id',
        ], [

            'display_name.required' => 'Tên quyền không được để trống',
            'description.required' => 'Mô tả không được để trống',
            'group_permission_id.required' => 'Bạn phải chọn nhóm quyền',
            'group_permission_id.exists' => 'Nhóm quyền không tồn tại',
        ]);

        $permission = Permission::findOrFail($id);

        if ($permission->update($request->all())) {
            return response()->json(["success", "Cập nhật thành công"]);
        } else {
            return response()->json(["error", "Cập nhật thất bại"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $permission = Permission::findOrFail($request->id);
        if ($permission->delete()) {
            return response()->json(["success" => "Xóa thành công"]);
        } else {
            return response()->json(["error" => "Xóa thất bại"]);
        }
    }
    public function force_destroy(Request $request)
    {
        $permission = Permission::onlyTrashed()->find($request->id);
        if ($permission) {
            $permission->forceDelete();
            return response()->json(["success" => "Xóa vĩnh viễn thành công"]);
        } else {
            return response()->json(["error" => "Bản ghi không tồn tại"]);
        }
    }
    public function restore($id)
    {
        $permission = Permission::onlyTrashed()->findOrFail($id);
        $permission->restore();
        return redirect()->back()->with('success', 'Quyền đã được khôi phục thành công!');
    }
    public function trash()
    {
        $title = "Danh sách quyền đã xóa";

        // Tạo breadcrumb cho trang danh sách quyền đã xóa
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.permission.trash"),
            "name" => $title,
        ]);

        $breadcrumbs = $this->breadcrumbs;
        $groupPermissions = GroupPermission::all(); // Lấy danh sách nhóm quyền

        $data = Permission::with('groupPermission')->onlyTrashed()->paginate(10);
        return view("backend.trash.trash_permission.templates.index", compact("title", "breadcrumbs", "data", "groupPermissions"));
    }
}

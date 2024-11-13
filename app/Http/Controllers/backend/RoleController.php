<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $breadcrumbs = [];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Quản lý vai trò";
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.role"),
            "name" => "Quản lý vai trò"
        ];
        $query = Role::with('permissions')->orderBy('created_at', 'desc');

        // Kiểm tra nếu người dùng muốn xem các bản ghi đã bị xóa mềm
        if ($request->input('seach_text')) {
            $query->where('name', 'LIKE', '%' . $request->input('seach_text') . '%');
        }
        if (request()->input('status') !== null && request()->input('status') !== '') {
            $query->where('status', request()->input('status'));
        }
        $breadcrumbs = $this->breadcrumbs;
        $table = "roles";
        $totalPermissions = Permission::count();

        // Kiểm tra xem có yêu cầu trash không
        if (request()->input('trash')) {

            $roles = $query->onlyTrashed()->paginate(10); // Nếu có trash thì chỉ lấy dữ liệu đã xóa mềm
            return view('backend.trash.trash_role.templates.index', compact('breadcrumbs', "title", "roles","totalPermissions"));
        }

        $roles = $query->paginate(10); // Lấy danh sách vai trò và quyền liên kết
        return view('backend.roles.templates.index', compact('roles', 'title', 'breadcrumbs', "table", "totalPermissions"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm vai trò mới";
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.role"),
            "name" => "Quản lý vai trò"
        ], [

            "active" => true,
            "url" => route("admin.role.create"),
            "name" => "Thêm vai trò",

        ]);
        $breadcrumbs = $this->breadcrumbs;
        $groupPermissions = GroupPermission::with('permissions')->get();
        return view('backend.roles.templates.create', compact('title', 'groupPermissions', 'breadcrumbs'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'required|string|max:500',
            'permissions' => 'nullable|array', // Đảm bảo là một mảng
            'permissions.*' => 'required|exists:permissions,id', // Đảm bảo mỗi giá trị trong mảng tồn tại
        ], [
            'name.required' => 'Tên vai trò là bắt buộc.',
            'name.unique' => 'Tên vai trò đã tồn tại, vui lòng chọn tên khác.',
            'description.required' => 'Mô tả là bắt buộc.',
            'permissions.*.exists' => 'Một trong các quyền bạn chọn không hợp lệ.',
        ]);

        // Tạo vai trò mới
        // $role = Role::create(['name' => $request->input('name')]);
        $role = Role::create(['name' => $request->input('name'), 'description' => $request->input('description')]);
        // Gán quyền cho vai trò
        $role->permissions()->attach($request->input('permissions'));

        return response()->json(["success", "Thêm thành công"]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Sửa vai trò";
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.role"),
            "name" => "Quản lý vai trò"
        ], [

            "active" => true,
            "url" => route("admin.role.edit", $id),
            "name" => "Sửa vai trò",

        ]);
        $breadcrumbs = $this->breadcrumbs;
        $role = Role::with('permissions')->findOrFail($id);
        $groupPermissions = GroupPermission::with('permissions')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('backend.roles.templates.edit', compact('title', 'role', 'groupPermissions', 'rolePermissions', 'breadcrumbs', 'id'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'description' => 'required|',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'name.required' => 'Tên vai trò là bắt buộc.',
            'name.unique' => 'Tên vai trò đã tồn tại, vui lòng chọn tên khác.',
            'description.required' => 'Mô tả là bắt buộc.',
            'permissions.*.exists' => 'Một trong các quyền bạn chọn không hợp lệ.',
        ]);

        // Cập nhật tên vai trò
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->input('name'), 'description' => $request->input('description')]);
        $role->permissions()->sync($request->input('permissions'));
        // Đồng bộ quyền mới cho vai trò
        return response()->json(['success', 'Cập nhật vai trò và quyền thành công']);
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Request $request)
    {
        // Tìm vai trò theo ID
        $role = Role::findOrFail($request->id);

        // Bỏ liên kết với tất cả quyền trước khi xóa
        // $role->permissions()->detach();

        // Xóa vai trò
        if ($role->delete()) {
            return response()->json(["success" => "Vai trò đã được xóa thành công"]);
        } else {
            return response()->json(["error" => "Xóa vai trò thất bại"]);
        }
    }

    /**
     * Detach a permission from the role.
     */
    // public function detachPermission(Request $request, $roleId, $permissionId)
    // {
    //     $role = Role::findOrFail($roleId);
    //     $role->permissions()->detach($permissionId); // Xóa quyền khỏi vai trò
    //     return response()->json(['success' => 'Quyền đã được xóa khỏi vai trò thành công!']);
    // }
    public function force_destroy(Request $request)
    {
        $role = Role::onlyTrashed()->find($request->id); // Tìm vai trò đã xóa tạm thời
        $role->permissions()->detach();
        if ($role) {
            $role->forceDelete(); // Xóa vĩnh viễn vai trò
            return response()->json(["success" => "Xóa vĩnh viễn thành công"]);
        } else {
            return response()->json(["error" => "Bản ghi không tồn tại"]);
        }
    }
    public function restore($id)
    {
        $role = Role::onlyTrashed()->findOrFail($id); // Tìm vai trò đã xóa tạm thời
        $role->restore(); // Khôi phục vai trò
        return redirect()->back()->with('success', 'Vai trò đã được khôi phục thành công!');
    }
    public function trash()
    {
        $title = "Danh sách vai trò đã xóa";

        // Tạo breadcrumb cho trang danh sách vai trò đã xóa
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.role.trash"),
            "name" => $title,
        ]);

        $breadcrumbs = $this->breadcrumbs;
        $totalPermissions = Permission::count();
        $data = Role::with('permissions')->onlyTrashed()->paginate(10); // Lấy danh sách vai trò đã xóa
        return view("backend.trash.trash_role.templates.index", compact("title", "breadcrumbs", "data","totalPermissions"));
    }
}

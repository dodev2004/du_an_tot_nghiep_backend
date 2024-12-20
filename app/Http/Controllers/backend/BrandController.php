<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $breadcrumbs = [];

    public function index()
{
    $title = "Quản lý nhãn hàng";
    $this->breadcrumbs[] = [
        "active" => true,
        "url" => route("admin.brand"),
        "name" => "Quản lý nhãn hàng"
    ];
    $searchText = request()->input('seach_text');
    $status = request()->input('status');
    $startDate = request()->input('start_date');
    $endDate = request()->input('end_date');
    $dateOrder = request()->input('date_order');

    $breadcrumbs = $this->breadcrumbs;
    // Tạo truy vấn chung cho Brand
    $query = Brand::query()->orderBy('created_at', 'desc');
    $table="brands";
    // Thêm điều kiện tìm kiếm theo tên nhãn hàng
    if ($searchText) {
        $query->where('name', 'LIKE', '%' . $searchText . '%');
    }
    if ($status !== null && $status !== '') {
        $query->where('status', $status);
    }
    if ($startDate) {
        $query->where('created_at', '>=', $startDate);
    }
    if ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }
    if ($dateOrder === 'newest') {
        $query->orderBy('created_at', 'desc');
    } elseif ($dateOrder === 'oldest') {
        $query->orderBy('created_at', 'asc');
    }
    // Kiểm tra xem có yêu cầu trash không
    if (request()->input('trash')) {
        if ($startDate) {
            $query->where('deleted_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('deleted_at', '<=', $endDate);
        }
        $data=$query->onlyTrashed()->paginate(5); // Nếu có trash thì chỉ lấy dữ liệu đã xóa mềm
        return view('backend.trash.trash_brand.templates.index',compact('breadcrumbs', "title", "data"));
    }

    // Phân trang dữ liệu
    $data = $query->paginate(5);

    // Trả về view tương ứng
    return view('backend.brands.templates.index', compact('breadcrumbs', "title", "data","table"));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Quản lý nhãn hàng";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.brand"),
            "name" => "Quản lý nhãn hàng",
        ], [

            "active" => true,
            "url" => route("admin.brand.create"),
            "name" => "Thêm nhãn hàng",

        ]);


        $breadcrumbs = $this->breadcrumbs;
        return view("backend.brands.templates.create", compact("title", "breadcrumbs"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:App\Models\Brand",
            "description" => "required|",
        ], [
            "name.required" => "Tên nhãn hàng không được để trống",
            "name.unique" => "Có vẻ tên nhãn hàng đã tồn tại",
            "description.required" => "Miêu tả không được để trống",
        ]);

        if (Brand::create($request->all())) {
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
        $title = "Sửa nhãn hàng";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.brand"),
            "name" => "Quản lý nhãn hàng",
        ], [

            "active" => true,
            "url" => route("admin.brand.edit", $id),
            "name" => "Sửa nhãn hàng",

        ]);
        $data = Brand::query()->where("id", "=", $id)->first();

        $breadcrumbs = $this->breadcrumbs;
        return view("backend.brands.templates.edit", compact("title", "breadcrumbs", "data", "id"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate(
            [
                "name" => "required|",
                "description" => "required|",
            ],
            [
                "name.required" => "Tên nhãn hàng không được để trống",
                "description.required" => "Miêu tả không được để trống",
            ]
        );
        $brand = Brand::find($id);
        if ($brand->update($request->all())) {
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
        $brand = Brand::find($request->id);
        if ($brand->delete($request->id)) {
            return response()->json(["success", "Xóa thành công"]);
        } else {
            return response()->json(["error", "Xóa thất bại"]);
        }
    }
    public function force_destroy(Request $request)
    {
        // Tìm bản ghi đã bị xóa mềm bằng ID
        $brand = Brand::onlyTrashed()->find($request->id);

        // Kiểm tra nếu tồn tại và thực hiện xóa vĩnh viễn
        if ($brand) {
            $brand->forceDelete(); // Thực hiện xóa vĩnh viễn
            return response()->json(["success" => "Xóa vĩnh viễn thành công"]);
        } else {
            return response()->json(["error" => "Bản ghi không tồn tại"]);
        }
    }
    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore(); // Khôi phục bình luận

        return redirect()->back()->with('success', 'Nhãn hàng đã được khôi phục thành công!');
    }
    public function trash()
    {
        $title = "Danh sách nhãn hàng đã xóa";
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.brand.trash"),
            "name" => "Danh sách nhãn hàng đã xóa"
        ]);
        $breadcrumbs = $this->breadcrumbs;

        // Lấy các bình luận đã xóa mềm
        $data = Brand::onlyTrashed()->paginate(10);

        return view("backend.trash.trash_brand.templates.index", compact("title", "breadcrumbs", "data"));
    }
}

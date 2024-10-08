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
        $breadcrumbs = $this->breadcrumbs;
        $searchText = request()->input('seach_text');

        if ($searchText) {
            $data = Brand::where('name', 'LIKE', '%' . $searchText . '%')->get();
        } else {
            // Không có giá trị tìm kiếm
            $data = Brand::all();
        }

        return view('backend.brands.templates.index', compact('breadcrumbs', "title", "data"));
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
            "name.required" => "Tên danh mục biến thể không được để trống",
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
                "name.required" => "Tên danh mục biến thể không được để trống",
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
}

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Shipping_fee;
use Illuminate\Http\Request;

class ShippingFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $breadcrumbs = [];

    public function index()
    {
        $title = "Quản lý phí ship";
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.shipping_fee"),
            "name" => "Quản lý phí ship"
        ];
        $breadcrumbs = $this->breadcrumbs;
        $searchText = request()->input('seach_text');
        if (empty(request()->input('trash'))) {
        if ($searchText) {
            $data = Shipping_fee::with('province') // Eager load province
                ->whereHas('province', function ($query) use ($searchText) {
                    $query->where('name', 'LIKE', '%' . $searchText . '%');
                })
                ->paginate(10);
        } else {
            // Không có giá trị tìm kiếm
            $data = Shipping_fee::with('province')->paginate(10);
        }
        return view('backend.shipping_fees.templates.index', compact('breadcrumbs', "title", "data"));
    }else{
        if ($searchText) {
            $data = Shipping_fee::with('province')->onlyTrashed() // Eager load province
                ->whereHas('province', function ($query) use ($searchText) {
                    $query->where('name', 'LIKE', '%' . $searchText . '%');
                })
                ->paginate(10);
        } else {
            // Không có giá trị tìm kiếm
            $data = Shipping_fee::with('province')->onlyTrashed()->paginate(10);
        }
        return view('backend.trash.trash_shipping_fee.templates.index', compact('breadcrumbs', "title", "data"));
    }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Quản lý phí ship";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.shipping_fee"),
            "name" => "Quản lý phí ship",
        ], [

            "active" => true,
            "url" => route("admin.shipping_fee.create"),
            "name" => "Thêm phí ship",

        ]);


        $breadcrumbs = $this->breadcrumbs;
        $provinces = Province::all();
        return view("backend.shipping_fees.templates.create", compact("title", "breadcrumbs", "provinces"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "province_code" => "required|exists:provinces,code|unique:shipping_fees,province_code", // Đảm bảo thành phố chỉ được chọn một lần
            "fee" => "required|numeric|min:0", // Phí ship là số dương
            "weight_limit" => "required|numeric|min:0", // Trọng lượng tối đa là số dương
        ], [
            "province_code.required" => "Tên thành phố không được để trống",
            "province_code.exists" => "Tên thành phố không hợp lệ",
            "province_code.unique" => "Thành phố này đã được chọn, vui lòng chọn thành phố khác",
            "fee.required" => "Phí ship không được để trống",
            "fee.numeric" => "Phí ship phải là số",
            "fee.min" => "Phí ship phải lớn hơn hoặc bằng 0",
            "weight_limit.required" => "Trọng lượng tối đa không được để trống",
            "weight_limit.numeric" => "Trọng lượng tối đa phải là số",
            "weight_limit.min" => "Trọng lượng tối đa phải lớn hơn hoặc bằng 0",
        ]);
        if (Shipping_fee::create($request->all())) {
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
            "url" => route("admin.shipping_fee"),
            "name" => "Quản lý nhãn hàng",
        ], [

            "active" => true,
            "url" => route("admin.shipping_fee.edit", $id),
            "name" => "Sửa nhãn hàng",

        ]);
        $data = Shipping_fee::query()->where("id", "=", $id)->first();
        $provinces = Province::all();
        $breadcrumbs = $this->breadcrumbs;
        return view("backend.shipping_fees.templates.edit", compact("title", "breadcrumbs", "data", "id",'provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "province_code" => "required|exists:provinces,code|unique:shipping_fees,province_code", // Đảm bảo thành phố chỉ được chọn một lần
            "fee" => "required|numeric|min:0", // Phí ship là số dương
            "weight_limit" => "required|numeric|min:0", // Trọng lượng tối đa là số dương
        ], [
            "province_code.required" => "Tên thành phố không được để trống",
            "province_code.exists" => "Tên thành phố không hợp lệ",
            "province_code.unique" => "Thành phố này đã được chọn, vui lòng chọn thành phố khác",
            "fee.required" => "Phí ship không được để trống",
            "fee.numeric" => "Phí ship phải là số",
            "fee.min" => "Phí ship phải lớn hơn hoặc bằng 0",
            "weight_limit.required" => "Trọng lượng tối đa không được để trống",
            "weight_limit.numeric" => "Trọng lượng tối đa phải là số",
            "weight_limit.min" => "Trọng lượng tối đa phải lớn hơn hoặc bằng 0",
        ]);
        $shipping_fee = Shipping_fee::find($id);
        if ($shipping_fee->update($request->all())) {
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

        $shipping_fee = Shipping_fee::find($request->id);
        if ($shipping_fee->delete()) {
            return response()->json(["success", "Xóa thành công"]);
        } else {
            return response()->json(["error", "Xóa thất bại"]);
        }
    }
    public function force_destroy(Request $request)
    {
        // Tìm bản ghi đã bị xóa mềm bằng ID
        $shipping_fee = Shipping_fee::onlyTrashed()->find($request->id);

        // Kiểm tra nếu tồn tại và thực hiện xóa vĩnh viễn
        if ($shipping_fee) {
            $shipping_fee->forceDelete(); // Thực hiện xóa vĩnh viễn
            return response()->json(["success" => "Xóa vĩnh viễn thành công"]);
        } else {
            return response()->json(["error" => "Bản ghi không tồn tại"]);
        }
    }
    public function restore($id)
    {
        $shipping_fee = Shipping_fee::onlyTrashed()->findOrFail($id);
        $shipping_fee->restore(); // Khôi phục bình luận

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
        $data = Shipping_fee::with('province')->onlyTrashed()->paginate(10);

        return view("backend.trash.trash_shipping_fee.templates.index", compact("title", "breadcrumbs", "data"));
    }
}

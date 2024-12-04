<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $brand = Brand::query()->where('status',1)->paginate(5);
        if ($brand->isEmpty()) {
            return response()->json(['message' => 'không có nhãn hàng'], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Thông tin nhãn hàng',
            'data' =>   $brand,

        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($id)
    {
        // Lấy thông tin chi tiết một chương trình khuyến mãi
        $brand = Brand::where('status',1)->find($id);
        if (!$brand) {
            return response()->json(['message' => 'brand not found'], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Thông tin nhãn hàng',
            'data' => [
                 $brand,
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate dữ liệu từ form gửi lên
        $request->validate([
            "name" => "required|unique:App\Models\Brand",
            "description" => "required",
        ], [
            "name.required" => "Tên nhãn hàng không được để trống",
            "name.unique" => "Có vẻ tên nhãn hàng đã tồn tại",
            "description.required" => "Miêu tả không được để trống",
        ]);


        if (Brand::create($request->all())) {
            return response()->json(["status" => "success", "message" => "Thêm mới thành công"], 201);
        } else {

            return response()->json(["status" => "error", "message" => "Thêm mới thất bại"], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validate dữ liệu từ request
        $request->validate(
            [
                "name" => "required", // Trường 'name' phải có giá trị
                "description" => "required", // Trường 'description' phải có giá trị
            ],
            [
                "name.required" => "Tên nhãn hàng không được để trống", // Thông báo lỗi nếu 'name' để trống
                "description.required" => "Miêu tả không được để trống", // Thông báo lỗi nếu 'description' để trống
            ]
        );

        // 2. Tìm bản ghi Brand theo ID
        $brand = Brand::find($id);

        // 3. Kiểm tra và cập nhật dữ liệu cho bản ghi Brand
        if ($brand && $brand->update($request->all())) {
            return response()->json([
                "status" => "success",
                "message" => "Cập nhật thành công"
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Cập nhật thất bại"
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // 1. Tìm bản ghi Brand theo ID
        $brand = Brand::find($request->id);

        // 2. Kiểm tra và xóa bản ghi Brand
        if ($brand && $brand->delete()) {
            return response()->json([
                "status" => "success",
                "message" => "Xóa thành công"
            ], 200); // Mã 200 cho thành công
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Xóa thất bại"
            ], 500); // Mã 500 cho lỗi server
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Promotion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    
    public function index()
    {
        // Lấy danh sách tất cả sản phẩm
        $promotion = Promotion::all();
        return response()->json($promotion);
    }
    public function show($id)
    {
        // Lấy thông tin chi tiết một chương trình khuyến mãi
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['message' => 'Không có thông tin'], 404);
        }
        return response()->json($promotion);
    }
    public function store(Request $request)
    {
        // Tạo mới khuyến mãi
        $promotion = Promotion::create($request->all());
        return response()->json($promotion, 201);
    }
    public function update(Request $request, $id)
    {
        // Cập nhật khuyến mãi
        $promotion = Promotion::find($id);

        if ($promotion) {
            $promotion->update($request->all());
            return response()->json($promotion);
        } else {
            return response()->json(['message' => 'Không có thông tin'], 404);
        }
    }


    public function destroy($id)
    {
        // Xóa khuyễn mãi
        $promotion = Promotion::find($id);

        if ($promotion) {
            $promotion->delete();
            return response()->json(['message' => 'Xóa thành công']);
        } else {
            return response()->json(['message' => 'Không có thông tin'], 404);
        }
    }
    
    



}
<?php

namespace App\Http\Controllers\Api;

use App\Models\Promotion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    // public function usePromotion(Request $request)
    // {
    //     $request->validate([
    //         'code' => 'required|string',
    //     ]);
    //     $promotion = Promotion::where('code', $request->code)->first();

    //     if (!$promotion) {
    //         return response()->json(['message' => 'Mã giảm giá không tồn tại.'], 404);
    //     }

    //     // Kiểm tra ngày bắt đầu của mã giảm giá
    //     if (Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
    //         return response()->json(['message' => 'Mã giảm giá chưa đến ngày bắt đầu.'], 400);
    //     }

    //     // Kiểm tra ngày kết thúc của mã giảm giá
    //     if (Carbon::now()->gt(Carbon::parse($promotion->end_date))) {
    //         return response()->json(['message' => 'Mã giảm giá đã kết thúc.'], 400);
    //     }

    //     // Kiểm tra số lượng mã giảm giá
    //     if ($promotion->max_uses == 0) {
    //         return response()->json(['message' => 'Mã giảm giá đã hết.'], 400);
    //     }

    //     // Giảm số lượng mã giảm giá và tăng used_count
    //     $promotion->max_uses -= 1;
    //     $promotion->used_count += 1;
    //     $promotion->save();

    //     return response()->json(['message' => 'Sử dụng mã giảm giá thành công.', 'promotion' => $promotion], 200);
    // }  
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
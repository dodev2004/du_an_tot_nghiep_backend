<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping_fee;
use App\Models\Province;

class ShippingFeeController extends Controller
{
    public function ShippingFee(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'province_code' => 'required|string',
            'weight' => 'required|integer',
        ]);

        $provinceCode = $request->input('province_code');
        $weight = $request->input('weight');

        // Tìm tỉnh thành theo mã
        $province = Province::where('code', $provinceCode)->first();

        if (!$province) {
            return response()->json(['message' => 'Không tìm thấy tỉnh thành với mã này.'], 404);
        }

        // Tìm phí ship dựa trên mã tỉnh thành và trọng lượng
        $shippingFee = Shipping_fee::where('province_code', $provinceCode)
            ->where('weight_limit', '>=', $weight)
            ->where('status', true)
            ->orderBy('weight_limit', 'asc')
            ->first();

        if (!$shippingFee) {
            return response()->json(['message' => 'Không tìm thấy phí ship phù hợp.'], 404);
        }

        // Trả về phí ship
        return response()->json([
            'province' => $province->name,
            'shipping_fee' => $shippingFee->fee,
        ], 200);
    }
}
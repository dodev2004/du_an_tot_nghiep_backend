<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping_fee;
use App\Models\Province;

class ShippingFeeController extends Controller
{
    public function index()
    {
        // Lấy danh sách tất cả phí ship
        $shippingFees = Shipping_fee::with('province')->where('status',1)->get();
        return response()->json($shippingFees);
    }
}

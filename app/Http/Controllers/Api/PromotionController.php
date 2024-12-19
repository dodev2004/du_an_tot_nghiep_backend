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
        $promotion = Promotion::where('status', 'active')->get();
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

}
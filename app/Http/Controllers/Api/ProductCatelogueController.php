<?php 
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCatelogue;
use Illuminate\Http\JsonResponse;

class ProductCatelogueController extends Controller
{
    public function index(): JsonResponse
    {
        // Lấy tất cả các bản ghi trong product_catelogues mà không bao gồm cột lft và rgt
        $catalogues = ProductCatelogue::select([
            'id', 'name', 'slug', 'meta_description', 'meta_keywords', 
            'description', 'user_id', 'created_at', 'updated_at'
        ])->get();

        return response()->json($catalogues);
    }
}

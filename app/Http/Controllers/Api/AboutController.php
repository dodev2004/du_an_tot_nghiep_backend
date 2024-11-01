<?php

namespace App\Http\Controllers\Api;

use App\Models\AboutPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        // Lấy tất cả dữ liệu về trang giới thiệu
        $aboutPages = AboutPage::all(); // Hoặc có thể dùng `paginate()` để phân trang

        // Kiểm tra nếu có dữ liệu
        if ($aboutPages->isEmpty()) {
            return response()->json(['message' => 'Không có dữ liệu'], 404);
        }

        // Trả về dữ liệu JSON
        return response()->json($aboutPages);
    }
}

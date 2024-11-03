<?php

namespace App\Http\Controllers\Api;

use App\Models\AboutPage;
use App\Models\About;
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

    public function show($id)
    {
        // Lấy thông tin chi tiết một chương trình khuyến mãi
        $aboutPages = AboutPage::find($id);
        if (!$aboutPages) {
            return response()->json(['message' => 'Không có thông tin'], 404);
        }
        return response()->json($aboutPages);
    }
    public function store(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'status' => 'required|boolean',
        'image' => 'nullable|string',
    ]);

    // Tạo bản ghi mới
    $aboutPage = AboutPage::create($request->all());

    return response()->json($aboutPage, 201); 
}
public function update(Request $request, $id)
{
    $aboutPage = AboutPage::find($id);

    if (!$aboutPage) {
        return response()->json(['message' => 'Không tìm thấy dữ liệu'], 404);
    }

    $request->validate([
        'title' => 'sometimes|required|string|max:255',
        'content' => 'sometimes|required|string',
        'status' => 'sometimes|required|boolean',
        'image' => 'nullable|string',
    ]);

    $aboutPage->update($request->all());

    return response()->json($aboutPage);
}
public function destroy($id)
    {
        $aboutPage = AboutPage::find($id);

        if (!$aboutPage) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu'], 404);
        }

        $aboutPage->delete();

        return response()->json(['message' => 'Đã xóa thành công']);
    }

}

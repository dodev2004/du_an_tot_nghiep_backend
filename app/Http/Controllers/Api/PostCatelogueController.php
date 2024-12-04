<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Models\PostCatelogue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostCatelogueController extends Controller
{
    public function index()
    {
        // Lấy tất cả các danh mục
    $catelogues = PostCatelogue::with(['post' => function($query) {
        $query->where('status', 1);
    }])->where('status', 1);
        return response()->json($catelogues, Response::HTTP_OK);
    }
    public function store(Request $request)
    {
        // Tạo một danh mục mới
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'required|string|unique:post_catelogues,slug',
            'avatar' => 'nullable|string',
            'meta-description' => 'nullable|string',
            'meta-keywords' => 'nullable|string',
            'parent_id' => 'nullable|exists:post_catelogues,id'
        ]);
        // Xử lý file ảnh nếu có
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('uploads/post_catelogues', 'public'); // Lưu ảnh vào thư mục public/uploads/post_catelogues
            $data['avatar'] = $avatarPath; // Lưu đường dẫn vào mảng dữ liệu
        }

        $catelogue = PostCatelogue::create($data);

        return response()->json($catelogue, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        // Lấy thông tin chi tiết của danh mục
        $catelogue = PostCatelogue::with('post')->where('status',1)->find($id);
        if (!$catelogue) {
            return response()->json(['message' => 'Catelogue not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($catelogue, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        // Cập nhật thông tin danh mục
        $catelogue = PostCatelogue::find($id);
        if (!$catelogue) {
            return response()->json(['message' => 'Catelogue not found'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'sometimes|required|string|unique:post_catelogues,slug,' . $catelogue->id,
            'avatar' => 'nullable|string',
            'meta-description' => 'nullable|string',
            'meta-keywords' => 'nullable|string',
            'parent_id' => 'nullable|exists:post_catelogues,id'
        ]);
        // Xử lý file ảnh nếu có
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($catelogue->avatar && Storage::disk('public')->exists($catelogue->avatar)) {
                Storage::disk('public')->delete($catelogue->avatar);
            }

            // Lưu ảnh mới
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('uploads/post_catelogues', 'public'); // Lưu ảnh
            $data['avatar'] = $avatarPath; // Cập nhật đường dẫn ảnh vào dữ liệu
        }
        $catelogue->update($data);

        return response()->json($catelogue, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        // Xóa danh mục
        $catelogue = PostCatelogue::find($id);
        if (!$catelogue) {
            return response()->json(['message' => 'Catelogue not found'], Response::HTTP_NOT_FOUND);
        }
        // Xóa ảnh nếu có
        if ($catelogue->avatar && Storage::disk('public')->exists($catelogue->avatar)) {
            Storage::disk('public')->delete($catelogue->avatar);
        }

        $catelogue->delete();

        return response()->json(['message' => 'Catelogue deleted successfully'], Response::HTTP_OK);
    }
}

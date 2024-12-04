<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // Lấy tất cả các bài viết với phân trang
    $posts = Post::with(['catelogues' => function($query) {
        $query->where('status', 1); // Chỉ lấy các catelogues có status = 1
    }])->where('status', 1)->paginate(5);

return response()->json($posts, Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        // Tạo một bài viết mới
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra file ảnh
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'slug' => 'required|string|unique:posts,slug'
        ]);
        // Xử lý file ảnh
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('uploads/posts', 'public'); // Lưu file vào thư mục public/uploads/posts
            $validatedData['image'] = $imagePath; // Lưu đường dẫn vào mảng dữ liệu
        }

        $post = Post::create($data);

        return response()->json($post, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        // Lấy thông tin chi tiết của bài viết
        $post = Post::with('catelogues')->where('status', 1)->find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($post, Response::HTTP_OK);
    }

    public function relatedPosts($postId)
{
    // Lấy bài viết hiện tại
    $post = Post::with('catelogues')->find($postId);

    // Lấy danh sách các danh mục mà bài viết hiện tại thuộc về
    $catelogueIds = $post->catelogues->pluck('id')->toArray();

    // Lấy các bài viết khác thuộc các danh mục này
    $relatedPosts = Post::whereHas('catelogues', function ($query) use ($catelogueIds) {
        $query->whereIn('post_catelogues.id', $catelogueIds); // Lọc bài viết thuộc danh mục
    })
    ->where('id', '!=', $postId)  // Loại bỏ bài viết hiện tại
    ->get();

    return response()->json($relatedPosts, Response::HTTP_OK);
}

    public function update(Request $request, $id)
    {
        // Cập nhật thông tin bài viết
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra file ảnh
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'slug' => 'sometimes|required|string|unique:posts,slug,' . $post->id
        ]);
        // Xử lý file ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            // Lưu ảnh mới
            $image = $request->file('image');
            $imagePath = $image->store('uploads/posts', 'public');
            $validatedData['image'] = $imagePath;
        }
        $post->update($data);

        return response()->json($post, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        // Xóa bài viết
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }
        // Xóa ảnh nếu có
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], Response::HTTP_OK);
    }
}

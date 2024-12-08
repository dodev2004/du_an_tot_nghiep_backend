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
        $query->where('status', 1);
    }])->where('status', 1)->limit(4)->orderBy('id', 'desc')->get();
        return response()->json($posts, Response::HTTP_OK);
    }
    public function getPostByCatelogue($id){
    
        $posts = Post::with(["catelogues"])->whereHas('catelogues', function ($query) use ($id) {
            $query->where('post_catelogues.id', $id);
        })->get();
        return response()->json($posts, Response::HTTP_OK);
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

}

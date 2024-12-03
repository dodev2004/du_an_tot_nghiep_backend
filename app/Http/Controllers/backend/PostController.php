<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $breadcrumbs = [];
    private $post_service;
    /**
     * Display a listing of the resource.
     */
    public function __construct(PostServiceInterface $post)
    {
        $this->post_service = $post;
    }
    public function index()
    {
        $title = "Quản lý bài viết";
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.post"),
            "name" => "Quản lý bài viết"
        ]);
        $table = "posts";
        $breadcrumbs = $this->breadcrumbs;
        $data = $this->post_service->getAll();
        return view("backend.posts.templates.post.index", compact("title", "breadcrumbs", 'data', "table"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $title = "Quản lý bài viết";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.post"),
            "name" => "Quản lý bài viết"
        ], [
            "active" => true,
            "url" => route("admin.post.create"),
            "name" => "Thêm bài viết"
        ]);
        $breadcrumbs = $this->breadcrumbs;
        $post_catelogues = $this->post_service->dropdownPostCatelogue();

        return  view("backend.posts.templates.post.create", compact("breadcrumbs", "title", "post_catelogues"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        if ($this->post_service->PostStore($request)) {
            return response()->json(["success", "Thêm mới thành công"]);
        } else {
            return response()->json(["error", "Thêm mới bài viết thất bại"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function editPost(Request $request)
    {
        $title = "Quản lý bài viết";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.post"),
            "name" => "Quản lý bài viết"
        ], [
            "active" => true,
            "url" => route("admin.post.edit", $request->id),
            "name" => "Sửa bài viết"
        ]);
        $breadcrumbs = $this->breadcrumbs;
        $post = $this->post_service->getPostByPostId($request->id);
        $post_catelogues = $this->post_service->dropdownPostCatelogue("edit", $this->post_service->getCatelogueByPost()->toArray());

        return  view("backend.posts.templates.post.edit", compact("breadcrumbs", "title", "post", "post_catelogues"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request)
    {

        if ($this->post_service->PostUpdate($request)) {
            return response()->json(["success", "Cập nhật thành công"]);
        } else {
            return response()->json(["error", "Cập nhật bài viết thất bại"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ($this->post_service->PostCatelogueDelete($request)) {
            return response()->json(["success", "Xóa thành công"]);
        } else {
            return response()->json(["error", "Xóa bài viết thất bại"]);
        }
    }
}

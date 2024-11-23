<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BannerController extends Controller
{
    protected $breadcrumbs = [];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Quản lý banner";
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.brand"),
            "name" => "Quản lý banner"
        ];
        $searchText = request()->input('seach_text');
        $status = request()->input('status');

        $dateOrder = request()->input('date_order');

        $breadcrumbs = $this->breadcrumbs;
        // Tạo truy vấn chung cho Brand
        $query = Banner::query()->orderBy('created_at', 'desc');
        $table = "banners";
        // Thêm điều kiện tìm kiếm theo tên nhãn hàng
        if ($searchText) {
            $query->where('title', 'LIKE', '%' . $searchText . '%');
        }
        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        if ($dateOrder === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($dateOrder === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }

        // Phân trang dữ liệu
        $data = $query->paginate(5);

        // Trả về view tương ứng
        return view('backend.banners.templates.index', compact('breadcrumbs', "title", "data", "table"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Quản lý banner";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.banner"),
            "name" => "Quản lý banner",
        ], [

            "active" => true,
            "url" => route("admin.banner.create"),
            "name" => "Thêm banner",

        ]);


        $breadcrumbs = $this->breadcrumbs;
        return view("backend.banners.templates.create", compact("title", "breadcrumbs"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string|min:3|max:255",
            "content" => "required|string|min:10",
            "image" => "nullable|",
            "page" => [
            "required",
            Rule::in(['product', 'home','introduce']),
            Rule::unique('banners')->where(function ($query) use ($request) {
                return $query->where('page', $request->page);
            }),
        ],
        ], [
            "title.required" => "Tiêu đề không được để trống",
            "title.string" => "Tiêu đề phải là chuỗi",

            "title.min" => "Tiêu đề phải có ít nhất 3 ký tự",
            "title.max" => "Tiêu đề không được vượt quá 255 ký tự",

            "content.required" => "Nội dung không được để trống",
            "content.string" => "Nội dung phải là chuỗi",

            "content.min" => "Nội dung phải có ít nhất 10 ký tự",

            "page.required" => "Chọn trang cho banner",
            "page.in" => "Giá trị của trang không hợp lệ",
            "page.unique" => "Đã tồn tại banner cho trang này",
        ]);
        $request['content']=preg_replace('/<p>|<\/p>/', '', $request['content']);
        // Kiểm tra nếu banner đã tồn tại cho trang được chọn
        if (Banner::create($request->all())) {
            return response()->json(["success", "Thêm mới thành công"]);
        } else {
            return response()->json(["error", "Thêm mới thất bại"]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Sửa nhãn hàng";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.banner"),
            "name" => "Quản lý banner",
        ], [

            "active" => true,
            "url" => route("admin.banner.edit", $id),
            "name" => "Sửa banner",

        ]);
        $data = Banner::query()->where("id", "=", $id)->first();

        $breadcrumbs = $this->breadcrumbs;
        return view("backend.banners.templates.edit", compact("title", "breadcrumbs", "data", "id"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            "title" => "required|string|min:3|max:255",
            "content" => "required|string|min:10|",
            "image" => "nullable|",
            "page" => [
            "required",
            Rule::in(['product', 'home','introduce']),
            Rule::unique('banners')->where(function ($query) use ($request) {
                return $query->where('page', $request->page);
            }),
        ],
        ], [
            "title.required" => "Tiêu đề không được để trống",
            "title.string" => "Tiêu đề phải là chuỗi",

            "title.min" => "Tiêu đề phải có ít nhất 3 ký tự",
            "title.max" => "Tiêu đề không được vượt quá 255 ký tự",

            "content.required" => "Nội dung không được để trống",
            "content.string" => "Nội dung phải là chuỗi",

            "content.min" => "Nội dung phải có ít nhất 10 ký tự",

            "page.required" => "Chọn trang cho banner",
            "page.in" => "Giá trị của trang không hợp lệ",
            "page.unique" => "Đã tồn tại banner cho trang này",
        ]);
        $data['content']=preg_replace('/<p>|<\/p>/', '', $request['content']);

        $banner = Banner::find($id);
        if ($banner->update($data)) {
            return response()->json(["success", "Cập nhật thành công"]);
        } else {
            return response()->json(["error", "Cập nhật thất bại"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $banner = Banner::find($request->id);

        if ($banner->delete($request->id)) {
            return response()->json(["success", "Xóa thành công"]);
        } else {
            return response()->json(["error", "Xóa thất bại"]);
        }
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutPage; // Thêm model AboutPage
use Illuminate\Support\Facades\Log; // Thêm Log facade

use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    protected $breadcrumbs = [];
    public function index()
    {
        $title = "Quản lý trang giới thiệu";
        $data = AboutPage::paginate(10);
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.post"),
            "name" => "Quản lý trang giới thiệu"
        ]);

        $breadcrumbs = $this->breadcrumbs;
        return view("backend.about.templates.index", compact('breadcrumbs', 'title', 'data'));
    }
    public function create()
    {

        $title = "Quản lý trang giới thiệu";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.about"),
            "name" => "Quản lý trang giới thiệu"
        ], [
            "active" => true,
            "url" => route("admin.about.create"),
            "name" => "Thêm trang giới thiệu"
        ]);
        $breadcrumbs = $this->breadcrumbs;

        return  view("backend.about.templates.create", compact("breadcrumbs", "title"));
    }
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:hoạt động,không hoạt động',
        ], [
            'title.required' => 'Tiêu đề không được để trống.',
            'content.required' => 'Nội dung không được để trống.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);
        $aboutPage = AboutPage::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        if ($aboutPage) {
            return response()->json([
                'message' => 'Trang giới thiệu đã được thêm mới thành công!',
                'redirect' => route('admin.about')
            ], 200);
        } else {
            return response()->json([
                'message' => 'Đã có lỗi xảy ra trong quá trình thêm mới. Vui lòng thử lại.',
            ], 500);
        }
    }
    public function edit($id)
    {

        $aboutPage = AboutPage::find($id);
        if (!$aboutPage) {
            return redirect()->route('admin.about')->with('error', 'Không tìm thấy trang giới thiệu.');
        }

        $title = "Quản lý trang giới thiệu";
        array_push($this->breadcrumbs, [
            "active" => false,
            "url" => route("admin.about"),
            "name" => "Quản lý trang giới thiệu",
        ], [
            "active" => true,
            "url" => route("admin.about.create"),
            "name" => "Sửa trang giới thiệu",
        ]);
        $breadcrumbs = $this->breadcrumbs;
        return view('backend.about.templates.edit', compact('breadcrumbs', 'title', 'aboutPage'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:hoạt động,không hoạt động',
        ], [
            'title.required' => 'Tiêu đề không được để trống.',
            'content.required' => 'Nội dung không được để trống.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        $aboutPage = AboutPage::find($id);
        $aboutPage->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ]);


        return response()->json([
            'message' => 'Cập nhật thành công!',
            'redirect' => route('admin.about')
        ], 200);
    }
    public function destroy($id)

    {
        $aboutPage = AboutPage::findOrFail($id);
        
        if ($aboutPage) {
            $aboutPage->delete();
            return response()->json(['message' => 'Khuyến mãi đã được xóa thành công', 'status' => 'success'], 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy khuyến mãi', 'status' => 'error'], 404);
        }
    }
}



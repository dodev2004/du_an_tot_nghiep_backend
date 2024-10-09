<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ProductComment;
use App\Models\User;
use App\Services\ProductCommentService;
use Illuminate\Http\Request;

class ProductCommentController extends Controller
{
    protected $breadcrumbs = [];
    // Trang hiển thị danh sách bình luận
    public function index()
    {
        $title = "Danh sách người dùng có bình luận";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product_comment.users"),
            "name"=>"Danh sách người dùng có bình luận"
         ]);   
         $breadcrumbs = $this->breadcrumbs;
         $users = User::withCount('product_comments')->paginate(10);
         foreach ($users as $user) {
            $user->product_count = ProductComment::where('user_id', $user->id)
                ->distinct('product_id')
                ->count('product_id');
        }
         $data = ProductComment::with(['product', 'user'])->paginate(10);
         return view("backend.product_comment.templates.index",compact("title","breadcrumbs", "users","data",));
    }

    public function userComments(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $title = "Chi tiết người dùng bình luận";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product_comment.user_comments", ['id' => $id]),
            "name"=>"Chi tiết người dùng bình luận"
         ]); 
        $breadcrumbs = $this->breadcrumbs;

        // Khởi tạo truy vấn để lấy bình luận của người dùng
        $query = $users->product_comments();
        $searchText = $request->input('search_text');

    if ($searchText) {
        $query = ProductComment::where('comment', 'LIKE', '%' . $searchText . '%');
    }

    // Tìm kiếm theo ngày bắt đầu và ngày kết thúc
    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    // Lọc theo thứ tự ngày bình luận
    if ($request->has('date_order')) {
        if ($request->date_order == 'newest') {
            $query->orderBy('created_at', 'desc'); // Sắp xếp theo ngày mới nhất
        } elseif ($request->date_order == 'oldest') {
            $query->orderBy('created_at', 'asc'); // Sắp xếp theo ngày cũ nhất
        }
    }

    // Phân trang bình luận của người dùng
    $data = $query->paginate(10); 
    
        return view("backend.product_comment.templates.comment", compact( 'users','title', 'breadcrumbs', 'data'));
    }
    
    // Xóa cứng bình luận
    public function destroy($id)
    {
        $comment = ProductComment::findOrFail($id);
        $comment->delete(); // Xóa bình luận

        return response()->json('success', 'Bình luận đã được xóa thành công!');
    }

    // Xóa mềm bình luận
    public function softDelete($id)
    {
        $comment = ProductComment::findOrFail($id);
        $comment->delete(); // Xóa mềm bình luận

        return response()->json('success', 'Bình luận đã được xóa mềm thành công!');
    }

    // Khôi phục bình luận
    public function restore($id)
    {
        $comment = ProductComment::onlyTrashed()->findOrFail($id);
        $comment->restore(); // Khôi phục bình luận

        return redirect()->back()->with('success', 'Bình luận đã được khôi phục thành công!');
    }

    public function trash()
    {
        $title = "Danh sách bình luận đã xóa";
        array_push($this->breadcrumbs, [
            "active" => true,
            "url" => route("admin.product_comment.trash"),
            "name" => "Danh sách bình luận đã xóa"
        ]);
        $breadcrumbs = $this->breadcrumbs;

        // Lấy các bình luận đã xóa mềm
        $data = ProductComment::onlyTrashed()->with(['product', 'user'])->paginate(10);

        return view("backend.trash.trash_comment.templates.index", compact("title", "breadcrumbs", "data"));
    }
}

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

         $searchText = request()->get('search_text');
         $query = User::withCount('product_comments');

         if (!empty($searchText)) {
             $query->where('full_name', 'LIKE', value: '%' . $searchText . '%');
         }
         $users = $query->paginate(10);

         foreach ($users as $user) {
            $user->product_count = ProductComment::where('user_id', $user->id)
                ->distinct('product_id')
                ->count('product_id');
        }
         $data = ProductComment::with(['product', 'user'])->orderBy('created_at', 'desc')->paginate(10);
         return view("backend.product_comment.templates.index",compact("title","breadcrumbs", "users","data",));
    }

    public function userComments(Request $request, $id)
    {
        session(['user_id' => $id]);
        $users = User::findOrFail($id);
        $title = "Chi tiết người dùng bình luận";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product_comment.users"),
            "name"=>"Danh sách người dùng có bình luận"
        ],[
            "active"=>true,
            "url"=> route("admin.product_comment.user_comments", ['id' => $id]),
            "name"=>"Chi tiết người dùng bình luận"
 
        ]); 
        
        $breadcrumbs = $this->breadcrumbs;
        $query = ProductComment::where('user_id', $id);


    $searchText = $request->get('search_text');
    if (!empty($searchText)) {
        $query->where('comment', 'LIKE', '%' . $searchText . '%')
        ->orWhereHas('product', function ($q) use ($searchText) {
            $q->where('name', 'LIKE', '%' . $searchText . '%');
        })->where('user_id', $id);
    }


    $startDate = $request->get('start_date');
    $endDate = $request->get('end_date');

    if (!empty($startDate) && !empty($endDate)) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    } elseif (!empty($startDate)) {
        $query->where('created_at', '>=', $startDate);
    } elseif (!empty($endDate)) {
        $query->where('created_at', '<=', $endDate);
    }

    if ($request->has('date_order')) {
        if ($request->date_order == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->date_order == 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
    }

        $data = $query->orderBy('created_at', 'desc')->paginate(10); 
    
        return view("backend.product_comment.templates.comment", compact( 'users','title', 'breadcrumbs', 'data'));
    }
    

    public function destroy(Request $request)
    {
        $comment = ProductComment::onlyTrashed()->find($request->id);

        if ($comment) {
            $comment->forceDelete();
            return response()->json(["success" , "Bình luận đã được xóa vĩnh viễn"]);
        } else {
            return response()->json(["error" , "Không tìm thấy bình luận"]);
        }
    }

    public function softDelete(Request $request)
    {   
   
        $comment = ProductComment::findOrFail($request->id);

        if ($comment) {
            $comment->delete();
            return response()->json(["success" , "Bình luận đã được xóa thành công"]);
        } else {
            return response()->json(["error" , "Không tìm thấy bình luận"]);
        }
    }

    public function restore($id)
    {
        $comment = ProductComment::onlyTrashed()->findOrFail($id);
        $comment->restore();

        return redirect()->back()->with('success', 'Bình luận đã được khôi phục thành công!');
    }

    public function trash(Request $request)
    {
        $userId = session('user_id');
        $title = "Danh sách bình luận đã xóa";
        array_push($this->breadcrumbs, [
            "active"=>true,
            "url"=> route("admin.product_comment.users"),
            "name"=>"Danh sách người dùng có bình luận"
        ], [
            "active"=>true,
            "url"=> route("admin.product_comment.user_comments", ['id' => $userId]),
            "name"=>"Chi tiết người dùng bình luận"
        ], [
            "active" => true,
            "url" => route("admin.product_comment.trash"),
            "name" => "Danh sách bình luận đã xóa"
        ]);
        $breadcrumbs = $this->breadcrumbs;
        
        $query = ProductComment::onlyTrashed()->with(['product', 'user']);

        $searchText = $request->get('search_text');
    if (!empty($searchText)) {
        $query->where('comment', 'LIKE', '%' . $searchText . '%')
        ->orWhereHas('product', function ($q) use ($searchText) {
            $q->where('name', 'LIKE', '%' . $searchText . '%');
        })
        ->orWhereHas('user', function ($q) use ($searchText) {
            $q->where('full_name', 'LIKE', '%' . $searchText . '%');
        })->onlyTrashed();
    }


    $startDate = $request->get('start_date');
    $endDate = $request->get('end_date');

    if (!empty($startDate) && !empty($endDate)) {
        $query->onlyTrashed()->whereBetween('created_at', [$startDate, $endDate]);
    } elseif (!empty($startDate)) {
        $query->onlyTrashed()->where('created_at', '>=', $startDate);
    } elseif (!empty($endDate)) {
        $query->onlyTrashed()->where('created_at', '<=', $endDate);
    }

    if ($request->has('date_order')) {
        if ($request->date_order == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->date_order == 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
    }
        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view("backend.trash.trash_comment.templates.index", compact("title", "breadcrumbs", "data"));
    }
}

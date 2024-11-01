<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductReview;
use App\Models\User;
use App\Services\ProductCommentService;
use Illuminate\Http\Request;

class ProductCommentController extends Controller
{
    protected $breadcrumbs = [];
    // Trang hiển thị danh sách bình luận
    public function index()
    {
        $title = "Danh sách sản phẩm bình luận";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product_comment.users"),
            "name"=>"Danh sách sản phẩm có bình luận"
         ]);   
         $breadcrumbs = $this->breadcrumbs;

         $searchText = request()->get('search_text');
         $query = Product::has('product_comments')->withCount('product_comments');

         if (!empty($searchText)) {
             $query->where('name', 'LIKE', value: '%' . $searchText . '%')
                    ->orWhere('sku', 'LIKE', '%' . $searchText . '%');
         }

         $data = $query->paginate(10);
         return view("backend.product_comment.templates.index",compact("title","breadcrumbs","data",));
    }

    public function userComments(Request $request, $id)
    {
        session(['product_id' => $id]);
        $products = Product::findOrFail($id);
        $title = "Chi tiết sản phẩm có bình luận";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product_comment.users"),
            "name"=>"Danh sách sản phẩm có bình luận"
        ],[
            "active"=>true,
            "url"=> route("admin.product_comment.user_comments", ['id' => $id]),
            "name"=>"Chi tiết sản phẩm có bình luận"
 
        ]); 
        
        $breadcrumbs = $this->breadcrumbs;
        $query = ProductComment::with(['user', 'review.user'])->where('product_id', $id);


        $searchText = $request->get('search_text');
        if (!empty($searchText)) {
            $query->where('comment', 'LIKE', '%' . $searchText . '%')
            ->orWhereHas('user', function ($q) use ($searchText) {
                $q->where('username', 'LIKE', '%' . $searchText . '%')
                ->orWhere('full_name', 'LIKE', '%' . $searchText . '%');
            })->where('product_id', $id);
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
    
        return view("backend.product_comment.templates.comment", compact( 'products','title', 'breadcrumbs', 'data'));
    }
    
    public function create($id)
    {
        
        $reviews = ProductReview::with('product', 'user')->findOrFail($id);
        $title = "Phản hồi người dùng đánh giá";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product_review"),
            "name"=>"Danh sách sản phẩm đánh giá"
        ],[
            "active"=>true,
            "url"=> route("admin.product_review.user_reviews", ['id' => $reviews->product->id]),
            "name"=>"Chi tiết sản phẩm đánh giá"
 
        ],[
            "active"=>false,
            "url"=> route("product_comment.create",['id' => $id]),
            "name"=>"Phản hồi"
 
        ]); 
        $breadcrumbs = $this->breadcrumbs;

        return view('backend.product_review.templates.feedbackreview', compact('reviews','title','breadcrumbs'));
    }


    public function store(Request $request, $reviewId)
    {
        // Xác thực dữ liệu
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        // Tìm đánh giá theo ID
        $review = ProductReview::findOrFail($reviewId);

        // Tạo bình luận mới
        ProductComment::create([
            'product_id' => $review->product_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'review_id' => $reviewId,
        ]);

        // Quay về trang trước đó với thông báo thành công
        return redirect()->back()->with('success', 'Bình luận của bạn đã được thêm thành công!');
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
        $productId = session('product_id');
        $title = "Danh sách bình luận đã xóa";
        array_push($this->breadcrumbs, [
            "active"=>true,
            "url"=> route("admin.product_comment.users"),
            "name"=>"Danh sách người dùng có bình luận"
        ], [
            "active"=>true,
            "url"=> route("admin.product_comment.user_comments", ['id' => $productId]),
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
        })->onlyTrashed()
        ->orWhereHas('user', function ($q) use ($searchText) {
            $q->where('full_name', 'LIKE', '%' . $searchText . '%');
        })->onlyTrashed();
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

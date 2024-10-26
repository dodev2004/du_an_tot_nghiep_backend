<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    protected $breadcrumbs = [];
    public function index(Request $request)
    {
        $title = "Quản lý đánh giá";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product_review"),
            "name"=>"Quản lý đánh giá"
         ]); 
        $breadcrumbs = $this->breadcrumbs;

        $searchText = request()->get('search_text');
        $query = User::whereHas('product_reviews')
        ->withCount([
            'product_reviews as review_count', // Tổng số lượng đánh giá
            'product_reviews as product_count' => function ($query) {
                $query->select(DB::raw('COUNT(DISTINCT product_id)')); // Số lượng sản phẩm duy nhất
            }
        ]);
        if (!empty($searchText)) {
            $query->where('full_name', 'LIKE', value: '%' . $searchText . '%');
        }

        $users = $query->paginate(10);
        foreach ($users as $user) {
            $user->product_count = ProductReview::where('user_id', $user->id)
                ->distinct('product_id')
                ->count('product_id');
        }

        $data = ProductReview::with(['product', 'user'])->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.product_review.templates.index', compact("title", "breadcrumbs","users", "data"));
    }

    public function userReviews(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $title = "Chi tiết người dùng đánh giá";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product_review"),
            "name"=>"Danh sách người dùng có bình luận"
        ],[
            "active"=>true,
            "url"=> route("admin.product_review.user_reviews", ['id' => $id]),
            "name"=>"Chi tiết người dùng bình luận"
 
        ]); 
        
        $breadcrumbs = $this->breadcrumbs;
        $query = ProductReview::where('user_id', $id);


        $searchText = $request->get('search_text');
        if (!empty($searchText)) {
            $query->where('review', 'LIKE', '%' . $searchText . '%')
            ->orWhereHas('product', function ($q) use ($searchText) {
                $q->where('name', 'LIKE', '%' . $searchText . '%')
                ->orWhere('sku', 'LIKE', '%' . $searchText . '%');
            })->where('user_id', $id);
        }

        $ratingFilter = $request->get('rating');
        if (!empty($ratingFilter)) {
            $query->where('rating', $ratingFilter); // Lọc theo rating nếu có giá trị
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
    
        return view("backend.product_review.templates.review", compact( 'users','title', 'breadcrumbs', 'data'));
    }
}

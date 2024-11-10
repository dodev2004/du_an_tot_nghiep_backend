<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
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
            "name"=>"Danh sách sản phẩm đánh giá"
         ]); 
        $breadcrumbs = $this->breadcrumbs;

        $searchText = request()->get('search_text');
        $query = OrderItem::whereHas('product_reviews')->withCount('product_reviews as review_count');
        if (!empty($searchText)) {
            $query->where('name', 'LIKE', value: '%' . $searchText . '%')
                    ->orWhere('sku', 'LIKE', '%' . $searchText . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.product_review.templates.index', compact("title", "breadcrumbs","data"));
    }

    public function userReviews(Request $request, $id)
    {
        $products = OrderItem::findOrFail($id);
        $title = "Chi tiết người dùng đánh giá";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product_review"),
            "name"=>"Danh sách sản phẩm đánh giá"
        ],[
            "active"=>true,
            "url"=> route("admin.product_review.user_reviews", ['id' => $id]),
            "name"=>"Chi tiết sản phẩm đánh giá"
 
        ]); 
        
        $breadcrumbs = $this->breadcrumbs;
        $query = ProductReview::with(['order.user'])->where('product_id', $id);


        $searchText = $request->get('search_text');
        if (!empty($searchText)) {
            $query->where('review', 'LIKE', '%' . $searchText . '%')
            ->orWhereHas('user', function ($q) use ($searchText) {
                $q->where('username', 'LIKE', '%' . $searchText . '%')
                ->orWhere('full_name', 'LIKE', '%' . $searchText . '%');
            })->where('product_id', $id);
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
    
        return view("backend.product_review.templates.review", compact( 'products','title', 'breadcrumbs', 'data'));
    }
}

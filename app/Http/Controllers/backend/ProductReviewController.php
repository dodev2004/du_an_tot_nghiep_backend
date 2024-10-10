<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Http\Request;

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

        $query = User::withCount('product_reviews'); 
        // Tìm kiếm theo từ khóa (tên sản phẩm)
        if ($request->has('keywords') && $request->keywords != '') {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->keywords . '%');
            });
        }

        // Lọc theo ngày
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Sắp xếp theo mới nhất hoặc cũ nhất
        if ($request->has('date_order')) {
            if ($request->date_order == 'newest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->date_order == 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        }

        $data = $query->paginate(10);

        $reviews = ProductReview::with(['product', 'user'])->paginate(10);

        return view('backend.product_review.templates.index', compact("title", "breadcrumbs", "data",'reviews'));
    }
}

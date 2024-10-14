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

        $query = ProductReview::with(['product', 'user']);

    $searchText = $request->get('search_text');
    if (!empty($searchText)) {
        $query->where('review', 'LIKE', '%' . $searchText . '%')
        ->orWhereHas('product', function ($q) use ($searchText) {
            $q->where('name', 'LIKE', '%' . $searchText . '%');
        })
        ->orWhereHas('user', function ($q) use ($searchText) {
            $q->where('full_name', 'LIKE', '%' . $searchText . '%');
        });
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

        $data = $query->paginate(10);

        return view('backend.product_review.templates.index', compact("title", "breadcrumbs", "data"));
    }
}

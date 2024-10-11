<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $breadcrumbs = [];
    public function index()
    {
        $title = "Quản lý sản phẩm";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product"),
            "name"=>"Quản lý sản phẩm"
        ]);  
        $breadcrumbs = $this->breadcrumbs;
        $products = Product::query()->with(["users","variants","catelogues"])->paginate(15);
        foreach ($products as $product) {
            if ($product->variants->isNotEmpty()) {
                // Tồn kho tổng
                $product->display_stock = $product->variants->sum('stock');
    
                // Lấy giá thấp nhất và cao nhất từ các biến thể
                $minPrice = $product->variants->min('price');
                $maxPrice = $product->variants->max('price');
    
                // Kiểm tra giá giảm của biến thể
                $minDiscountPrice = $product->variants->whereNotNull('discount_price')->min('discount_price');
                $maxDiscountPrice = $product->variants->whereNotNull('discount_price')->max('discount_price');
    
                // Trường hợp có ít nhất một biến thể có giá giảm
                if ($minDiscountPrice && $maxDiscountPrice) {
                    $product->display_price = $minDiscountPrice == $maxDiscountPrice 
                        ? number_format($minDiscountPrice, 0, ',', '.') . 'đ' 
                        : "từ " . number_format($minDiscountPrice, 0, ',', '.') . "đ đến " . number_format($maxDiscountPrice, 0, ',', '.') . "đ";
                } else {
                    // Trường hợp không có giá giảm, hiển thị dải giá gốc
                    $product->display_price = $minPrice == $maxPrice 
                        ? number_format($minPrice, 0, ',', '.') . 'đ' 
                        : "từ " . number_format($minPrice, 0, ',', '.') . "đ đến " . number_format($maxPrice, 0, ',', '.') . "đ";
                }
            } else {
                // Trường hợp không có biến thể
                $product->display_stock = $product->stock;
                $product->display_price = $product->discount_price 
                    ? number_format($product->discount_price, 0, ',', '.') . 'đ' 
                    : number_format($product->price, 0, ',', '.') . 'đ';
            }
        }
   
        return view("backend.products.templates.index",compact("title","breadcrumbs","products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

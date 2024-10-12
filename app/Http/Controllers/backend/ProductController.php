<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Classes\NestedSetBuild;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $breadcrumbs = [];
    protected $nestedSetBuild = null;

    public function __construct(NestedSetBuild $nestedset) {
        $this->nestedSetBuild = $nestedset;
    }
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
                $product->display_stock = $product->variants->sum('stock');
                $minPrice = $product->variants->min('price');
                $maxPrice = $product->variants->max('price');
    
                $minDiscountPrice = $product->variants->whereNotNull('discount_price')->min('discount_price');
                $maxDiscountPrice = $product->variants->whereNotNull('discount_price')->max('discount_price');

                if ($minDiscountPrice && $maxDiscountPrice) {
                    $product->display_price = $minDiscountPrice == $maxDiscountPrice 
                        ? number_format($minDiscountPrice, 0, ',', '.') . 'đ' 
                        : "từ " . number_format($minDiscountPrice, 0, ',', '.') . "đ đến " . number_format($maxDiscountPrice, 0, ',', '.') . "đ";
                } else {
                    $product->display_price = $minPrice == $maxPrice 
                        ? number_format($minPrice, 0, ',', '.') . 'đ' 
                        : "từ " . number_format($minPrice, 0, ',', '.') . "đ đến " . number_format($maxPrice, 0, ',', '.') . "đ";
                }
            } else {
                $product->display_stock = $product->stock;
                $product->display_price = $product->discount_price 
                    ? number_format($product->discount_price, 0, ',', '.') . 'đ' 
                    : number_format($product->price, 0, ',', '.') . 'đ';
            }
            $product->catelogues = $product->catelogues->pluck('name')->toArray();

        }

        return view("backend.products.templates.index",compact("title","breadcrumbs","products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm mới sản phẩm";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product"),
            "name"=>"Quản lý sản phẩm"
        ],[
            "active"=>false,
            "url"=> route("admin.product.create"),
            "name"=>"Thêm mới sản phẩm"
 
        ]);  
        $product_catelogue =$this->dropdownPostCatelogue("create");
        $breadcrumbs = $this->breadcrumbs;
        $brands = Brand::all();
     return view("backend.products.templates.create",compact("title","breadcrumbs","product_catelogue","brands"));
    }
    public function dropdownPostCatelogue($target = "create"){
        $this->nestedSetBuild->_set("product_catelogues"); 
        return $this->nestedSetBuild->renderDropdownCreate($this->nestedSetBuild->Get($target),0,$target, $this->nestedSetBuild->Get(),"post_catelogue_id");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
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

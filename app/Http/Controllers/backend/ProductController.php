<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Classes\NestedSetBuild;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
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
    public function store(ProductRequest $request)
    {
        $data = $request->except("_token");
       
       DB::beginTransaction();

       try {
        $discountPercentage = (($request["price"] - $request["discount_price"]) / $request["price"]) * 100;
     
        $dataProduct = [
            'user_id' => trim($data['user_id']),
            'name' => trim($data['name']),
            'detailed_description' => trim($data['detailed_description']),
            'meta_keywords' => trim($data['meta_keywords']),
            'slug' => trim($data['slug']),
            'meta_description' => trim($data['meta_description']),
            'brand_id' => trim($data['brand_id_']),
            'sku' => trim($data['sku']),
            'price' => trim($data['price']),
            'discount_price' => trim($data['discount_price']),
            'stock' => trim($data['stock']),
            'weight' => trim($data['weight']),
            'image_url' => trim($data['image_url']),
            'discount_percentage' => round($discountPercentage, 2), 
            'is_active' => trim($data['is_active']),
        ];
        $product = Product::create($dataProduct);
        $galleries = explode(",",$data["gallery"]);
        foreach($galleries as $item){
            DB::table("galleries")->insert([
                "product_id" => $product->id,
                "image_url" => $item,
                "created_at" => date('Y-m-d H:i:s',time()),
                "updated_at" => date('Y-m-d H:i:s',time()),
            ]);
        }
        DB::commit();
       }
       catch (\Exception $e) {
           DB::rollBack();
           dd($e);
       }
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

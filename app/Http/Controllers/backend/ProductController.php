<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Classes\NestedSetBuild;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\ProductVariant;

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
    public function index(Request $request)
    {
        $title = "Quản lý sản phẩm";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product"),
            "name"=>"Quản lý sản phẩm"
        ]);  
        $breadcrumbs = $this->breadcrumbs;
        $products = Product::query()->with(["users", "variants", "catelogues"]);
  

        if($request->has("chuyen_muc") && $request->chuyen_muc){
           
            $products->whereHas('catelogues', function($query) use ($request) {
                $query->where('name', "LIKE", "%" . $request->chuyen_muc . "%");
            });
        }
        
        if($request->has("trang_thai")) {
            // Kiểm tra nếu trang_thai là 0 hoặc 1
       
            if ($request->trang_thai === '0' || $request->trang_thai === '1') {
           
                $products->where('status', $request->trang_thai);
            }
        }
        
        if($request->has("ngay_dang") && $request->ngay_dang){
            $date = urldecode($request->ngay_dang); 
            $products->whereDate('created_at', $date); 
        }
        
        if($request->has("ky_tu") && $request->ky_tu){
            $products->where('name', "LIKE", "%" . trim($request->ky_tu) . "%"); // Sử dụng giá trị từ request
        }
        
        $products = $products->paginate(15)->appends(request()->query());
        foreach ($products as $product) {
            if ($product->variants->isNotEmpty()) {
              
                $product->display_stock = $product->variants->sum('stock');
                $minPrice = $product->variants->min('price');
                $maxPrice = $product->variants->max('price');
                $minDiscountPrice = $product->variants->whereNotNull('discount_price')->min('discount_price');
                $maxDiscountPrice = $product->variants->whereNotNull('discount_price')->max('discount_price');
           
                if ($minDiscountPrice != 0.00 && $maxDiscountPrice != 0.00) {
                  if($product->id == 73){
           
                  }
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
        $table  = "products";
         // dd($products);
        return view("backend.products.templates.index",compact("title","breadcrumbs","products","table"));
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

    public function show($id)
    {

        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product"),
            "name"=>"Quản lý sản phẩm"
        ],[
            "active"=>false,
            "url"=> route("product.show", ['id' => $id]),
            "name"=>"Chi tiết sản phẩm"
 
        ]);  
        $breadcrumbs = $this->breadcrumbs;
        $product = Product::query()->with(['brand', 'catelogues', 'variants.attributeValues', 'galleries'])->findOrFail($id);
        $title = "Chi tiết sản phẩm: " . $product->name;
    
        // Tính giá hiển thị và tồn kho cho sản phẩm dựa trên các biến thể
        if ($product->variants->isNotEmpty()) {
            $product->display_stock = $product->variants->sum('stock');
            $variantNames = $product->variants->pluck('name')->unique()->toArray();
            $minPrice = $product->variants->min('price');
            $maxPrice = $product->variants->max('price');
            $minDiscountPrice = $product->variants->whereNotNull('discount_price')->min('discount_price');
            $maxDiscountPrice = $product->variants->whereNotNull('discount_price')->max('discount_price');
            
            $product->display_price = $minDiscountPrice != 0.00 && $maxDiscountPrice != 0.00
                ? "từ " . number_format($minDiscountPrice, 0, ',', '.') . "đ đến " . number_format($maxDiscountPrice, 0, ',', '.') . "đ"
                : ($minPrice == $maxPrice
                    ? number_format($minPrice, 0, ',', '.') . 'đ'
                    : "từ " . number_format($minPrice, 0, ',', '.') . "đ đến " . number_format($maxPrice, 0, ',', '.') . "đ");
        } else {
            $product->display_stock = $product->stock;
            $product->display_price = $product->discount_price 
                ? number_format($product->discount_price, 0, ',', '.') . 'đ'
                : number_format($product->price, 0, ',', '.') . 'đ';
        }
        $product->catelogues = $product->catelogues->pluck('name')->toArray();
        
        return view('backend.products.templates.detail', compact('breadcrumbs','product','title'));
    }


    public function dropdownPostCatelogue($target = "create"){
        $this->nestedSetBuild->_set("product_catelogues"); 
        return $this->nestedSetBuild->renderDropdownCreate($this->nestedSetBuild->Get($target),0,$target, $this->nestedSetBuild->Get(),"post_catelogue_id");
    }
    public function dropdownPostCatelogueEdit($target = "edit"){
        $this->nestedSetBuild->_set("product_catelogues"); 
        return $this->nestedSetBuild->renderDropdownCreate($this->nestedSetBuild->Get($target),0,$target, $this->getCatelogueById(request()->id)->toArray(),"post_catelogue_id");
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
            'user_id' => isset($data['user_id']) ? trim($data['user_id']) : null,
            'name' => isset($data['name']) ? trim($data['name']) : null,
            'detailed_description' => isset($data['detailed_description']) ? trim($data['detailed_description']) : null,
            'meta_keywords' => isset($data['meta_keywords']) ? trim($data['meta_keywords']) : null,
            'slug' => isset($data['slug']) ? trim($data['slug']) : null,
            'meta_description' => isset($data['meta_description']) ? trim($data['meta_description']) : null,
            'brand_id' => isset($data['brand_id']) ? trim($data['brand_id']) : null,
            'sku' => isset($data['sku']) ? trim($data['sku']) : null,
            'price' => isset($data['price']) ? trim($data['price']) : 0,
            'discount_price' => isset($data['discount_price']) ? trim($data['discount_price']) : 0,
            'stock' => isset($data['stock']) ? trim($data['stock']) : 0,
            'weight' => isset($data['weight']) ? trim($data['weight']) : 0,
            'image_url' => isset($data['image_url']) ? trim($data['image_url']) : null,
            'discount_percentage' => isset($discountPercentage) ? round($discountPercentage, 2) : 0,
            'status' => isset($data['status']) ? trim($data['status']) : 1,
        ];
        $product = Product::create($dataProduct);
      
        if(isset($data["catelogues"])){
            $catelogues = explode(",",$data["catelogues"]);

            foreach($catelogues as $item) {
                DB::table("product_product_catalogue")->insert([
                    "product_id" => $product->id,
                    "product_catelogue_id" => $item
                ]);
            }
        }

        if(isset($data["gallery"])){
            $galleries = explode(",",$data["gallery"]);
            foreach($galleries as $item){
                DB::table("galleries")->insert([
                    "product_id" => $product->id,
                    "image_url" => $item,
                    "created_at" => date('Y-m-d H:i:s',time()),
                    "updated_at" => date('Y-m-d H:i:s',time()),
                ]);
            }
        }
        
       
        if(isset($data["variants"])){
           $variants = json_decode($data["variants"]);
        
           foreach($variants  as $index => $item){
            $key = $index + 1;
            if($item->sku_variant == null){
                return response()->json([
                    'error_variant' => "Mã sản phẩm không được để trống biến thể số $key"
                ], 400);
            }
            if($item->price_variant == null){
                return response()->json([
                    'error_variant' => "Giá của sản phẩm không được để trống biến thể số $key"
                ], 400);
            }
            if($item->stock_variant == null){
                return response()->json([
                    'error_variant' => "Số lượng của sản phẩm không được để trống biến thể số $key"
                ], 400);
            }
                if (!is_numeric($item->price_variant)) {
                    return response()->json([
                        'error_variant' => "Giá của sản phẩm phải là số. Giá được nhập: {$item->price_variant} biến thể số $key "
                    ], 400);
                }
                
                if ( $item->stock_variant != null &&!is_numeric($item->stock_variant)) {
                    return response()->json([
                        'error_variant' => "Số lượng của sản phẩm phải là số. Số lượng được nhập: {$item->stock_variant} biến thể số $key "
                    ], 400);
                }
                 $product_variant= ProductVariant::create([
                    "product_id" => $product->id,
                     "price" => $item->price_variant ? $item->price_variant : 0,
                     "price" => $item->price_variant ? $item->price_variant : 0,
                     "image_url" =>$item->variant_image,
                     "discount_price" => $item->discount_price_variant ? $item->discount_price_variant : 0,
                     "stock" => $item->stock_variant ? $item->stock_variant : 0,
                     "sku" => $item->sku_variant ? $item->sku_variant : null,
                 ]);
                 $attributes = explode(",",$item->attribute);
                
                foreach($attributes as $item){
                    DB::table("variant_attribute_values")->insert([
                        "product_variant_id" => $product_variant->id,
                        "attribute_value_id" => $item
                    ]);
                }
            
           
           }
        }   
      
             DB::commit();
             return response()->json(["success" , "Thêm mới sản phẩm thành công"]);
       }
       catch (\Exception $e) {
           DB::rollBack();
         
           return response()->json(["error" , "Thêm mới sản phẩm không thành công"]);
       }
    }
    public function getCatelogueById($id){
        $query = Product::with("catelogues")->where("id","=",$id)->first();
       
        return $query->catelogues->pluck("id");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editPost(string $id)
    {
        
        $title = "Sửa sản phẩm";
        array_push($this->breadcrumbs,[
            "active"=>true,
            "url"=> route("admin.product"),
            "name"=>"Quản lý sản phẩm"
        ],[
            "active"=>false,
            "url"=> route("admin.product"),
            "name"=>"Sửa sản phẩm"
 
        ]);  
        
        $product_catelogue =$this->dropdownPostCatelogueEdit("edit");
        $breadcrumbs = $this->breadcrumbs;
        $brands = Brand::all();
 
        $product = Product::with("galleries","variants")->find($id);
        return view("backend.products.templates.edit",compact("title","product","breadcrumbs","product_catelogue","brands","id"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $data = $request->except("_token");
    
        DB::beginTransaction();
    
        try {
            // Tìm sản phẩm để cập nhật
            $product = Product::findOrFail($id);
    
            $discountPercentage = (($request["price"] - $request["discount_price"]) / $request["price"]) * 100;
    
            $dataProduct = [
                'user_id' => trim($data['user_id']),
                'name' => trim($data['name']),
                'detailed_description' => trim($data['detailed_description']),
                'meta_keywords' => trim($data['meta_keywords']),
                'slug' => trim($data['slug']),
                'meta_description' => trim($data['meta_description']),
                'brand_id' => trim($data['brand_id_']) ? trim($data['brand_id_']) : null,
                'sku' => trim($data['sku']),
                'price' => trim($data['price']),
                'discount_price' => trim($data['discount_price']),
                'stock' => trim($data['stock']),
                'weight' => trim($data['weight']),
                'image_url' => trim($data['image_url']),
                'discount_percentage' => round($discountPercentage, 2), 
                'status' => trim($data['status']),
            ];
            $product->update($dataProduct);
            DB::table("product_product_catalogue")->where('product_id', $product->id)->delete();
            if (isset($data["catelogues"])) {
                $catelogues = explode(",", $data["catelogues"]);
                foreach ($catelogues as $item) {
                    DB::table("product_product_catalogue")->insert([
                        "product_id" => $product->id,
                        "product_catelogue_id" => $item
                    ]);
                }
            }
            DB::table("galleries")->where('product_id', $product->id)->delete();
            if (isset($data["gallery"])) {
                $galleries = explode(",", $data["gallery"]);
                foreach ($galleries as $item) {
                    DB::table("galleries")->insert([
                        "product_id" => $product->id,
                        "image_url" => $item,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ]);
                }
            }
           
            if (isset($data["variants"])) {
                ProductVariant::where('product_id', $product->id)->delete();
               
                $variants = json_decode($data["variants"]);
                foreach ($variants  as $index => $item) {
                   
                    $skuExists = ProductVariant::where('sku', $item->sku_variant)->exists();
                    $key = $index + 1;
                    if($item->sku_variant == null){
                        return response()->json([
                            'error_variant' => "Mã sản phẩm không được để trống biến thể số $key"
                        ], 400);
                    }
                    if($item->price_variant == null){
                        return response()->json([
                            'error_variant' => "Giá của sản phẩm không được để trống biến thể số $key"
                        ], 400);
                    }
                   if($item->stock_variant == null){
                    return response()->json([
                        'error_variant' => "Số lượng của sản phẩm không được để trống biến thể số $key"
                    ], 400);
                   }
                    if (!is_numeric($item->price_variant)) {
                        return response()->json([
                            'error_variant' => "Giá của sản phẩm phải là số. Giá được nhập: {$item->price_variant}"
                        ], 400);
                    }
                    if (!is_numeric($item->discount_price_variant)) {
                        return response()->json([
                            'error_variant' => "Giá của sản phẩm phải là số. Giá được nhập: {$item->discount_price}"
                        ], 400);
                    }
                    if ($item->stock_variant != null && !is_numeric($item->stock_variant)) {
                        return response()->json([
                            'error_variant' => "Số lượng của sản phẩm phải là số. Số lượng được nhập: {$item->stock_variant}"
                        ], 400);
                    }
                    $product_variant = ProductVariant::create([
                        "product_id" => $product->id,
                        "price" => $item->price_variant ? $item->price_variant : 0,
                        "discount_price" => $item->discount_price_variant ? $item->discount_price_variant : 0,
                        "image_url" => $item->variant_image,
                        "stock" => $item->stock_variant ? $item->stock_variant : 0,
                        "sku" => $item->sku_variant,
                    ]);
    
                    $attributes = explode(",", $item->attribute);
    
                    foreach ($attributes as $attr_item) {
                        DB::table("variant_attribute_values")->insert([
                            "product_variant_id" => $product_variant->id,
                            "attribute_value_id" => $attr_item
                        ]);
                    }
                }
            }
    
            DB::commit();
            return response()->json(["success", "Cập nhật sản phẩm thành công"]);
        } catch (\Exception $e) {
            DB::rollBack();
           dd($e);
            return response()->json(["error", "Cập nhật sản phẩm không thành công"], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {   
        $id = request()->id;
        DB::beginTransaction();
    
        try {
            // Tìm sản phẩm theo ID
            $product = Product::findOrFail($id);
    
            // Xoá các catalogue liên quan đến sản phẩm
            DB::table('product_product_catalogue')->where('product_id', $product->id)->delete();
    
            // Xoá các galleries liên quan đến sản phẩm
            DB::table('galleries')->where('product_id', $product->id)->delete();
    
            // Xoá các variants liên quan đến sản phẩm
            $variants = ProductVariant::where('product_id', $product->id)->get();
            foreach ($variants as $variant) {
                // Xoá các variant_attribute_values liên quan đến từng variant
                DB::table('variant_attribute_values')->where('product_variant_id', $variant->id)->delete();
                // Xoá variant
                $variant->delete();
            }
    
            // Xoá sản phẩm
            $product->delete();
    
            DB::commit();
            return response()->json(["success", "Xoá sản phẩm thành công"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error", "Xoá sản phẩm không thành công"], 500);
        }
    }
}

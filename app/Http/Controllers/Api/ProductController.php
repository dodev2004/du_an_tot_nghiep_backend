<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách tất cả sản phẩm
    
        $products = Product::with('variants')->where("status",1)->get();
        return response()->json($products);
    }
    public function spNoiBat()
    {
    
        // Lấy danh sách tất cả sản phẩm
        $products = Product::with('variants')->where("is_featured",1)->limit(10)->get();
        return response()->json($products);
    }
    public function spLienQuan(Request $request){
     
        $products = Product::with([
            'catelogues',
            'variants' => function($query) {
                $query->select('id', 'product_id', 'price', 'discount_price', 'stock', 'weight', 'sku', 'image_url', 'created_at', 'updated_at');
            }
        ])->where("id","!=",$request->product_id)->whereHas('catelogues', function($query) use ($request) {
           
            $query->whereIn('product_catelogues.id', explode(",",$request->catelogues));
        })->limit(10)->get();

        return response()->json($products,200);
    }
    public function show($id)
    {
        // Lấy thông tin sản phẩm dựa trên ID
        $product = Product::with([
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'price', 'discount_price', 'stock', 'weight', 'sku', 'image_url', 'created_at', 'updated_at')
                    ->with([
                        'variantAttributeValues' => function ($query) {
                            $query->select('id', 'attribute_value_id', 'product_variant_id')
                                ->with([
                                    'attributeValue' => function ($query) {
                                        $query->select('id', 'name', 'attribute_id')
                                            ->with('attributes:id,name');
                                    }
                                ]);
                        }
                    ]);
            },
            'galleries:id,product_id,image_url',"catelogues"
        ])->findOrFail($id);
      
        // Tạo cấu trúc dữ liệu dễ hiểu hơn cho frontend
        $response = [
            'id' => $product->id,
            'catalogue_id' => $product->catelogues->map(function($catelogue){
                return $catelogue->id;
            })
               
            ,
            'brand_id' => $product->brand_id,
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'price' => $product->price,
            'stock' => $product->stock,
            'discount_price' => $product->discount_price,
            'detailed_description' => $product->detailed_description,
            'image_url' => $product->image_url,
            'variants' => $product->variants->map(function ($variant) {
                // Xử lý biến thể và các thuộc tính của biến thể
             
                return [
                    'id' => $variant->id,
                    'price' => $variant->price,
                    'discount_price' => $variant->discount_price,
                    'stock' => $variant->stock,
                    'weight' => $variant->weight,
                    'sku' => $variant->sku,
                    'image_url' => $variant->image_url,
                    'created_at' => $variant->created_at,
                    'updated_at' => $variant->updated_at,
                    'attributes' => $variant->variantAttributeValues->map(function ($attributeValue) {
                       
                        // Xử lý từng thuộc tính của biến thể
                        return [
                            'id' => $attributeValue->attributeValue->id,
                            'attribute' => $attributeValue->attributeValue->attributes->name,
                            'value' => $attributeValue->attributeValue->name,
                        ];
                    })
                ];
            }),
            'galleries' => $product->galleries->map(function ($gallery) {
                return [
                    'image_url' => $gallery->image_url,
                ];
            }),
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];
        
        // Trả về dữ liệu JSON
        return response()->json($response, 200);
    }
    public function showOne($id)
    {
        $product = Product::with(['variants' => function ($query) {
            $query->select('id', 'product_id', 'price', 'discount_price', 'stock', 'weight', 'sku', 'image_url', 'created_at', 'updated_at')
                ->with(['variantAttributeValues' => function ($query) {
                    $query->select('id', 'attribute_value_id', 'product_variant_id')
                        ->with(["attributeValue" => function ($query) {
                            $query->select('id', 'name', "attribute_id")
                                ->with(["attributes" => function ($query) {
                                    $query->select('id', 'name');
                                }]);
                        }]);
                }]);
        }, "galleries"])->findOrFail($id);
    
        // Xử lý thuộc tính sản phẩm
        $groupedAttributes = [];
        $attributeValuesList = [];
        $attributeIds = []; // Thêm mảng để lưu trữ attribute_id
     
        foreach ($product->variants as $variant) {
            foreach ($variant->variantAttributeValues as $index => $attributeValue) {
                $attributeName = $attributeValue->attributeValue->attributes->name;
                $attributeNameId= $attributeValue->attributeValue->attributes->id;
                $attributeValueId = $attributeValue->attribute_value_id;
                $attributeValueName = $attributeValue->attributeValue->name;
                
                // Nhóm thuộc tính
                if (!in_array($attributeValueId, $groupedAttributes)) {
                
                  
                    
                    $groupedAttributes[$attributeName][] = (string) $attributeValueId;
                }
                
               

                $attributeValuesList[] = [
                    'id' => $attributeValueId,
                    'name' => $attributeValueName
                ];
    
                // Lưu trữ attribute_id vào mảng
                if (!in_array($attributeNameId, $attributeIds)) {
                   
                    $attributeIds[] = $attributeNameId;
                }
            }
        }
       
        return response()->json([
            'id' => $product->id,
            'catalogue_id' => $product->catalogue_id,
            'brand_id' => $product->brand_id,
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'detailed_description' => $product->detailed_description,
            'image_url' => $product->image_url,
            'variants' => $product->variants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'price' => $variant->price,
                    'discount_price' => $variant->discount_price,
                    'discount_percentage' => $variant->discount_percentage,
                    'stock' => $variant->stock,
                    'weight' => $variant->weight,
                    'sku' => $variant->sku,
                    'image_url' => $variant->image_url,
                    'ratings_avg' => $variant->ratings_avg,
                    'ratings_count' => $variant->ratings_count,
                    'is_active' => $variant->is_active,
                    'is_featured' => $variant->is_featured,
                    'created_at' => $variant->created_at,
                    'updated_at' => $variant->updated_at,
                ];
            }),
            'attribute_values_list' => $attributeValuesList,
            'attributes' => $groupedAttributes,  // Trả về thuộc tính theo nhóm
            'attribute_id' => $attributeIds, // Trả về danh sách attribute_id
            'galleries' => $product->galleries->map(function ($gallery) {
                return [
                    'image_url' => $gallery->image_url,
                ];
            }),
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);
    }
    
    public function store(Request $request)
    {
        // Tạo mới sản phẩm
    }

    public function update(Request $request, $id)
    {
        // Cập nhật sản phẩm
        $product = Product::find($id);

        if ($product) {
            $product->update($request->all());
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function destroy($id)
    {
        // Xóa sản phẩm
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Product deleted']);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}

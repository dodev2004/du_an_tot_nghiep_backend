<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy danh sách tất cả sản phẩm
        $products = Product::all();
        return response()->json($products);
    }

    public function show($id)
    {
        // Lấy thông tin sản phẩm dựa trên ID
        $product = Product::with(['variants' => function ($query) {
            $query->select('id', 'product_id', 'price', 'discount_price', 'stock', 'weight', 'sku', 'image_url', 'created_at', 'updated_at')
                ->with([
                    'variantAttributeValues' => function ($query) {
                        $query->select('id', 'attribute_value_id', 'product_variant_id')
                            ->with(["attributeValue" => function ($query) {
                                $query->select('id', 'name', "attribute_id")
                                    ->with(["attributes"])
                                ;
                            }]);
                    }

                ]);
        }, "galleries"])->findOrFail($id);

        // Trả về thông tin sản phẩm cùng với biến thể
        return response()->json([
            'id' => $product->id,
            'catalogue_id' => $product->catalogue_id,
            'brand_id' => $product->brand_id,
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            "price" => $product->price,
            "stock" => $product->stock,
            "discount_price" => $product->discount_price,
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
                    'attributes' => $variant->variantAttributeValues,
                    // 'attributes_selected' => $variant->variantAttributeValues->map() // Lấy thuộc tính biến thể nếu cần
                ];
            }),
            'geleries' => $product->galleries->map(function ($gallery) {
                return [
                    "image_url" => $gallery->image_url,
                ];
            }),
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ], 200);
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
            foreach ($variant->variantAttributeValues as $attributeValue) {
                $attributeName = $attributeValue->attributeValue->attributes->name;
                $attributeNameId= $attributeValue->attributeValue->attributes->id;
                $attributeValueId = $attributeValue->attribute_value_id;
                $attributeValueName = $attributeValue->attributeValue->name;
                
                // Nhóm thuộc tính
                $groupedAttributes[$attributeName][] = (string) $attributeValueId;

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
        $product = Product::create($request->all());
        return response()->json($product, 201);
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

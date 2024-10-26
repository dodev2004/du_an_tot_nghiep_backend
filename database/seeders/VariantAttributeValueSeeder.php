<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantAttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('variant_attribute_values')->insert([
            [
                'product_variant_id' => 1, // Biến thể sản phẩm Sofa Vải Cao Cấp
                'attribute_value_id' => 2, // Vải Nhung
            ],
            [
                'product_variant_id' => 1,
                'attribute_value_id' => 3, // Màu Đen
            ],
            [
                'product_variant_id' => 2, // Biến thể sản phẩm Giường Gỗ Sồi
                'attribute_value_id' => 1, // Gỗ Sồi
            ],
            [
                'product_variant_id' => 2,
                'attribute_value_id' => 4, // Màu Xám
            ],
            [
                'product_variant_id' => 3, // Biến thể sản phẩm Tủ Quần Áo Gỗ Xoan Đào
                'attribute_value_id' => 5, // Kích thước 220x180 cm
            ],
            [
                'product_variant_id' => 3,
                'attribute_value_id' => 1, // Gỗ Xoan Đào (Giả định bạn đã thêm vào)
            ],
            [
                'product_variant_id' => 4, // Biến thể sản phẩm Bàn Trà Gỗ Óc Chó
                'attribute_value_id' => 1, // Gỗ Óc Chó
            ],
            [
                'product_variant_id' => 4,
                'attribute_value_id' => 6, // Kích thước 200x180 cm
            ],
            [
                'product_variant_id' => 5, // Biến thể sản phẩm Sofa Da Thật Sang Trọng
                'attribute_value_id' => 3, // Màu Đen
            ],
            [
                'product_variant_id' => 5,
                'attribute_value_id' => 1, // Da thật
            ],
            [
                'product_variant_id' => 6, // Biến thể sản phẩm Bàn Trang Điểm Gỗ Sồi
                'attribute_value_id' => 1, // Gỗ Sồi
            ],
            [
                'product_variant_id' => 6,
                'attribute_value_id' => 3, // Màu Đen
            ],
            [
                'product_variant_id' => 7, // Biến thể sản phẩm Kệ Tivi Gỗ Sồi
                'attribute_value_id' => 1, // Gỗ Sồi
            ],
            [
                'product_variant_id' => 7,
                'attribute_value_id' => 4, // Màu Xám
            ],
            
        ]);
    }
}

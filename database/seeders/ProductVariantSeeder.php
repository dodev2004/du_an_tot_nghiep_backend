<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_variants')->insert([
            [
                'product_id' => 1,
                'price' => 12000.00,
                'weight' => 20.00, // Thay dấu phẩy bằng dấu chấm
                'dimension' => '220x80x75 cm',
                'discount_price' => 12000.00,
                'stock' => 5,
                'sku' => 'SF001-RED',
                'image_url' => 'images/sofa-red.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 1,
                'price' => 18000.00,
                'weight' => 28.00, // Đảm bảo dấu thập phân là dấu chấm
                'dimension' => '200x180 cm',
                'discount_price' => 12000.00,
                'stock' => 10,
                'sku' => 'GN001-GS',
                'image_url' => 'images/giuong-go-soi.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm biến thể sản phẩm khác nếu cần
        ]);
        
    }
}

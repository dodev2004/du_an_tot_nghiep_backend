<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'price' => 90.00,
                'weight' => 1.2,
                'dimension' => '10x10x10',
                'stock' => 20,
                'sku' => 'SP001-VAR1',
                'image_url' => 'images/sample-product-variant-1.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm các biến thể sản phẩm khác nếu cần
        ]);
    }
}

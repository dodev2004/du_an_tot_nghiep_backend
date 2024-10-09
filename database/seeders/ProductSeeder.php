<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'catalogue_id' => 1,
                'brand_id' => 1,
                'name' => 'Sample Product 1',
                'slug' => 'sample-product-1',
                'sku' => 'SP001',
                'detailed_description' => 'This is a sample product.',
                'image_url' => 'images/sample-product-1.jpg',
                'price' => 100.00,
                'discount_price' => 90.00,
                'discount_percentage' => 10.00,
                'stock' => 50,
                'weight' => 1.5,
                'ratings_avg' => 4.5,
                'ratings_count' => 10,
                'is_active' => 1,
                'is_featured' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm các sản phẩm khác nếu cần
        ]);
    }
}

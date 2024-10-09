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
                'name' => 'Sofa Cao Cấp',
                'slug' => 'sofa-cao-cap',
                'sku' => 'SF001',
                'detailed_description' => 'Sofa cao cấp bọc da, phù hợp cho phòng khách hiện đại.',
                'image_url' => 'images/sofa-cao-cap.jpg',
                'price' => 15000.00,
                'discount_price' => 12000.00,
                'discount_percentage' => 20.00,
                'stock' => 10,
                'weight' => 25.0,
                'ratings_avg' => 4.7,
                'ratings_count' => 150,
                'is_active' => 1,
                'is_featured' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'catalogue_id' => 2,
                'brand_id' => 1,
                'name' => 'Giường Ngủ Gỗ Tự Nhiên',
                'slug' => 'giuong-ngu-go-tu-nhien',
                'sku' => 'GN001',
                'detailed_description' => 'Giường ngủ gỗ tự nhiên chắc chắn, thiết kế tinh tế.',
                'image_url' => 'images/giuong-ngu-go-tu-nhien.jpg',
                'price' => 20000.00,
                'discount_price' => 18000.00,
                'discount_percentage' => 10.00,
                'stock' => 15,
                'weight' => 30.0,
                'ratings_avg' => 4.9,
                'ratings_count' => 200,
                'is_active' => 1,
                'is_featured' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm các sản phẩm khác nếu cần
        ]);
    }
}

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
                'brand_id' => 3,
                'name' => 'Sơn Đẹp trai Cao Cấp',
                'slug' => 'son-dep-trai-cao-cap',
                'sku' => 'SO001',
                'detailed_description' => 'Sơn Đẹp trai bọc da, phù hợp cho phòng khách hiện đại.',
                'image_url' => 'images/sofa-cao-cap.jpg',
                'price' => 30000.00,
                'discount_price' => 10000.00,
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
                'brand_id' => 4,
                'name' => 'Sơn Đẹp trai Gỗ Tự Nhiên',
                'slug' => 'son-dep-trai-go-tu-nhien',
                'sku' => 'SON001',
                'detailed_description' => 'Sơn Đẹp trai gỗ tự nhiên chắc chắn, thiết kế tinh tế.',
                'image_url' => 'images/giuong-ngu-go-tu-nhien.jpg',
                'price' => 30000.00,
                'discount_price' => 10000.00,
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

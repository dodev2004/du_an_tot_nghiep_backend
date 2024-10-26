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
                'product_id' => 1, // Sofa Vải Cao Cấp
                'price' => 25000.00,
                'weight' => 20.0,
                'dimension' => '220x80x75 cm',
                'discount_price' => 22000.00,
                'stock' => 5,
                'sku' => 'SOF001-RED',
                'image_url' => 'images/sofa-red.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 2, // Giường Gỗ Sồi
                'price' => 35000.00,
                'weight' => 40.0,
                'dimension' => '200x160 cm',
                'discount_price' => 31500.00,
                'stock' => 3,
                'sku' => 'BED001-BROWN',
                'image_url' => 'images/giuong-go-soi-brown.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 3, // Tủ Quần Áo Gỗ Xoan Đào
                'price' => 30000.00,
                'weight' => 50.0,
                'dimension' => '120x200 cm',
                'discount_price' => 28000.00,
                'stock' => 4,
                'sku' => 'WARD001-NATURAL',
                'image_url' => 'images/tu-quan-ao-go-xoan-dao.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 4, // Bàn Trà Gỗ Óc Chó
                'price' => 15000.00,
                'weight' => 15.0,
                'dimension' => '100x60x40 cm',
                'discount_price' => 13500.00,
                'stock' => 6,
                'sku' => 'TABLE001-CHOCOLATE',
                'image_url' => 'images/ban-tra-go-oc-cho-chocolate.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 5, // Sofa Da Thật Sang Trọng
                'price' => 55000.00,
                'weight' => 30.0,
                'dimension' => '230x90x80 cm',
                'discount_price' => 50000.00,
                'stock' => 2,
                'sku' => 'SOF002-BLACK',
                'image_url' => 'images/sofa-da-that-sang-trong-black.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 6, // Bàn Trang Điểm Gỗ Sồi
                'price' => 18000.00,
                'weight' => 18.0,
                'dimension' => '80x40x75 cm',
                'discount_price' => 16200.00,
                'stock' => 5,
                'sku' => 'DRES001-WHITE',
                'image_url' => 'images/ban-trang-diem-go-soi-white.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 7, // Kệ Tivi Gỗ Sồi
                'price' => 20000.00,
                'weight' => 20.0,
                'dimension' => '120x40x50 cm',
                'discount_price' => 18000.00,
                'stock' => 4,
                'sku' => 'TVS001-GRAY',
                'image_url' => 'images/ke-tivi-go-soi-gray.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 8, // Tủ Quần Áo 4 Cánh
                'price' => 42000.00,
                'weight' => 55.0,
                'dimension' => '160x200 cm',
                'discount_price' => 38000.00,
                'stock' => 3,
                'sku' => 'WARD002-WHITE',
                'image_url' => 'images/tu-quan-ao-4-canh-white.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 9, // Bàn Làm Việc Gỗ Thông
                'price' => 25000.00,
                'weight' => 25.0,
                'dimension' => '120x60x75 cm',
                'discount_price' => 22500.00,
                'stock' => 6,
                'sku' => 'WKS001-NATURAL',
                'image_url' => 'images/ban-lam-viec-go-thong-natural.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 10, // Giường Ngủ Bằng Gỗ
                'price' => 34000.00,
                'weight' => 40.0,
                'dimension' => '200x160 cm',
                'discount_price' => 31000.00,
                'stock' => 5,
                'sku' => 'BED002-WHITE',
                'image_url' => 'images/giuong-ngu-bang-go-white.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 11, // Ghế Sofa Băng
                'price' => 32000.00,
                'weight' => 28.0,
                'dimension' => '180x75x75 cm',
                'discount_price' => 29000.00,
                'stock' => 3,
                'sku' => 'SOF003-BLUE',
                'image_url' => 'images/ghe-sofa-bang-blue.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'product_id' => 12, // Thêm một sản phẩm giả định
                'price' => 30000.00,
                'weight' => 35.0,
                'dimension' => '180x90x80 cm',
                'discount_price' => 27000.00,
                'stock' => 4,
                'sku' => 'SOF004-GREEN',
                'image_url' => 'images/sofa-green.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 13, // Thêm một sản phẩm giả định
                'price' => 40000.00,
                'weight' => 45.0,
                'dimension' => '200x140 cm',
                'discount_price' => 36000.00,
                'stock' => 3,
                'sku' => 'BED003-BLUE',
                'image_url' => 'images/giuong-ngoc-bien.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 14, // Thêm một sản phẩm giả định
                'price' => 28000.00,
                'weight' => 30.0,
                'dimension' => '150x70x90 cm',
                'discount_price' => 25000.00,
                'stock' => 5,
                'sku' => 'WARD003-MODERN',
                'image_url' => 'images/tu-quan-ao-modern.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 15, // Thêm một sản phẩm giả định
                'price' => 35000.00,
                'weight' => 60.0,
                'dimension' => '160x80x75 cm',
                'discount_price' => 33000.00,
                'stock' => 2,
                'sku' => 'TABLE002-OAK',
                'image_url' => 'images/ban-tra-oak.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
        ]);
        
    }
}

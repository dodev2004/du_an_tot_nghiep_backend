<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductProductCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_product_catalogue')->insert([
            
                [
                    'product_id' => 1, // Sofa Vải Cao Cấp
                    'product_catelogue_id' => 3, // Sofa
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'product_id' => 2, // Giường Gỗ Sồi
                    'product_catelogue_id' => 4, // Phòng Ngủ
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'product_id' => 3, // Tủ Quần Áo Gỗ Xoan Đào
                    'product_catelogue_id' => 4, // Phòng Ngủ
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'product_id' => 4, // Bàn Trà Gỗ Óc Chó
                    'product_catelogue_id' => 2, // Phòng Khách
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'product_id' => 5, // Sofa Da Thật Sang Trọng
                    'product_catelogue_id' => 3, // Sofa
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'product_id' => 6, // Bàn Trang Điểm Gỗ Sồi
                    'product_catelogue_id' => 4, // Phòng Ngủ
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'product_id' => 7, // Kệ Tivi Gỗ Sồi
                    'product_catelogue_id' => 2, // Phòng Khách
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'product_id' => 8, // Tủ Quần Áo 4 Cánh
                    'product_catelogue_id' => 4, // Phòng Ngủ
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'product_id' => 9, // Bàn Làm Việc Gỗ Thông
                    'product_catelogue_id' => 1, // Nội Thất
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'product_id' => 10, // Giường Ngủ Bằng Gỗ
                    'product_catelogue_id' => 4, // Phòng Ngủ
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
        ]);
    }
}

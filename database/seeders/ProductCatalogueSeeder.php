<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_catelogues')->insert([
            [
                'name' => 'Phòng Khách',
                'slug' => 'phong-khach',
                'image' => 'images/phong-khach.jpg',
                'meta_description' => 'Danh mục nội thất phòng khách',
                'meta_keywords' => 'sofa, bàn trà, tủ kệ phòng khách',
                '_ltf' => 1,
                '_rgt' => 2,
                'user_id' => 1,
                'parent_id' => NULL,
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Phòng Ngủ',
                'slug' => 'phong-ngu',
                'image' => 'images/phong-ngu.jpg',
                'meta_description' => 'Danh mục nội thất phòng ngủ',
                'meta_keywords' => 'giường, tủ quần áo, bàn trang điểm',
                '_ltf' => 3,
                '_rgt' => 4,
                'user_id' => 1,
                'parent_id' => NULL,
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm danh mục khác nếu cần
        ]);
    }
}

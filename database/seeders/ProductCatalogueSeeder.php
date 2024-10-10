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
                'name' => 'Nội Thất',
                'slug' => 'noi-that',
               
                'meta_description' => 'Danh mục nội thất tổng hợp',
                'meta_keywords' => 'nội thất, trang trí, nhà cửa',
              // Số con là 2
                'user_id' => 1,
                'parent_id' => NULL,
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Phòng Khách',
                'slug' => 'phong-khach',
              
                'meta_description' => 'Danh mục nội thất phòng khách',
                'meta_keywords' => 'sofa, bàn trà, tủ kệ phòng khách',
              
                'user_id' => 1,
                'parent_id' => 1, // Cha là Nội Thất
                'level' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sofa',
                'slug' => 'sofa',
            
                'meta_description' => 'Sofa hiện đại cho phòng khách',
                'meta_keywords' => 'sofa, nội thất',
               
                'user_id' => 1,
                'parent_id' => 2, // Cha là Phòng Khách
                'level' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Phòng Ngủ',
                'slug' => 'phong-ngu',
           
                'meta_description' => 'Danh mục nội thất phòng ngủ',
                'meta_keywords' => 'giường, tủ quần áo',
             
                'user_id' => 1,
                'parent_id' => 1, // Cha là Nội Thất
                'level' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm danh mục khác nếu cần
        ]);
    }
}

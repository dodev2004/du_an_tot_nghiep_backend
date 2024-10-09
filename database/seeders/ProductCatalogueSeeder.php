<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_catelogues')->insert([
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'image' => 'images/electronics.jpg',
                'meta_description' => 'Catalogue for electronic products',
                'meta_keywords' => 'electronics, gadgets, devices',
                '_ltf' => 1,
                '_rgt' => 2,
                'user_id' => 1,
                'parent_id' => NULL,
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mobile Phones',
                'slug' => 'mobile-phones',
                'image' => 'images/mobile-phones.jpg',
                'meta_description' => 'Catalogue for mobile phones',
                'meta_keywords' => 'phones, mobile, smartphones',
                '_ltf' => 3,
                '_rgt' => 4,
                'user_id' => 1,
                'parent_id' => 1,
                'level' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm các danh mục khác nếu cần
        ]);
    }
}

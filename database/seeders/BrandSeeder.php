<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("brands")->insert([
            'name' => 'IKEA',
            'description' => 'Thương hiệu nổi tiếng về nội thất và trang trí nhà cửa.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table("brands")->insert([
            'name' => 'Home Center',
            'description' => 'Nơi cung cấp các sản phẩm nội thất chất lượng cao.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table("brands")->insert([
            'name' => 'Ashley Furniture',
            'description' => 'Thương hiệu nội thất hàng đầu tại Mỹ.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table("brands")->insert([
            'name' => 'Muji',
            'description' => 'Thương hiệu Nhật Bản nổi tiếng với thiết kế đơn giản và chất lượng.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table("brands")->insert([
            'name' => 'Nitori',
            'description' => 'Thương hiệu nội thất nổi tiếng tại Nhật Bản.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'id'=>1,
                'title' => 'Lựa Chọn Sofa Cho Phòng Khách',
                'content' => 'Hướng dẫn chọn sofa cho phòng khách.',
                'slug' => 'lua-chon-sofa',
                'meta_description' => 'Lựa chọn sofa cho không gian phòng khách.',
                'meta_keywords' => 'sofa, phòng khách, nội thất',
                'user_id' => 1,
                'folow' => 1,
                'image' => 'http://127.0.0.1:8000/images/1tranquankhai-2-429_20221120110032-768x558.webp',
                'status' => 1,
                'avatar' => 'sofa-avatar.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'=>2,
                'title' => 'Giường Ngủ Cao Cấp',
                'content' => 'Cách chọn giường ngủ chất lượng.',
                'slug' => 'giuong-ngu-cao-cap',
                'meta_description' => 'Chọn giường ngủ cao cấp và phù hợp.',
                'meta_keywords' => 'giường ngủ, phòng ngủ, nội thất',
                'user_id' => 1,
                'folow' => 1,
                'image' => 'http://127.0.0.1:8000/images/1tranquankhai-2-429_20221120110032-768x558.webp',
                'status' => 1,
                'avatar' => 'giuongngu-avatar.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}

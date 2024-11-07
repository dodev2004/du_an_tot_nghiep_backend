<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCatelogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('post_catelogues')->insert([
            [
                'id'=>1,
                'name' => 'Đồ Nội Thất',
                'description' => 'Các loại đồ nội thất',
                'slug' => 'do-noi-that',
                'avatar' => 'http://127.0.0.1:8000/images/1tranquankhai-2-429_20221120110032-768x558.webp',
                'meta-title' => 'Đồ Nội Thất',
                'meta-description' => 'Chuyên mục về đồ nội thất',
                'meta_keywords' => 'furniture, nội thất',
                'user_id' => 1,
                '_lft' => 1,
                '_rgt' => 10,
                'parent_id' => null,
                'level' => 0,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'=>2,
                'name' => 'Phòng Khách',
                'description' => 'Đồ nội thất cho phòng khách',
                'slug' => 'phong-khach',
                'avatar' => 'http://127.0.0.1:8000/images/1tranquankhai-2-429_20221120110032-768x558.webp',
                'meta-title' => 'Nội Thất Phòng Khách',
                'meta-description' => 'Chuyên mục về nội thất phòng khách',
                'meta_keywords' => 'furniture, phòng khách',
                'user_id' => 1,
                '_lft' => 2,
                '_rgt' => 5,
                'parent_id' => 1,
                'level' => 1,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'=>3,
                'name' => 'Phòng Ngủ',
                'description' => 'Đồ nội thất cho phòng ngủ',
                'slug' => 'phong-ngu',
                'avatar' => 'phongngu.png',
                'meta-title' => 'Nội Thất Phòng Ngủ',
                'meta-description' => 'Chuyên mục về nội thất phòng ngủ',
                'meta_keywords' => 'furniture, phòng ngủ',
                'user_id' => 1,
                '_lft' => 6,
                '_rgt' => 9,
                'parent_id' => 1,
                'level' => 1,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}

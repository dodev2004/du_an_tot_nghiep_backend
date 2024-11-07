<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostPostCatelogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('post_post_catelogue')->insert([
            [
                'post_id' => 1, // ID của "Lựa Chọn Sofa Cho Phòng Khách"
                'post_catelogue_id' => 2, // ID của "Phòng Khách"
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'post_id' => 2, // ID của "Giường Ngủ Cao Cấp"
                'post_catelogue_id' => 3, // ID của "Phòng Ngủ"
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}

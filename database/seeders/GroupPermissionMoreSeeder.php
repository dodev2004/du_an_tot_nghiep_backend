<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupPermissionMoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['id'=>23,'name' => 'Quản lý bình luận', 'description' => 'Quản lý bình luận', 'created_at' => now()],
            ['id'=>24,'name' => 'Quản lý đánh giá', 'description' => 'Quản lý đánh giá', 'created_at' => now()],
            ['id'=>25,'name' => 'Quản lý banner', 'description' => 'Quản lý banner', 'created_at' => now()],

        ];

        DB::table('group_permission')->insert($permissions);
    }
}

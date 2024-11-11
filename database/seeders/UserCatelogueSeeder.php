<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCatelogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_catelogues')->insert([
            [
                'name' => 'Nhóm nhân viên kinh doanh',
                'description' => 'Nhóm chuyên về các hoạt động kinh doanh và bán hàng',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Nhóm nhân viên kỹ thuật',
                'description' => 'Nhóm chuyên về kỹ thuật và hỗ trợ kỹ thuật',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Nhóm nhân viên hỗ trợ khách hàng',
                'description' => 'Nhóm chuyên về hỗ trợ và chăm sóc khách hàng',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Nhóm nhân viên quản lý',
                'description' => 'Nhóm phụ trách các công việc quản lý và giám sát',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

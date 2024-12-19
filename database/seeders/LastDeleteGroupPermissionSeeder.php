<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LastDeleteGroupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Xóa các bản ghi trong bảng permissions có group_permission_id = 2
        DB::table('permissions')->where('group_permission_id', 2)->delete();
        DB::table('permissions')->where('name', 'showRole')->delete();

        // Xóa bản ghi có id = 2 trong bảng group_permission
        DB::table('group_permission')->where('id', 2)->delete();

        $this->command->info('Đã xoá các bản ghi liên quan trong bảng permissions và group_permission.');
    }
}

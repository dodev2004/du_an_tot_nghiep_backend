<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionLastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['id'=>171,'name' => 'forceDeleteCustomer', 'display_name' => 'Xóa vĩnh viễn tài khoản khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
            ['id'=>172,'name' => 'restoreCustomer', 'display_name' => 'Khôi phục tài khoản khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
            ['id'=>173,'name' => 'trashCustomer', 'display_name' => 'Xem thùng rác tài khoản khách hàng', 'description' => 'Quản lý khách hàng', 'group_permission_id' => 18, 'created_at' => now(), 'status' => 1],
        ];
        DB::table('permissions')->insert($permissions);

    }
}

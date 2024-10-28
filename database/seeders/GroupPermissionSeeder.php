<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['id'=>1,'name' => 'Quản lý nhân viên', 'description' => 'Quản lý nhân viên', 'created_at' => now()],
            ['id'=>2,'name' => 'Quản lý nhóm nhân viên', 'description' => 'Quản lý nhóm nhân viên', 'created_at' => now()],
            ['id'=>3,'name' => 'Quản lý danh mục bài viết', 'description' => 'Quản lý danh mục bài viết', 'created_at' => now()],
            ['id'=>4,'name' => 'Quản lý bài viết', 'description' => 'Quản lý bài viết', 'created_at' => now()],
            ['id'=>5,'name' => 'Quản lý sản phẩm', 'description' => 'Quản lý sản phẩm', 'created_at' => now()],
            ['id'=>6,'name' => 'Quản lý đơn hàng', 'description' => 'Quản lý đơn hàng', 'created_at' => now()],
            ['id'=>7,'name' => 'Quản lý danh mục sản phẩm', 'description' => 'Quản lý danh mục sản phẩm', 'created_at' => now()],
            ['id'=>8,'name' => 'Quản lý thuộc tính', 'description' => 'Quản lý thuộc tính', 'created_at' => now()],
            ['id'=>9,'name' => 'Quản lý giá trị thuộc tính', 'description' => 'Quản lý giá trị thuộc tính', 'created_at' => now()],
            ['id'=>10,'name' => 'Quản lý phương thức thanh toán', 'description' => 'Quản lý phương thức thanh toán', 'created_at' => now()],
            ['id'=>11,'name' => 'Quản lý khuyến mãi', 'description' => 'Quản lý khuyến mãi', 'created_at' => now()],
            ['id'=>12,'name' => 'Quản lý trang giới thiệu', 'description' => 'Quản lý trang giới thiệu', 'created_at' => now()],
            ['id'=>13,'name' => 'Quản lý đánh giá sản phẩm', 'description' => 'Quản lý đánh giá sản phẩm', 'created_at' => now()],
            ['id'=>14,'name' => 'Quản lý thương hiệu', 'description' => 'Quản lý thương hiệu', 'created_at' => now()],
            ['id'=>15,'name' => 'Quản lý liên hệ', 'description' => 'Quản lý liên hệ', 'created_at' => now()],
            ['id'=>16,'name' => 'Quản lý thông tin', 'description' => 'Quản lý thông tin', 'created_at' => now()],
            ['id'=>17,'name' => 'Quản lý phí vận chuyển', 'description' => 'Quản lý phí vận chuyển', 'created_at' => now()],
            ['id'=>18,'name' => 'Quản lý khách hàng', 'description' => 'Quản lý khách hàng', 'created_at' => now()],
            ['id'=>19,'name' => 'Quản lý nhóm quyền', 'description' => 'Quản lý nhóm quyền', 'created_at' => now()],
            ['id'=>20,'name' => 'Quản lý quyền', 'description' => 'Quản lý quyền', 'created_at' => now()],
            ['id'=>21,'name' => 'Quản lý vai trò', 'description' => 'Quản lý vai trò', 'created_at' => now()],
            ['id'=>22,'name' => 'Quản lý bảng điều khiển', 'description' => 'Quản lý bảng điều khiển, thống kê', 'created_at' => now()],
        ];





















        DB::table('group_permission')->insert($permissions);
    }
}

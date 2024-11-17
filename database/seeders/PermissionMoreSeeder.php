<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionMoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [


            ['id'=>151,'name' => 'viewComment', 'display_name' => 'Xem bình luận', 'description' => 'Quản lý bình luận', 'group_permission_id' => 23, 'created_at' => now(), 'status' => 1],
            ['id'=>152,'name' => 'viewUserComment', 'display_name' => 'Xem bình luận của theo người dùng', 'description' => 'Quản lý bình luận', 'group_permission_id' => 23, 'created_at' => now(), 'status' => 1],
            ['id'=>153,'name' => 'createComment', 'display_name' => 'Tạo bình luận', 'description' => 'Quản lý bình luận', 'group_permission_id' => 23, 'created_at' => now(), 'status' => 1],
            ['id'=>154,'name' => 'storeComment', 'display_name' => 'Lưu bình luận', 'description' => 'Quản lý bình luận', 'group_permission_id' => 23, 'created_at' => now(), 'status' => 1],
            ['id'=>155,'name' => 'deleteComment', 'display_name' => 'Xóa vai trò', 'description' => 'Quản lý bình luận', 'group_permission_id' => 23, 'created_at' => now(), 'status' => 1],
            ['id'=>156,'name' => 'forceDeleteComment', 'display_name' => 'Xóa vĩnh viễn bình luận', 'description' => 'Quản lý bình luận', 'group_permission_id' => 23, 'created_at' => now(), 'status' => 1],
            ['id'=>157,'name' => 'restoreComment', 'display_name' => 'Khôi phục bình luận', 'description' => 'Quản lý bình luận', 'group_permission_id' => 23, 'created_at' => now(), 'status' => 1],
            ['id'=>158,'name' => 'viewTrashComment', 'display_name' => 'Xem thùng rác bình luận', 'description' => 'Quản lý bình luận', 'group_permission_id' => 23, 'created_at' => now(), 'status' => 1],

            ['id'=>159,'name' => 'viewReview', 'display_name' => 'Xem đánh giá', 'description' => 'Quản lý xem đánh giá', 'group_permission_id' => 24, 'created_at' => now(), 'status' => 1],
            ['id'=>160,'name' => 'viewUserReview', 'display_name' => 'Xem đánh giá của theo người dùng', 'description' => 'Quản lý xem đánh giá theo người dùng', 'group_permission_id' => 24, 'created_at' => now(), 'status' => 1],

            ['id'=>161,'name' => 'viewBanner', 'display_name' => 'Xem banner', 'description' => 'Quyền xem banner', 'group_permission_id' => 25, 'created_at' => now(), 'status' => 1],
            ['id'=>162,'name' => 'createBanner', 'display_name' => 'Tạo banner', 'description' => 'Quyền tạo banner', 'group_permission_id' => 25, 'created_at' => now(), 'status' => 1],
            ['id'=>163,'name' => 'storeBanner', 'display_name' => 'Lưu banner', 'description' => 'Quyền lưu banner', 'group_permission_id' => 25, 'created_at' => now(), 'status' => 1],
            ['id'=>164,'name' => 'editBanner', 'display_name' => 'Chỉnh sửa banner', 'description' => 'Quyền chỉnh sửa banner', 'group_permission_id' => 25, 'created_at' => now(), 'status' => 1],
            ['id'=>165,'name' => 'updateBanner', 'display_name' => 'Cập nhật banner', 'description' => 'Quyền cập nhật banner', 'group_permission_id' => 25, 'created_at' => now(), 'status' => 1],
            ['id'=>166,'name' => 'deleteBanner', 'display_name' => 'Xóa banner', 'description' => 'Quyền xóa banner', 'group_permission_id' => 25, 'created_at' => now(), 'status' => 1],

            ['id'=>167,'name' => 'forceDeleteUser', 'display_name' => 'Xóa vĩnh viễn tài khoản', 'description' => 'Quản lý tài khoản', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],
            ['id'=>168,'name' => 'restoreUser', 'display_name' => 'Khôi phục tài khoản', 'description' => 'Quản lý tài khoản', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],
            ['id'=>169,'name' => 'viewTrashUser', 'display_name' => 'Xem thùng rác tài khoản', 'description' => 'Quản lý tài khoản', 'group_permission_id' => 1, 'created_at' => now(), 'status' => 1],

            ['id'=>170,'name' => 'viewProductDetail', 'display_name' => 'Xem chi tiết sản phẩm', 'description' => 'Quyền xem chi tiết sản phẩm', 'group_permission_id' => 5, 'created_at' => now(), 'status' => 1],
        ];
        DB::table('permissions')->insert($permissions);

    }
}

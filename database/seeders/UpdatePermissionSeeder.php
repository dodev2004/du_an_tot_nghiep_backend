<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsToUpdate = [
            ['name' => 'createComment', 'display_name' => 'Tạo phản hồi'],
            ['name' => 'storeComment', 'display_name' => 'Lưu phản hồi'],
            ['name' => 'deleteComment', 'display_name' => 'Xoá đánh giá','group_permission_id'=>24],
            ['name' => 'restoreComment', 'display_name' => 'Khôi phục đánh giá','group_permission_id'=>24],
            ['name' => 'forceDeleteComment', 'display_name' => 'Xóa vĩnh viễn đánh giá','group_permission_id'=>24],
            ['name' => 'viewTrashComment', 'display_name' => 'Xem thùng rác đánh giá','group_permission_id'=>24],

            ['name' => 'viewReview', 'display_name' => 'Xem đánh giá sản phẩm','group_permission_id'=>23],
            ['name' => 'viewUserReview', 'display_name' => 'Xem chi tiết đánh giá','group_permission_id'=>23],

            ['name' => 'viewComment', 'display_name' => 'Xem phản hồi đánh giá','group_permission_id'=>24],
            ['name' => 'viewUserComment', 'display_name' => 'Xem chi tiết phản hồi người dùng','group_permission_id'=>24],

        ];
        foreach ($permissionsToUpdate as $permission) {
            $updateData = [
                'display_name' => $permission['display_name'],
            ];

            // Kiểm tra nếu có group_permission_id thì thêm vào mảng update
            if (isset($permission['group_permission_id'])) {
                $updateData['group_permission_id'] = $permission['group_permission_id'];
            }

            // Cập nhật bản ghi dựa trên cột name
            DB::table('permissions')->where('name', $permission['name'])->update($updateData);
        }
    }
}


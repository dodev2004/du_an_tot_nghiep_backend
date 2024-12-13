<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LastUpdateGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dữ liệu cần cập nhật
        $permissions = [
            'deleteComment' => 'Xoá phản hồi đánh giá',
            'forceDeleteComment' => 'Xoá vĩnh viễn phản hồi đánh giá',
            'restoreComment' => 'Khôi phục phản hồi đánh giá',
            'viewTrashComment' => 'Xem thùng rác phản hồi đánh giá',
        ];

        // Sử dụng vòng lặp để cập nhật
        foreach ($permissions as $name => $displayName) {
            DB::table('permissions')->where('name', $name)->update([
                'display_name' => $displayName,
            ]);
        }
        DB::table('group_permission')->where('name', 'Quản lý phương thức thanh toán')->delete();
        $this->command->info('Success');

    }
}

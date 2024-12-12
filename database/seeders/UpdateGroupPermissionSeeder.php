<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateGroupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dữ liệu cần cập nhật
        $updates = [
            [
                'id' => 22,
                'name' => 'Quản lý thống kê',
                'description' => 'Quản lý bảng điều khiển, thống kê',
            ],
            [
                'id' => 24,
                'name' => 'Quản lý phản hồi đánh giá',
                'description' => 'Quản lý phản hồi đánh giá',
            ],
            [
                'id' => 23,
                'name' => 'Quản lý đánh giá',
                'description' => 'Quản lý đánh giá',
            ],


        ];

        foreach ($updates as $data) {
            DB::table('group_permission')
                ->where('id', $data['id'])
                ->update([
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]);
        }

        $this->command->info('Updated specified group permissions successfully.');
    }
}

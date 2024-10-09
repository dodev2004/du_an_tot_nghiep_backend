<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attribute_values')->insert([
            [
                'name' => 'Gỗ Sồi',
                'attribute_id' => 1, // Chất Liệu
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Vải Nhung',
                'attribute_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Màu Đen',
                'attribute_id' => 2, // Màu Sắc
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Màu Xám',
                'attribute_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '200x180 cm',
                'attribute_id' => 3, // Kích Thước
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '220x200 cm',
                'attribute_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm giá trị thuộc tính khác nếu cần
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attributes')->insert([
            [
                'name' => 'Chất Liệu',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Màu Sắc',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kích Thước',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Thêm các thuộc tính khác nếu cần
        ]);
    }
}

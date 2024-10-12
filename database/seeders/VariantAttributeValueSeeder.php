<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantAttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('variant_attribute_values')->insert([
            [
                'product_variant_id' => 3,
                'attribute_value_id' => 3, // Màu Đen
            ],
            [
                'product_variant_id' => 3,
                'attribute_value_id' => 1, // Gỗ Sồi
            ],
            // Thêm giá trị thuộc tính biến thể khác nếu cần
        ]);
    }
}

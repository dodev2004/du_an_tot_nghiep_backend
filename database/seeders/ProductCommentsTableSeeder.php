<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_comments')->insert([
            [
                'product_id' => 5, 
                'user_id' => 1, 
                'comment' => 'Sản phẩm này rất tuyệt vời! Tôi rất hài lòng với chất lượng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5, 
                'user_id' => 1, 
                'comment' => 'Giá cả hợp lý, giao hàng nhanh. Sẽ tiếp tục ủng hộ.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 6, 
                'user_id' => 1, 
                'comment' => 'Sản phẩm không tốt như mong đợi, cần cải thiện.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

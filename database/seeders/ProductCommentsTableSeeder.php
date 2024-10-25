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
                'product_id' => 15,
                'user_id' => 1,
                'comment' => 'Sản phẩm này có thiết kế đẹp, nhưng chất lượng chưa được tốt lắm.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 19,
                'user_id' => 2,
                'comment' => 'Sản phẩm này rất phù hợp với nhu cầu của tôi. Giao hàng cũng nhanh chóng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 20,
                'user_id' => 3,
                'comment' => 'Chất lượng sản phẩm trung bình. Dịch vụ giao hàng có thể cải thiện.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}

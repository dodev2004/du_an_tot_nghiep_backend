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
                'review_id' => rand(1, 15),
                'product_id' => 15, 
                'user_id' => 1, 
                'comment' => 'Sản phẩm này có thiết kế đẹp, nhưng chất lượng chưa được tốt lắm.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => rand(1, 15),
                'product_id' => 12, 
                'user_id' => 2, 
                'comment' => 'Sản phẩm này rất phù hợp với nhu cầu của tôi. Giao hàng cũng nhanh chóng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => rand(1, 15),
                'product_id' => 11, 
                'user_id' => 3, 
                'comment' => 'Chất lượng sản phẩm trung bình. Dịch vụ giao hàng có thể cải thiện.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => rand(1, 15),
                'product_id' => 3, 
                'user_id' => 1, 
                'comment' => 'Sản phẩm rất bền, đáng với số tiền đã bỏ ra. Tôi sẽ giới thiệu cho bạn bè.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => rand(1, 15),
                'product_id' => 4, 
                'user_id' => 2, 
                'comment' => 'Giá cả hợp lý, chất lượng tạm ổn. Tuy nhiên, đóng gói chưa thực sự cẩn thận.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => rand(1, 15),
                'product_id' => 5, 
                'user_id' => 3, 
                'comment' => 'Dịch vụ hỗ trợ sau bán hàng rất tốt, tôi rất hài lòng với cách giải quyết vấn đề.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => rand(1, 15),
                'product_id' => 12, 
                'user_id' => 1, 
                'comment' => 'Mẫu mã sản phẩm đẹp, nhưng cần cải thiện về độ bền.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => rand(1, 15),
                'product_id' => 14, 
                'user_id' => 2, 
                'comment' => 'Giao hàng đúng hẹn, sản phẩm chất lượng vượt mong đợi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => rand(1, 15),
                'product_id' => 1, 
                'user_id' => 3, 
                'comment' => 'Sản phẩm này không hoàn toàn đáp ứng nhu cầu của tôi, nhưng vẫn chấp nhận được.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => rand(1, 15),
                'product_id' => 15, 
                'user_id' => 1, 
                'comment' => 'Sản phẩm sử dụng rất tốt, nhưng giá hơi cao.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}

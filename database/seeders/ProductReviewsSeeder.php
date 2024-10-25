<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_reviews')->insert([

                [
                    'product_id' => 6,
                    'user_id' => 1,
                    'rating' => 5,
                    'review' => 'Sản phẩm tuyệt vời! Tôi rất hài lòng với chất lượng.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 6,
                    'user_id' => 2,
                    'rating' => 4,
                    'review' => 'Chất lượng tốt, tuy nhiên giá hơi cao.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 6,
                    'user_id' => 3,
                    'rating' => 3,
                    'review' => 'Sản phẩm đạt yêu cầu, nhưng có thể cải thiện hơn nữa.',
                    'created_at' => now(),
                ],
            
                // Đánh giá cho product_id = 7
                [
                    'product_id' => 7,
                    'user_id' => 1,
                    'rating' => 5,
                    'review' => 'Tuyệt vời! Sản phẩm đúng như mong đợi và giá cả phải chăng.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 7,
                    'user_id' => 2,
                    'rating' => 5,
                    'review' => 'Sản phẩm tuyệt vời! Tôi rất hài lòng với chất lượng và giá cả.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 7,
                    'user_id' => 3,
                    'rating' => 4,
                    'review' => 'Sản phẩm này có giá tốt và chất lượng ổn định. Tôi sẽ mua lại.',
                    'created_at' => now(),
                ],
            
                // Đánh giá cho product_id = 12
                [
                    'product_id' => 12,
                    'user_id' => 1,
                    'rating' => 4,
                    'review' => 'Chất lượng tốt, nhưng không như tôi mong đợi.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 12,
                    'user_id' => 2,
                    'rating' => 3,
                    'review' => 'Sản phẩm ổn, nhưng cần cải thiện về thiết kế.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 12,
                    'user_id' => 3,
                    'rating' => 2,
                    'review' => 'Không ấn tượng với sản phẩm này.',
                    'created_at' => now(),
                ],
            
                // Đánh giá cho product_id = 13
                [
                    'product_id' => 13,
                    'user_id' => 1,
                    'rating' => 5,
                    'review' => 'Sản phẩm rất tốt, đáng tiền!',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 13,
                    'user_id' => 2,
                    'rating' => 4,
                    'review' => 'Tôi rất hài lòng với sản phẩm này.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 13,
                    'user_id' => 3,
                    'rating' => 4,
                    'review' => 'Sản phẩm tốt nhưng cần cải thiện một vài chi tiết.',
                    'created_at' => now(),
                ],
            
                // Đánh giá cho product_id = 15
                [
                    'product_id' => 15,
                    'user_id' => 1,
                    'rating' => 3,
                    'review' => 'Sản phẩm tạm được, không có gì đặc biệt.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 15,
                    'user_id' => 2,
                    'rating' => 2,
                    'review' => 'Không thực sự hài lòng với sản phẩm này.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 15,
                    'user_id' => 3,
                    'rating' => 1,
                    'review' => 'Không khuyến nghị sản phẩm này.',
                    'created_at' => now(),
                ],
            
                // Đánh giá cho product_id = 19
                [
                    'product_id' => 19,
                    'user_id' => 1,
                    'rating' => 5,
                    'review' => 'Sản phẩm tuyệt vời! Đáng giá từng xu.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 19,
                    'user_id' => 2,
                    'rating' => 4,
                    'review' => 'Chất lượng ổn, sẽ mua thêm.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 19,
                    'user_id' => 3,
                    'rating' => 3,
                    'review' => 'Sản phẩm bình thường, không có gì nổi bật.',
                    'created_at' => now(),
                ],
            
                // Đánh giá cho product_id = 20
                [
                    'product_id' => 20,
                    'user_id' => 1,
                    'rating' => 5,
                    'review' => 'Sản phẩm rất tốt và dễ sử dụng.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 20,
                    'user_id' => 2,
                    'rating' => 4,
                    'review' => 'Tôi hài lòng với sản phẩm này.',
                    'created_at' => now(),
                ],
                [
                    'product_id' => 20,
                    'user_id' => 3,
                    'rating' => 3,
                    'review' => 'Sản phẩm sử dụng tốt nhưng giá hơi cao.',
                    'created_at' => now(),
                ],            
        ]);
    }
}

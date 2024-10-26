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
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Sản phẩm tuyệt vời! Tôi rất hài lòng với chất lượng.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Chất lượng tốt, tuy nhiên giá hơi cao.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 3,
                'review' => 'Sản phẩm đạt yêu cầu, nhưng có thể cải thiện hơn nữa.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Tuyệt vời! Sản phẩm đúng như mong đợi và giá cả phải chăng.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 5,
                'review' => 'Sản phẩm tuyệt vời! Tôi rất hài lòng với chất lượng và giá cả.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Sản phẩm này có giá tốt và chất lượng ổn định. Tôi sẽ mua lại.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 4,
                'review' => 'Chất lượng tốt, nhưng không như tôi mong đợi.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 3,
                'review' => 'Sản phẩm ổn, nhưng cần cải thiện về thiết kế.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 2,
                'review' => 'Không ấn tượng với sản phẩm này.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Sản phẩm rất tốt, đáng tiền!',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Tôi rất hài lòng với sản phẩm này.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Sản phẩm tốt nhưng cần cải thiện một vài chi tiết.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 3,
                'review' => 'Sản phẩm tạm ổn, có thể tốt hơn.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 2,
                'review' => 'Không hài lòng với chất lượng.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 1,
                'review' => 'Không khuyến nghị sản phẩm này.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Thật tuyệt vời! Tôi sẽ mua thêm.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Sản phẩm rất chất lượng.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 5,
                'review' => 'Đáng giá từng đồng.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 3,
                'review' => 'Bình thường, không có gì đặc biệt.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Sản phẩm ổn, tôi sẽ mua lại.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 2,
                'review' => 'Không ấn tượng.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Tuyệt vời, tôi rất thích!',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 3,
                'review' => 'Chất lượng chấp nhận được.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Rất hài lòng với sản phẩm.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Sản phẩm tuyệt vời, chất lượng tốt.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Sản phẩm đáp ứng mong đợi.',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 2,
                'review' => 'Chất lượng cần cải thiện.',
                'created_at' => now(),
            ],
        ]);
        
    }
}

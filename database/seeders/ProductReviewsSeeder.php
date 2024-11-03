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
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Chất lượng tốt, tuy nhiên giá hơi cao.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 3,
                'review' => 'Sản phẩm đạt yêu cầu, nhưng có thể cải thiện hơn nữa.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Tuyệt vời! Sản phẩm đúng như mong đợi và giá cả phải chăng.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 5,
                'review' => 'Sản phẩm tuyệt vời! Tôi rất hài lòng với chất lượng và giá cả.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Sản phẩm này có giá tốt và chất lượng ổn định. Tôi sẽ mua lại.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 4,
                'review' => 'Chất lượng tốt, nhưng không như tôi mong đợi.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 3,
                'review' => 'Sản phẩm ổn, nhưng cần cải thiện về thiết kế.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 2,
                'review' => 'Không ấn tượng với sản phẩm này.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Sản phẩm rất tốt, đáng tiền!',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Tôi rất hài lòng với sản phẩm này.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Sản phẩm tốt nhưng cần cải thiện một vài chi tiết.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 3,
                'review' => 'Sản phẩm tạm ổn, có thể tốt hơn.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 2,
                'review' => 'Không hài lòng với chất lượng.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 1,
                'review' => 'Không khuyến nghị sản phẩm này.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Thật tuyệt vời! Tôi sẽ mua thêm.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Sản phẩm rất chất lượng.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 5,
                'review' => 'Đáng giá từng đồng.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 3,
                'review' => 'Bình thường, không có gì đặc biệt.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Sản phẩm ổn, tôi sẽ mua lại.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 2,
                'review' => 'Không ấn tượng.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Tuyệt vời, tôi rất thích!',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 3,
                'review' => 'Chất lượng chấp nhận được.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Rất hài lòng với sản phẩm.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 1,
                'rating' => 5,
                'review' => 'Sản phẩm tuyệt vời, chất lượng tốt.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Sản phẩm đáp ứng mong đợi.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
            [
                'product_id' => rand(1, 15),
                'user_id' => 3,
                'rating' => 2,
                'review' => 'Chất lượng cần cải thiện.',
                'image' => 'https://source.unsplash.com/random/300x300',
                'created_at' => now(),
            ],
        ]);
        
    }
}

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
                'product_id' => 7,
                'user_id' => 2,
                'rating' => 5,
                'review' => 'Sản phẩm tuyệt vời!',
                'created_at' => now(),
            ],
            [
                'product_id' => 8,
                'user_id' => 2,
                'rating' => 4,
                'review' => 'Chất lượng tốt nhưng giá hơi cao.',
                'created_at' => now(),
            ],
            [
                'product_id' => 8,
                'user_id' => 2,
                'rating' => 3,
                'review' => 'Sản phẩm không như mong đợi.',
                'created_at' => now(),
            ],
            [
                'product_id' => 7,
                'user_id' => 2,
                'rating' => 2,
                'review' => 'Thất vọng với sản phẩm này.',
                'created_at' => now(),
            ],
            [
                'product_id' => 8,
                'user_id' => 2,
                'rating' => 1,
                'review' => 'Không khuyến nghị sản phẩm này.',
                'created_at' => now(),
            ],
        ]);
    }
}

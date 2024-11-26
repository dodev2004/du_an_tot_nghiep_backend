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
        $orderItems = DB::table('order_items')->get();
        foreach ($orderItems as $orderItem) {
            // Lấy customer_id từ bảng orders dựa vào order_id
            $order = DB::table('orders')->where('id', $orderItem->order_id)->first();
            if ($order) {
                DB::table('product_reviews')->insert([
                    [
                        'order_item_id' => $orderItem->id, // gắn order_item_id để tạo mối liên hệ
                        'product_id' => $orderItem->product_id,
                        'user_id' => $order->customer_id, // giả sử user_id là order_id
                        'rating' => rand(1, 5), // Đánh giá ngẫu nhiên từ 1 đến 5
                        'review' => 'Sản phẩm tuyệt vời! Tôi rất hài lòng với chất lượng.',
                        'created_at' => now(),
                    ]
                ]);
            }
        }
    }
}

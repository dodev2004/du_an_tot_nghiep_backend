<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->insert([
            [
                'customer_id' => 2,
                'customer_name' => 'Nguyễn Văn A',
                'promotion_id' => null,
                'total_amount' => 2000000.00,
                'discount_amount' => 200000.00,
                'final_amount' => 1800000.00,
                'status' => 1,
                'payment_status' => 1,
                'shipping_address' => 'Hà Nội, Việt Nam',
                'shipping_fee' => 20000.00,
                'payment_method_id' => 1,
                'discount_code' => 'PROMO2024',
                'email' => 'nguyenvana@example.com',
                'phone_number' => '0123456789',
                'note' => 'Giao hàng vào buổi tối',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'customer_name' => 'Trần Thị B',
                'promotion_id' => 1,
                'total_amount' => 1500000.00,
                'discount_amount' => 150000.00,
                'final_amount' => 1350000.00,
                'status' => 1,
                'payment_status' => 1,
                'shipping_address' => 'Đà Nẵng, Việt Nam',
                'shipping_fee' => 50000.00,
                'payment_method_id' => 2,
                'discount_code' => 'SPRINGSALE',
                'email' => 'tranthib@example.com',
                'phone_number' => '0987654321',
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

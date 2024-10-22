<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
                'payment_method_id' => 3,
                'discount_code' => 'PROMO2024',
                'email' => 'nguyenvana@example.com',
                'phone_number' => '0123456789',
                'note' => 'Giao hàng vào buổi tối',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

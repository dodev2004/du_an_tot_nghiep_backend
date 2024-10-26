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
            [
                'customer_id' => 3,
                'customer_name' => 'Trần Thị B',
                'promotion_id' => null,
                'total_amount' => 1500000.00,
                'discount_amount' => 150000.00,
                'final_amount' => 1350000.00,
                'status' => 1,
                'payment_status' => 1,
                'shipping_address' => 'Hải Phòng, Việt Nam',
                'shipping_fee' => 15000.00,
                'payment_method_id' => 2,
                'discount_code' => 'PROMO2024',
                'email' => 'tranthib@example.com',
                'phone_number' => '0987654321',
                'note' => 'Giao hàng vào buổi sáng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 4,
                'customer_name' => 'Lê Văn C',
                'promotion_id' => null,
                'total_amount' => 2500000.00,
                'discount_amount' => 250000.00,
                'final_amount' => 2250000.00,
                'status' => 2,
                'payment_status' => 2,
                'shipping_address' => 'Đà Nẵng, Việt Nam',
                'shipping_fee' => 30000.00,
                'payment_method_id' => 1,
                'discount_code' => null,
                'email' => 'levanc@example.com',
                'phone_number' => '0912345678',
                'note' => 'Giao hàng ngay',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 5,
                'customer_name' => 'Nguyễn Thị D',
                'promotion_id' => null,
                'total_amount' => 1800000.00,
                'discount_amount' => 180000.00,
                'final_amount' => 1620000.00,
                'status' => 1,
                'payment_status' => 1,
                'shipping_address' => 'Nha Trang, Việt Nam',
                'shipping_fee' => 25000.00,
                'payment_method_id' => 3,
                'discount_code' => 'PROMO2024',
                'email' => 'nguyenthid@example.com',
                'phone_number' => '0934567890',
                'note' => 'Giao hàng vào buổi chiều',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 6,
                'customer_name' => 'Phạm Văn E',
                'promotion_id' => null,
                'total_amount' => 3000000.00,
                'discount_amount' => 300000.00,
                'final_amount' => 2700000.00,
                'status' => 1,
                'payment_status' => 1,
                'shipping_address' => 'Cần Thơ, Việt Nam',
                'shipping_fee' => 35000.00,
                'payment_method_id' => 2,
                'discount_code' => null,
                'email' => 'phamvane@example.com',
                'phone_number' => '0981234567',
                'note' => 'Giao hàng vào cuối tuần',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

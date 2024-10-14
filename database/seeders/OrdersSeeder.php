<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'user_id' => 3,
            'customer_name' => 'Nguyễn Văn A', // Bạn có thể thay đổi tên này nếu cần
            'promotion_id' => 1,
            'total_amount' => 20000,
            'discount_amount' => 10000,
            'final_amount' => 10000,
            'status' => 'shipped',
            'payment_status' => 'paid',
            'shipping_address' => '123 Đường ABC, Quận 1, TP. HCM', // Bạn có thể thay đổi địa chỉ này nếu cần
            'shipping_method' => 'Giao hàng nhanh', // Bạn có thể thay đổi phương thức giao hàng này nếu cần
            'shipping_fee' => 0,
            'payment_method_id' => null, // Không cần payment_method
            'discount_code' => 'DS01',
            'order_status' => null,
            'email' => 'nguyenvana@example.com', // Bạn có thể thay đổi email này nếu cần
            'phone_number' => '0123456789', // Bạn có thể thay đổi số điện thoại này nếu cần
            'note' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);
    }
}

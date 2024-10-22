<?php
namespace Database\Seeders;

 use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        DB::table('payment_methods')->insert([
            [
                'name' => 'Thẻ tín dụng',
                'description' => 'Thanh toán qua thẻ tín dụng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chuyển khoản ngân hàng',
                'description' => 'Thanh toán qua chuyển khoản ngân hàng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tiền mặt khi nhận hàng',
                'description' => 'Thanh toán khi nhận hàng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 7, // ID của đơn hàng tương ứng
                'product_id' => 1, // ID của sản phẩm
                'product_name' => 'Sơn Đẹp trai Cao Cấp', // Tên sản phẩm
                "variant" => json_encode([
                    "Gỗ sồi","Màu đen"
                ]),
                'quantity' => 2,
                'price' => 12000.00,
                'total' => 24000.00, // Tổng giá trị của sản phẩm này
                'created_at' => now(),
                'updated_at' => now(),
            ],
        
        ]);
    }
}

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
                'order_id' => rand(1, 6), // ID của đơn hàng ngẫu nhiên từ 11 đến 15
                'product_id' => 1,
                'product_name' => 'Sofa Vải Cao Cấp',
                'variant' => json_encode(["Gỗ sồi", "Màu đen"]),
                'quantity' => 2,
                'price' => 12000.00,
                'total' => 24000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => rand(1, 6),
                'product_id' => 2,
                'product_name' => 'Giường Gỗ Sồi',
                'variant' => json_encode(["Gỗ sồi", "Màu xám"]),
                'quantity' => 1,
                'price' => 18000.00,
                'total' => 18000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => rand(1, 6),
                'product_id' => 3,
                'product_name' => 'Tủ Quần Áo Gỗ Xoan Đào',
                'variant' => json_encode(["Gỗ xoan đào", "Màu nâu"]),
                'quantity' => 1,
                'price' => 20000.00,
                'total' => 20000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => rand(1, 6),
                'product_id' => 4,
                'product_name' => 'Bàn Trà Gỗ Óc Chó',
                'variant' => json_encode(["Gỗ óc chó", "Màu đen"]),
                'quantity' => 1,
                'price' => 30000.00,
                'total' => 30000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => rand(1, 6),
                'product_id' => 5,
                'product_name' => 'Sofa Da Thật Sang Trọng',
                'variant' => json_encode(["Da thật", "Màu nâu"]),
                'quantity' => 1,
                'price' => 50000.00,
                'total' => 50000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => rand(1, 6),
                'product_id' => 6,
                'product_name' => 'Bàn Trang Điểm Gỗ Sồi',
                'variant' => json_encode(["Gỗ sồi", "Màu trắng"]),
                'quantity' => 1,
                'price' => 15000.00,
                'total' => 15000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        
        ]);
    }
}

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
                'order_id' => 1,
                'product_id' => 1,
                'product_name' => 'Ghế Sofa',
                'variant' => json_encode(['màu sắc' => 'Xanh', 'kích thước' => 'L']),
                'quantity' => 2,
                'price' => 800000.00,
                'total' => 1600000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 1,
                'product_id' => 2,
                'product_name' => 'Bàn trà',
                'variant' => json_encode(['màu sắc' => 'Nâu', 'kích thước' => 'M']),
                'quantity' => 1,
                'price' => 400000.00,
                'total' => 400000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'product_id' => 3,
                'product_name' => 'Kệ sách',
                'variant' => json_encode(['màu sắc' => 'Đen', 'kích thước' => 'S']),
                'quantity' => 1,
                'price' => 500000.00,
                'total' => 500000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php 
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        DB::table('promotions')->insert([
            [
                'code' => 'PROMO2024',
                'discount_value' => 200000.00,
                'discount_type' => 'fixed',
                'status' => 'active',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(10),
                'max_uses' => 100,
                'used_count' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SPRINGSALE',
                'discount_value' => 10.00,
                'discount_type' => 'percentage',
                'status' => 'active',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(5),
                'max_uses' => null,
                'used_count' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

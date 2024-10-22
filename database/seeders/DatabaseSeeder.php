<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\PaymentMethodsSeeder as SeedersPaymentMethodsSeeder;
use Illuminate\Database\Seeder;
use OrderItemsSeeder;
use OrdersSeeder;
use PaymentMethodsSeeder;
use PromotionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
          
            // RoleSeeder::class,
            // PermissionSeeder::class,
            // RolePermissionSeeder::class,
            // PostCateloguesSeeder::class,
            // ProductCatalogueSeeder::class,
            // BrandSeeder::class,
            // ProductSeeder::class,
            // AttributeSeeder::class,
            // AttributeValueSeeder::class,
            // ProductVariantSeeder::class,

            // PaymentMethodSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // UserSeeder::class,
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
            VariantAttributeValueSeeder::class,
        ]);
    }
}

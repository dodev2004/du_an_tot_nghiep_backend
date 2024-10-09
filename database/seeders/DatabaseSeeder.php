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
        ProductCatalogueSeeder::class,
        ProductSeeder::class,
        AttributeSeeder::class,
        VariantAttributeValueSeeder::class,
        ProductVariantSeeder::class,
        VariantAttributeValueSeeder::class,
    }
}

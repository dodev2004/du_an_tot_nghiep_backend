<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            [
                "username" => "buingocdo04dev",
                "password" => Hash::make("admin"),
                "email" => "buingocdo04dev@gmail.com",
                "full_name" => "Bùi Ngọc Đô",
                "rule_id" => 1
            ],
        ]);
    }
}

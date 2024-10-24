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
                "pasgit sword" => Hash::make("admin"),
                "email" => "buingocdo04dev@gmail.com",
                "full_name" => "Bùi Ngọc Đô",
                "role_id" => 1
            ],
            [
                "username" => "buingocdo2004@ádasd",
                "password" => Hash::make("admin"),
                "email" => "budev@gmail.com",
                "full_name" => "Trần hoàn",
                "role_id" => 2
            ]

        ]);
    }
}

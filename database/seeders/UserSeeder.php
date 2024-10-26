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
            ],[
                "username" => "nntson",
                "password" => Hash::make("admin"),
                "email" => "sonnguyen@gmail.com",
                "full_name" => "Nguyễn ngọc trường sơn",
                "rule_id" => 1
            ],[
                "username" => "hoant",
                "password" => Hash::make("admin"),
                "email" => "hoant2004@gmail.com",
                "full_name" => "Trần Hoàn",
                "rule_id" => 1
            ],[
                "username" => "tvcuong",
                "password" => Hash::make("admin"),
                "email" => "tvcuong2004@gmail.com",
                "full_name" => "Trần Văn Cường",
                "rule_id" => 1
            ],[
                "username" => "hsfkjsf",
                "password" => Hash::make("user"),
                "email" => "nguyenvana@example.com",
                "full_name" => "Nguyễn Văn A",
                "rule_id" => 2
            ],
            [
                "username" => "aslkdslf",
                "password" => Hash::make("user"),
                "email" => "tranthib@example.com",
                "full_name" => "Trần Thị B",
                "rule_id" => 2
            ],
            [
                "username" => "asdfg",
                "password" => Hash::make("user"),
                "email" => "levanc@example.com",
                "full_name" => "Lê Văn C",
                "rule_id" => 2
            ],
            [
                "username" => "qwerty",
                "password" => Hash::make("user"),
                "email" => "nguyenthid@example.com",
                "full_name" => "Nguyễn Thị D",
                "rule_id" => 2
            ],
            [
                "username" => "zxcvb",
                "password" => Hash::make("user"),
                "email" => "phamvane@example.com",
                "full_name" => "Phạm Văn E",
                "rule_id" => 2
            ],

        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'title' => 'First Post',
                'content' => 'This is the content of the first post.',
                'slug' => Str::slug('First Post'),
                'meta_description' => 'This is the meta description for the first post.',
                'meta_keywords' => 'first, post, meta',
                'user_id' => 1, // Giả sử user_id 1 tồn tại
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Second Post',
                'content' => 'This is the content of the second post.',
                'slug' => Str::slug('Second Post'),
                'meta_description' => 'This is the meta description for the second post.',
                'meta_keywords' => 'second, post, meta',
                'user_id' => 1, // Giả sử user_id 1 tồn tại
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Bạn có thể thêm nhiều bài viết khác tương tự
        ]);
    }
}

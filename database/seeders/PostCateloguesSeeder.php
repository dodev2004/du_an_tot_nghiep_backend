<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostCatelogue;

class PostCateloguesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo danh mục cha
        $parent = PostCatelogue::create([
            'name' => 'Parent Category',
            'description' => 'Description for Parent Category',
            'slug' => 'parent-category',
            'avatar' => 'parent-avatar.jpg',
            'meta-title' => 'Meta Title for Parent Category',
            'meta-description' => 'Meta Description for Parent Category',
            'meta_keywords' => 'parent, keyword',
            'user_id' => 1,
            'level' => 1,
            'status' => 1,
        ]);

        // Tạo các danh mục con cấp 1
        $child1 = PostCatelogue::create([
            'name' => 'Child Category 1',
            'description' => 'Description for Child Category 1',
            'slug' => 'child-category-1',
            'avatar' => 'child-avatar-1.jpg',
            'meta-title' => 'Meta Title for Child Category 1',
            'meta-description' => 'Meta Description for Child Category 1',
            'meta_keywords' => 'child1, keyword',
            'user_id' => 1,
            'level' => 2,
            'status' => 1,
        ]);

        $child2 = PostCatelogue::create([
            'name' => 'Child Category 2',
            'description' => 'Description for Child Category 2',
            'slug' => 'child-category-2',
            'avatar' => 'child-avatar-2.jpg',
            'meta-title' => 'Meta Title for Child Category 2',
            'meta-description' => 'Meta Description for Child Category 2',
            'meta_keywords' => 'child2, keyword',
            'user_id' => 1,
            'level' => 2,
            'status' => 1,
        ]);

        // Sử dụng NestedSet để gán các danh mục con vào danh mục cha
        $parent->appendNode($child1);
        $parent->appendNode($child2);

        // Tạo danh mục con của child1 (tức là cấp 2)
        $child1_1 = PostCatelogue::create([
            'name' => 'Sub-child Category 1 of Child 1',
            'description' => 'Description for Sub-child Category 1',
            'slug' => 'sub-child-category-1-of-child-1',
            'avatar' => 'sub-child-avatar-1.jpg',
            'meta-title' => 'Meta Title for Sub-child Category 1',
            'meta-description' => 'Meta Description for Sub-child Category 1',
            'meta_keywords' => 'sub-child1, keyword',
            'user_id' => 1,
            'level' => 3,
            'status' => 1,
        ]);

        // Gán sub-child vào child1
        $child1->appendNode($child1_1);
    }
}

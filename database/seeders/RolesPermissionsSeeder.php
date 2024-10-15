<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'description' => 'Administrator role with full access',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'customer',
                'description' => 'Customer role with limited access',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Insert group permissions (example data)
        DB::table('group_permission')->insert([
            [
                'id' => 1,
                'name' => 'User Management',
                'description' => 'Group of permissions for managing users',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Product Management',
                'description' => 'Group of permissions for managing products',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Insert permissions (example data)
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'group_permission_id' => 1,
                'name' => 'view_users',
                'description' => 'Permission to view users',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'group_permission_id' => 1,
                'name' => 'edit_users',
                'description' => 'Permission to edit users',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'group_permission_id' => 2,
                'name' => 'view_products',
                'description' => 'Permission to view products',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'group_permission_id' => 2,
                'name' => 'edit_products',
                'description' => 'Permission to edit products',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Insert permission_role relationships
        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], // Admin can view users
            ['permission_id' => 2, 'role_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], // Admin can edit users
            ['permission_id' => 3, 'role_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], // Admin can view products
            ['permission_id' => 4, 'role_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], // Admin can edit products
            ['permission_id' => 3, 'role_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], // Customer can view products
        ]);

        // Insert user_role relationships (assigning roles to users)
        DB::table('user_role')->insert([
            ['user_id' => 1, 'role_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], // User 1 is admin
            ['user_id' => 2, 'role_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], // User 2 is admin
            ['user_id' => 3, 'role_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()], // User 3 is customer
        ]);
    }
}

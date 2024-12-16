<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LastDeleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List of names to delete
        $namesToDelete = [
            'createGroupPermission',
            'storeGroupPermission',
            'deleteGroupPermission',
            'forceDeleteGroupPermission',
            'restoreGroupPermission',
            'viewGroupPermissionTrash',
            'createPermission',
            'storePermission',
            'deletePermission',
            'forceDeletePermission',
            'restorePermission',
            'viewPermissionTrash',
        ];

        // Delete records in the permissions table where name is in the list
        DB::table('permissions')->whereIn('name', $namesToDelete)->delete();
    }
}

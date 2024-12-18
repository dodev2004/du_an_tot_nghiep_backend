<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LastDeletePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List of names to delete
        $namesToDelete = [
            'storeUser', 'updateUser', 'storeUserCatelogue', 'updateUserCatelogue', 
'storePostCatelogue', 'updatePostCatelogue', 'storePost', 'updatePost', 
'storeProduct', 'updateProduct', 'storeProductCatelogue', 'updateProductCatelogue', 
'storeVariantCatelogue', 'updateVariantCatelogue', 'storeAttributeValue', 'updateAttributeValue', 
'storePromotion', 'updatePromotion', 'storeAboutPage', 'updateAboutPage', 
'storeComment', 'storeBrand', 'updateBrand', 'createContact', 'storeContact', 
'updateContact', 'storeInformation', 'updateInformation', 'storeShippingFee', 
'updateShippingFee', 'updateCustomer', 'updateGroupPermission', 'updatePermission', 
'storeRole', 'updateRole', 'storeBanner', 'updateBanner',"updateUserStatus","deleteOrder"

        ];
        // Delete records in the permissions table where name is in the list
        DB::table('permissions')->whereIn('name', $namesToDelete)->delete();
        $this->command->info('Success');

    }
}

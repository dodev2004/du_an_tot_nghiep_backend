<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LastUpdatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsToDelete = [
            'viewPaymentMethod',
            'createPaymentMethod',
            'storePaymentMethod',
            'editPaymentMethod',
            'updatePaymentMethod',
            'deletePaymentMethod',
            'createOrder',
            'storeOrder',
            'editOrder',
            'createCustomer',
            'storeCustomer',
            'filterSalesData',
            'selectSalesData',
            'selectOrderStatusData',
        ];

        DB::table('permissions')->whereIn('name', $permissionsToDelete)->delete();

        // Cập nhật display_name
        $updates = [
            'updateOrder' => 'Cập nhật trạng thái đơn hàng',
            'viewDashboardOrder' => 'Xem thống kê',
        ];

        foreach ($updates as $name => $displayName) {
            DB::table('permissions')->where('name', $name)->update(['display_name' => $displayName]);
        }

        $this->command->info('Deleted specified permissions from the database.');

    }
}

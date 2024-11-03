<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        // Tạo cột mới 'status'
        $table->boolean('status')->default(1);
    });

    // Sao chép dữ liệu từ cột 'is_active' sang cột 'status'
    DB::statement('UPDATE products SET status = is_active');

    // Xóa cột cũ 'is_active'
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('is_active');
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        // Tạo lại cột 'is_active'
        $table->boolean('is_active')->default(1);
    });

    // Sao chép dữ liệu từ cột 'status' quay lại 'is_active'
    DB::statement('UPDATE products SET is_active = status');

    // Xóa cột 'status'
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};

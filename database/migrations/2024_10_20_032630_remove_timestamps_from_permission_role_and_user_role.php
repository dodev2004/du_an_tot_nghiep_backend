<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permission_role_and_user_role', function (Blueprint $table) {
            // Xoá các cột trong bảng permission_role
        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at', 'deleted_at']);
        });

        // Xoá các cột trong bảng user_role
        Schema::table('user_role', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at', 'deleted_at']);
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permission_role_and_user_role', function (Blueprint $table) {
            // Thêm lại các cột nếu rollback
        Schema::table('permission_role', function (Blueprint $table) {
            $table->timestamps(); // thêm lại created_at và updated_at
            $table->softDeletes(); // thêm lại deleted_at
        });

        Schema::table('user_role', function (Blueprint $table) {
            $table->timestamps(); // thêm lại created_at và updated_at
            $table->softDeletes(); // thêm lại deleted_at
        });
        });
    }
};

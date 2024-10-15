<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRolesPermissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Thêm soft deletes và timestamps cho bảng roles
        Schema::table('roles', function (Blueprint $table) {

            $table->softDeletes(); // deleted_at
        });

        // Thêm soft deletes và timestamps cho bảng permissions
        Schema::table('permissions', function (Blueprint $table) {

            $table->softDeletes(); // deleted_at
        });

        // Thêm soft deletes và timestamps cho bảng group_permission
        Schema::table('group_permission', function (Blueprint $table) {

            $table->softDeletes(); // deleted_at
        });

        // Thêm soft deletes, created_at, updated_at cho bảng permission_role
        Schema::table('permission_role', function (Blueprint $table) {
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at
        });

        // Thêm soft deletes, created_at, updated_at cho bảng user_role
        Schema::table('user_role', function (Blueprint $table) {
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at
        });

        // Thêm soft deletes cho bảng users

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Xóa soft deletes và timestamps
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });

        Schema::table('group_permission', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });

        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at', 'deleted_at']);
        });

        Schema::table('user_role', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at', 'deleted_at']);
        });


    }
}

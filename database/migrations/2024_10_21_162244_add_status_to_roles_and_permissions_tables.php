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
        Schema::table('roles', function (Blueprint $table) {
            $table->string('status')->default(1); // Thêm cột status sau cột description trong bảng roles
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->string('status')->default(1); // Thêm cột status sau cột description trong bảng permissions
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('status');
            });

            Schema::table('permissions', function (Blueprint $table) {
                $table->dropColumn('status');
            });

    }
};
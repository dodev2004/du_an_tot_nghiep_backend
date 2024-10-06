<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('brands', function (Blueprint $table) {
        $table->boolean('status')->default(true); // Thêm trường status kiểu boolean
    });
}

public function down()
{
    Schema::table('brands', function (Blueprint $table) {
        $table->dropColumn('status'); // Xóa trường status nếu rollback
    });
}

};

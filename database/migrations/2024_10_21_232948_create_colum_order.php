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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->after('id'); // Thêm trường customer_id
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->dropForeign(['user_id']); // Xóa khóa ngoại
            $table->dropColumn('user_id');
            // Đặt khóa ngoại
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->dropForeign(['customer_id']); // Xóa khóa ngoại
            $table->dropColumn('customer_id'); // Xóa trường customer_id
        });
    }
};

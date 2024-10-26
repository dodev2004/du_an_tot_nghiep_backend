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
        Schema::table('order_items', function (Blueprint $table) {
            // Xóa khóa ngoại (giả sử tên khóa ngoại là order_items_variant_id_foreign)
            $table->dropForeign(['variant_id']);

            // Xóa cột variant_id
            $table->dropColumn('variant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Khôi phục cột variant_id
            $table->unsignedBigInteger('variant_id')->nullable();

            // Khôi phục khóa ngoại
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }
};

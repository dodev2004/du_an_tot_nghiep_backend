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
        Schema::table('order_items', function (Blueprint $table) {
             $table->json('variant')->nullable(); 
             $table->unsignedBigInteger('variant_id')->nullable()->after('product_id');

            // Nếu bạn muốn thiết lập khóa ngoại với bảng product_variants
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('variant'); 
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
        });
    }
};

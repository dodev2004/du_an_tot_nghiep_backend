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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['catalogue_id']);
            // Sau đó xóa cột
            $table->dropColumn('catalogue_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('catalogue_id')->nullable();
            // Sau đó khôi phục khóa ngoại
            $table->foreign('catalogue_id')->references('id')->on('product_catelogues')->onDelete('cascade');
        });
    }
};

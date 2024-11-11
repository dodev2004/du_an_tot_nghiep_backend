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
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignId('product_variants_id')->nullable()->change(); // khóa ngoại tới bảng product_variants
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade'); // Khóa ngoại tới bảng products
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['product_id']); // Xóa khóa ngoại trước khi xóa cột
            $table->dropColumn('product_id'); // Xóa cột product_id
        });
    }
};

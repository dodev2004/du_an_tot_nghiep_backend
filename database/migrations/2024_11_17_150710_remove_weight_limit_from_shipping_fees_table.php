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
        Schema::table('shipping_fees', function (Blueprint $table) {
            $table->dropColumn('weight_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_fees', function (Blueprint $table) {
            $table->integer('weight_limit')->nullable(); // Điều chỉnh kiểu dữ liệu phù hợp nếu cần.
        });
    }
};

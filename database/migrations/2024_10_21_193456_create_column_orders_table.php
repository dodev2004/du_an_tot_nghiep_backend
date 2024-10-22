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
            $table->dropColumn('shipping_method');
            $table->dropColumn('order_status'); // Dropped order_status as well
            $table->integer('status')->default(1)->change();
            $table->integer('payment_status')->default(1)->change(); // Keep it if you want to change it
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // If you want to restore dropped columns
            $table->string('shipping_method')->nullable(); // Adjust type and options as needed
            $table->integer('order_status')->default(1); // Re-add the dropped order_status
          
        });
    }
};

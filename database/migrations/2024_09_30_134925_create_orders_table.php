<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // khóa ngoại tới bảng users
            $table->string('customer_name');
            $table->foreignId('promotion_id')->nullable()->constrained('promotions')->onDelete('set null'); // khóa ngoại tới bảng promotions
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('final_amount', 10, 2);
            $table->enum('status', ['processing', 'Delivering', 'shipped', 'canceled', 'refunded'])->default('processing');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('shipping_address');
            $table->string('shipping_method');
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->onDelete('set null'); // khóa ngoại tới bảng payment_methods
            $table->string('discount_code')->nullable();
            $table->string('order_status')->nullable();
            $table->string('email');
            $table->string('phone_number');
            $table->text('note')->nullable();
            $table->timestamps(); // tạo cột created_at và updated_at
            $table->softDeletes(); // tạo cột deleted_at để hỗ trợ xóa mềm
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

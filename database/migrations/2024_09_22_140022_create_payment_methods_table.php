<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->string('name')->unique()->whereNull('deleted_at'); // Tên phương thức thanh toán
            $table->text('description')->nullable(); // Mô tả phương thức thanh toán
            $table->timestamps(); // Tạo cột created_at và updated_at
            $table->softDeletes(); // Thêm cột deleted_at cho việc xóa mềm
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}

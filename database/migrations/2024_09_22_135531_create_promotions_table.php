<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->string('code')->unique(); // Mã khuyến mãi, phải duy nhất
            $table->decimal('discount_value', 10, 2); // Giá trị giảm giá
            $table->enum('discount_type', ['percentage', 'fixed']); // Kiểu giảm giá
            $table->enum('status', ['active', 'inactive']); // Trạng thái khuyến mãi
            $table->dateTime('start_date'); // Ngày bắt đầu
            $table->dateTime('end_date')->nullable(); // Ngày kết thúc, có thể null
            $table->integer('max_uses')->nullable(); // Số lần sử dụng tối đa, có thể null
            $table->integer('used_count')->default(0); // Số lần đã sử dụng
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}

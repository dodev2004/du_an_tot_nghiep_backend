<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_fees', function (Blueprint $table) {
            $table->id();
            $table->string('province_code', 10)->index(); // mã tỉnh, có thể dùng để tra cứu
            $table->decimal('fee', 10, 2); // phí vận chuyển
            $table->decimal('weight_limit', 10, 2)->nullable(); // giới hạn trọng lượng, có thể null
            $table->timestamps(); // tạo cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_fees');
    }
}

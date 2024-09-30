<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_variant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade'); // khóa ngoại tới bảng order_items
            $table->string('variant_name');
            $table->string('variant_value');
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
        Schema::dropIfExists('order_item_variant');
    }
}

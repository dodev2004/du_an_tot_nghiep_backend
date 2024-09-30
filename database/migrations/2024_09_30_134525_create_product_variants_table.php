<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // khóa ngoại tới bảng products
            $table->decimal('price', 10, 2);
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimension')->nullable();
            $table->integer('stock');
            $table->string('sku')->unique();
            $table->string('image_url')->nullable();
            $table->softDeletes(); // tạo cột deleted_at để hỗ trợ xóa mềm
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
        Schema::dropIfExists('product_variants');
    }
}

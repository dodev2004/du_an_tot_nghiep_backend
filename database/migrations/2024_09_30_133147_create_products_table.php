<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalogue_id')->constrained('product_catelogues')->onDelete('cascade'); // khóa ngoại tới bảng product_catalogues
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null'); // khóa ngoại tới bảng brands
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('detailed_description')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->double('weight', 8, 2)->nullable();
            $table->double('ratings_avg', 8, 2)->default(0.00);
            $table->integer('ratings_count')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_featured')->default(0);
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
        Schema::dropIfExists('products');
    }
}

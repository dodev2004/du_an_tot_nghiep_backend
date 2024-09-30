<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // khóa ngoại tới bảng products
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // khóa ngoại tới bảng users
            $table->integer('rating'); // có thể thêm ràng buộc kiểm tra giá trị từ 1 đến 5 nếu cần
            $table->text('review')->nullable();
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
        Schema::dropIfExists('product_reviews');
    }
}

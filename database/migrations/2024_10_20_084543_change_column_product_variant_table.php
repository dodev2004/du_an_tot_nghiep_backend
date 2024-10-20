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
        Schema::table('product_variants', function (Blueprint $table) {
            // Thay đổi cột 'price' và thêm giá trị mặc định
            $table->decimal('price', 10, 2)->default(0.00)->change();
            
            // Thêm cột 'discount_price' nếu chưa có và thiết lập giá trị mặc định
            if (!Schema::hasColumn('product_variants', 'discount_price')) {
                $table->decimal('discount_price', 10, 2)->default(0.00);
            }

            // Thay đổi cột 'weight' và thêm giá trị mặc định
            $table->decimal('weight', 8, 2)->nullable()->default(0.00)->change();
            
            // Thay đổi cột 'stock' và thêm giá trị mặc định
            $table->integer('stock')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // Quay lại giá trị cũ nếu cần trong phương thức rollback
            $table->decimal('price', 10, 2)->change();
            $table->decimal('weight', 8, 2)->change();
            $table->integer('stock')->change();

            // Xóa cột 'discount_price' nếu cần rollback
            if (Schema::hasColumn('product_variants', 'discount_price')) {
                $table->dropColumn('discount_price');
            }
        });
    }
};

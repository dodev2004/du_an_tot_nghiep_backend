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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Trường tên
            $table->string('phone'); // Trường số điện thoại
            $table->string('address'); // Trường địa chỉ
            $table->text('map'); // Trường map
            $table->string('image')->nullable(); // Trường image (có thể null)
            $table->timestamps();
            $table->softDeletes(); // Thêm cột deleted_at cho việc xóa mềm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information');
    }
};

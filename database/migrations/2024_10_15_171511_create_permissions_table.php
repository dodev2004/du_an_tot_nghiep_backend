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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('group_permission_id')->nullable(); // Tạo cột group_permission_id
            // Thêm khóa ngoại cho group_permission_id
            $table->foreign('group_permission_id')->references('id')->on('group_permission')->onDelete('cascade'); // Thiết lập hành động khi xóa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};

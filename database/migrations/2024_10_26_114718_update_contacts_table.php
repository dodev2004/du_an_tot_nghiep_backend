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
        Schema::table('contacts', function (Blueprint $table) {
            // Thêm trường image sau trường content
            $table->string('image')->nullable()->after('content');
            
            // Xoá trường title
            $table->dropColumn('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Xoá trường image nếu cần phục hồi
            $table->dropColumn('image');
            
            // Thêm lại trường title
            $table->string('title')->nullable();
        });
    }
};

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
        Schema::table('Products', function (Blueprint $table) {
             $table->string("meta_description",255)->nullable();
             $table->string("meta_keywords")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Products', function (Blueprint $table) {
            $table->dropColumn("meta_description");
            $table->dropColumn("meta_keywords");
        });
    }
};

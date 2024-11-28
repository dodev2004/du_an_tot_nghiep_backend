<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyQuantityNullableInPromotions extends Migration
{
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->change(); // Thay đổi trường quantity thành nullable
        });
    }

    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->integer('quantity')->nullable(false)->change(); // Đặt lại thành not nullable nếu rollback
        });
    }
};

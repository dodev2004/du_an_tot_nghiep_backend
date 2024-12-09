<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusTypeInAboutsTable extends Migration
{
    public function up()
    {
        Schema::table('about_pages', function (Blueprint $table) {
            $table->tinyInteger('status')->change(); // Thay đổi kiểu dữ liệu thành tinyInteger
        });
    }

    public function down()
    {
        Schema::table('about_pages', function (Blueprint $table) {
            $table->string('status', 255)->change(); // Khôi phục kiểu dữ liệu về varchar(255)
        });
    }
}
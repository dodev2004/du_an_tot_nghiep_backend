<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeStatusTypeInAboutsTable extends Migration
{
    public function up()
    {
        Schema::table('about_pages', function (Blueprint $table) {
             // Cập nhật các giá trị trong cột status
        DB::table('about_pages')->where('status', 'hoạt động')->update(['status' => 1]);
        DB::table('about_pages')->where('status', 'không hoạt động')->update(['status' => 0]);
        });
    }

    public function down()
    {
        Schema::table('about_pages', function (Blueprint $table) {
            DB::table('about_pages')->where('status', 1)->update(['status' => 'hoạt động']);
            DB::table('about_pages')->where('status', 0)->update(['status' => 'không hoạt động']);
        });
    }
}
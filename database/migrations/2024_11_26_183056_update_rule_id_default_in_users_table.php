<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRuleIdDefaultInUsersTable extends Migration
{
    public function up()
    {
        DB::table('users')->whereNull('rule_id')->update(['rule_id' => 2]);

        Schema::table('users', function (Blueprint $table) {
            $table->integer('rule_id')->default(2)->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('rule_id')->nullable()->default(null)->change();
        });
    }
}

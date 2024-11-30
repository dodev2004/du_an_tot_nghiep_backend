<?php

use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class UpdateUsersTableRuleIdNullable extends Migration
   {
       public function up()
       {
           Schema::table('users', function (Blueprint $table) {
               $table->integer('rule_id')->nullable()->change();
           });
       }

       public function down()
       {
           Schema::table('users', function (Blueprint $table) {
               $table->integer('rule_id')->nullable(false)->change();
           });
       }
   };

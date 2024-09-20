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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("username");
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string("phone", 20)->nullable();
            $table->string("province_id", 10)->nullable();
            $table->string("district_id", 10)->nullable();
            $table->string("ward_id", 10)->nullable();
            $table->string('password');
            $table->string("address")->nullable();
            $table->date("birthday")->nullable();
            $table->string("avatar")->nullable();
            $table->text("description")->nullable();
            $table->dateTime("user_agent")->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->integer("rule_id")->default(1);
            $table->string('google_id')->nullable();
            $table->date('last_login')->nullable();
            $table->softDeletes();
        });

     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

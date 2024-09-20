<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_catelogues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string("slug",50)->unique();
            $table->string("avatar")->nullable();
            $table->string('meta-title')->nullable();
            $table->string("meta-description")->nullable();
            $table->string("meta_keywords")->nullable();
            $table->unsignedBigInteger("user_id");
            NestedSet::columns($table);
            $table->integer("level");
            $table->tinyInteger("status")->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catelogues');
    }
};

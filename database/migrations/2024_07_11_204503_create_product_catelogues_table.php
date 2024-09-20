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
        Schema::create('product_catelogues', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug",150)->unique();
            $table->text("meta_description")->nullable();
            $table->string("meta_keywords",150)->nullable();
            $table->text("description")->nullable();
            NestedSet::columns($table);
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->on("users")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_catelogues');
    }
};

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->float('price', 10, 2);
            $table->float('discountPercentage', 5, 2);
            $table->string('rating')->nullable();
            $table->bigInteger('stock')->default(0);
            $table->string('brand');
            $table->unsignedBigInteger('categoryId');
            $table->unsignedBigInteger('sub_categoryId');
            $table->unsignedBigInteger('sellerId');
            $table->string('thumbnail')->default(NULL);
            $table->longText('images')->default(NULL);
            $table->timestamps();
            $table->foreign('categoryId')->references('id')->on('categories');
            $table->foreign('sub_categoryId')->references('id')->on('sub_categories');
            $table->foreign('sellerId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

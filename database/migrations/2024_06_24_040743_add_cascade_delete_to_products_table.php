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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['categoryId']);
            $table->dropForeign(['sellerId']);

            // Add foreign keys with cascading delete
            $table->foreign('categoryId')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('sellerId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign keys with cascading delete
            $table->dropForeign(['categoryId']);
            $table->dropForeign(['sellerId']);
            $table->foreign('categoryId')->references('id')->on('sub_categories');
            $table->foreign('sellerId')->references('id')->on('users');
        });
    }
};

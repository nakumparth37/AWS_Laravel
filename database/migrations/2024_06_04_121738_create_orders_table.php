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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Inprogress', 'Pending', 'shipped', 'Out for Delivery', 'Delivered','Cancelled'])->default('pending');
            $table->text('content');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

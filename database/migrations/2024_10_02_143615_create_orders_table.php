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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->double('total', 10,2)->nullable();
            $table->double('discount',10,2)->nullable();
            $table->foreignId('coupon_id')->nullable()->constrained();
            $table->double('grand_total',10.2)->nullable();
            $table->foreignId('payment_method_id')->nullable()->constrained();
            $table->string('payment_number');
            $table->string('transaction_id');
            $table->tinyInteger('payment_status')->default(1);
            $table->tinyInteger('status')->default(1);
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

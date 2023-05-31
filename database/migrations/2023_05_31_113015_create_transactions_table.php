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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('time');
            $table->tinyInteger('status');
            $table->unsignedBigInteger('orderId');
            $table->string('paymentMode')->nullable();
            $table->float('amount');
            $table->string('paymentApp')->nullable();
            $table->string('appReference')->nullable();
            $table->string('bankReference')->nullable();
            $table->unsignedBigInteger('userId');

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('orderId')->references('id')->on('orders');
            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

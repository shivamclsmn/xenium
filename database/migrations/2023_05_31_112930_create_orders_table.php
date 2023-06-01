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
            $table->dateTime('dateCreated');
            $table->tinyInteger('paymentStatus')->comment('partial,complete,failed');
            $table->tinyInteger('orderStatus')->comment('accept,dispatch,shipping,delivered,completed');
            $table->tinyInteger('status')->comment('for generic use in future');
            $table->float('totalAmount');
            $table->boolean('shipping');
            $table->float('discountPercent')->nullable();
            $table->float('discountAmount')->nullable();
            $table->json('partialPayDetails')->nullable();
            $table->unsignedBigInteger('customerId');
            $table->unsignedBigInteger('userId');
            $table->string('remark');

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('customerId')->references('id')->on('customers');
            $table->foreign('userId')->references('id')->on('users');
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

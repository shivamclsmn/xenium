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
        Schema::create('order_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orderId');
            $table->string('actionType')->comment('possible values: Create, Edit etc');
            $table->float('amount')->comment('available amount to be paid at the time of action ');
            $table->json('itemIds');
            $table->dateTime('time');
            $table->float('discountPercent')->nullable();
            $table->float('discountAmount')->nullable();
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
        Schema::dropIfExists('order_logs');
    }
};

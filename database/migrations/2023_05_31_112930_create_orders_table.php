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
            $table->tinyInteger('paymentStatus')->comment('0:nil, 1:complete, 2:partial');
            $table->tinyInteger('orderStatus')->comment('1:accepted, 2:dispatch, 3:shipping, 4:delivered, 5:completed');
            $table->tinyInteger('status')->comment('for generic use in future')->nullable();
            $table->float('totalAmount');
            $table->boolean('shipping')->nullable();
            $table->float('discountPercent')->nullable();
            $table->float('discountAmount')->nullable();
            $table->json('partialPayDetails')->nullable();
            $table->float('paidAmount')->nullable()->comment('total paid out of required totalAmount, can be updated on multiple pays');
            $table->unsignedBigInteger('customerId');
            $table->unsignedBigInteger('userId');
            $table->string('remark')->nullable();
            $table->string('paymentMode',15)->comment('online, cash, cheque');
            $table->string('invoiceId',12)->comment('8 digit format: MMDDXXXX Ex: 05230100');

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

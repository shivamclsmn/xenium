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
        Schema::create('leads', function (Blueprint $table) {
            //enquire person detail
            $table->id();
            $table->string('full_name');
            $table->string('mobile')->unique();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->integer('pincode')->nullable();
            $table->string('city')->nullable();
            $table->string('location')->nullable();
            $table->string('source')->nullable()->defalut('offline');
            $table->boolean('isDealer')->nullable()->default(0);
            $table->boolean('mobile_verified')->nullable()->default(0);
            $table->boolean('email_verified')->nullable()->default(0);
            $table->foreign('customer_id')->references('id')->on('customers')->nullable();
            //lead details
            $table->string('description');
            $table->string('product_ids')->nullable();
            $table->tinyInteger('status');
            $table->date('nextCallingDate')->nullable();
            //user detail
            $table->Integer('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

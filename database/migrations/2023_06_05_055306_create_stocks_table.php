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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productId');
            $table->integer('quantity')->default(0);
            $table->integer('pricePerUnit');
            $table->string('batch',15);
            $table->unsignedBigInteger('vendorId');
            $table->unsignedBigInteger('purchaseId')->nullable();
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('vendorId')->references('id')->on('vendors');
            $table->foreign('productId')->references('id')->on('products');
            $table->foreign('purchaseId')->references('id')->on('purchases');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

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
        Schema::create('purchase_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchaseId');
            $table->unsignedBigInteger('productId');
            $table->integer('pricePerUnit');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('productId')->references('id')->on('products');
            $table->foreign('purchaseId')->references('id')->on('purchases');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_products');
    }
};

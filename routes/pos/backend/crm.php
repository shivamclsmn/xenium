<?php

use App\Http\Controllers\Pos\CRM\CustomersController;
use App\Http\Controllers\Pos\CRM\DealersController;

Route::prefix('pos/dashboard/crm')->group(function () {
    Route::middleware('auth')->group(function () {
        // Customer routes
        Route::get('/customers', [CustomersController::class, 'index'])->name('pos.crm.customers');
        Route::get('/customers/dt', [CustomersController::class, 'show'])->name('pos.crm.customers.table');
        Route::post('/customers/add', [CustomersController::class, 'store'])->name('pos.crm.customers.add');
        Route::get('/customers/show', [CustomersController::class, 'edit'])->name('pos.crm.customers.show');
        Route::post('/customers/delete', [CustomersController::class, 'destroy'])->name('pos.crm.customers.delete');
        Route::post('/customers/update', [CustomersController::class, 'update'])->name('pos.crm.customers.update');

        //Dealer routes
        Route::get('/dealers', [DealersController::class, 'index'])->name('pos.crm.dealers');
        Route::get('/dealers/dt', [DealersController::class, 'show'])->name('pos.crm.dealers.table');
        Route::post('/dealers/add', [DealersController::class, 'store'])->name('pos.crm.dealers.add');
        Route::get('/dealers/show', [DealersController::class, 'edit'])->name('pos.crm.dealers.show');
        Route::post('/dealers/delete', [DealersController::class, 'destroy'])->name('pos.crm.dealers.delete');
        Route::post('/dealers/update', [DealersController::class, 'update'])->name('pos.crm.dealers.update');
    });
});

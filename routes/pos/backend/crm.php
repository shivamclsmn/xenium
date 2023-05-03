<?php

use App\Http\Controllers\Pos\CRM\CustomersController;

Route::prefix('pos/dashboard/crm')->group(function () {
    Route::middleware('auth')->group(function () {
        // Customer routes
        Route::get('/customers', [CustomersController::class, 'index'])->name('pos.crm.customers');
        Route::get('/customers/dt', [CustomersController::class, 'show'])->name('pos.crm.customers.table');
        Route::post('/customers/add', [CustomersController::class, 'store'])->name('pos.crm.customers.add');
        Route::get('/customers/show', [CustomersController::class, 'edit'])->name('pos.crm.customers.show');
        Route::post('/customers/delete', [CustomersController::class, 'destroy'])->name('pos.crm.customers.delete');
        Route::post('/customers/update', [CustomersController::class, 'update'])->name('pos.crm.customers.update');
    });
});

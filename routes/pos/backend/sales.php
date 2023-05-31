<?php

use App\Http\Controllers\Pos\Sales\OrdersController;

Route::prefix('pos/dashboard/sales')->group(function () {
    Route::middleware('auth')->group(function () {
        // Orders routes
        Route::get('/orders', [OrdersController::class, 'index'])->name('pos.sales.orders');
        Route::get('/orders/dt', [OrdersController::class, 'show'])->name('pos.sales.orders.table');
        Route::post('/orders/add', [OrdersController::class, 'store'])->name('pos.sales.orders.add');
        Route::get('/orders/show', [OrdersController::class, 'edit'])->name('pos.sales.orders.show');
        Route::post('/orders/delete', [OrdersController::class, 'destroy'])->name('pos.sales.orders.delete');
        Route::post('/orders/update', [OrdersController::class, 'update'])->name('pos.sales.orders.update');

    });
});

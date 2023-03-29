<?php

use App\Http\Controllers\Pos\HRMS\PositionsController;

Route::prefix('pos/dashboard/hrms')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/positions', [PositionsController::class, 'index'])->name('pos.hrms.positions');
        Route::get('/positions/dt', [PositionsController::class, 'getPositions'])->name('pos.hrms.positions.table');
        Route::post('/positions/add', [PositionsController::class, 'store'])->name('pos.hrms.positions.add');
    });
});

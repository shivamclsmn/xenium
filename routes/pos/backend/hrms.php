<?php

use App\Http\Controllers\Pos\HRMS\PositionsController;

Route::prefix('pos/dashboard/hrms')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/positions', [PositionsController::class, 'index'])->name('pos.hrms.positions');
    });
});

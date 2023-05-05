<?php

use App\Http\Controllers\Pos\Inventory\CategoriesController;
use App\Http\Controllers\Pos\Inventory\SpecificationsController;

Route::prefix('pos/dashboard/inventory')->group(function () {
    Route::middleware('auth')->group(function () {
        // Position routes
        Route::get('/categories', [CategoriesController::class, 'index'])->name('pos.inventory.categories');
        Route::get('/categories/dt', [CategoriesController::class, 'show'])->name('pos.inventory.categories.table');
        Route::post('/categories/add', [CategoriesController::class, 'store'])->name('pos.inventory.categories.add');
        Route::get('/categories/show', [CategoriesController::class, 'edit'])->name('pos.inventory.categories.show');
        Route::post('/categories/delete', [CategoriesController::class, 'destroy'])->name('pos.inventory.categories.delete');
        Route::post('/categories/update', [CategoriesController::class, 'update'])->name('pos.inventory.categories.update');

        // Employee routes
        Route::get('/specifications', [SpecificationsController::class, 'index'])->name('pos.inventory.specifications');
        Route::get('/specifications/dt', [SpecificationsController::class, 'show'])->name('pos.inventory.specifications.table');
        Route::post('/specifications/add', [SpecificationsController::class, 'store'])->name('pos.inventory.specifications.add');
        Route::get('/specifications/show', [SpecificationsController::class, 'edit'])->name('pos.inventory.specifications.show');
        Route::post('/specifications/delete', [SpecificationsController::class, 'destroy'])->name('pos.inventory.specifications.delete');
        Route::post('/specifications/update', [SpecificationsController::class, 'update'])->name('pos.inventory.specifications.update');
    });
});

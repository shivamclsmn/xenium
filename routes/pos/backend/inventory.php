<?php

use App\Http\Controllers\Pos\Inventory\CategoriesController;
use App\Http\Controllers\Pos\Inventory\SpecificationsController;
use App\Http\Controllers\Pos\Inventory\ProductsController;
use App\Http\Controllers\Pos\Inventory\VendorsController;
use App\Http\Controllers\Pos\Inventory\StocksController;

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

        // Products
        Route::get('/products', [ProductsController::class, 'index'])->name('pos.inventory.products');
        Route::get('/products/dt', [ProductsController::class, 'show'])->name('pos.inventory.products.table');
        Route::post('/products/add', [ProductsController::class, 'store'])->name('pos.inventory.products.add');
        Route::get('/products/show', [ProductsController::class, 'edit'])->name('pos.inventory.products.show');
        Route::post('/products/delete', [ProductsController::class, 'destroy'])->name('pos.inventory.products.delete');
        Route::post('/products/update', [ProductsController::class, 'update'])->name('pos.inventory.products.update');
        Route::get('/products/getSpecForm', [ProductsController::class, 'getSpecForm'])->name('pos.inventory.products.getSpecForm');
        Route::post('/products/addUpdateImages', [ProductsController::class, 'addUpdateImages'])->name('pos.inventory.products.addUpdateImages');
        Route::get('/products/getProductImages', [ProductsController::class, 'getProductImages'])->name('pos.inventory.products.getProductImages');
        Route::get('/products/delImage', [ProductsController::class, 'delImage'])->name('pos.inventory.products.delImage');

        //Vendors
        Route::get('/vendors', [VendorsController::class, 'index'])->name('pos.inventory.vendors');
        Route::get('/vendors/dt', [VendorsController::class, 'show'])->name('pos.inventory.vendors.table');
        Route::post('/vendors/add', [VendorsController::class, 'store'])->name('pos.inventory.vendors.add');
        Route::get('/vendors/show', [VendorsController::class, 'edit'])->name('pos.inventory.vendors.show');
        Route::post('/vendors/delete', [VendorsController::class, 'destroy'])->name('pos.inventory.vendors.delete');
        Route::post('/vendors/update', [VendorsController::class, 'update'])->name('pos.inventory.vendors.update');
         //stocks
         Route::get('/stocks', [StocksController::class, 'index'])->name('pos.inventory.stocks');
         Route::get('/stocks/dt', [StocksController::class, 'show'])->name('pos.inventory.stocks.table');
         Route::post('/stocks/add', [StocksController::class, 'store'])->name('pos.inventory.stocks.add');
         Route::get('/stocks/show', [StocksController::class, 'edit'])->name('pos.inventory.stocks.show');
         Route::post('/stocks/delete', [StocksController::class, 'destroy'])->name('pos.inventory.stocks.delete');
         Route::post('/stocks/update', [StocksController::class, 'update'])->name('pos.inventory.stocks.update');
         Route::get('/stocks/getVendorsSearch', [StocksController::class, 'getVendorsSearch'])->name('pos.inventory.stocks.getVendorsSearch');
        //  Route::get('/stocks/getProductsSearch', [StocksController::class, 'getProductsSearch'])->name('pos.inventory.stocks.getProductsSearch');
    });
});

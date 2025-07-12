<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
Route::resource('products', ProductController::class)->except(['create', 'edit']);

Route::post('products/{product}/prices', [PriceController::class, 'store']);

Route::prefix('prices')->group(function () {
    Route::put('{price}', [PriceController::class, 'update']);
    Route::delete('{price}', [PriceController::class, 'destroy']);
});

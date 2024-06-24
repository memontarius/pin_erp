<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store'])->name('product.store');
Route::patch('/products/{product}', [ProductController::class, 'update'])->name('product.update');

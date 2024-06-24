<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

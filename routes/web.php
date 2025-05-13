<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;

// Dashboard

Route::get('/', function () {
    return view('admin.index');
})->name('admin.dashboard');

// Product
Route::prefix('products')->as('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('list');
    Route::post('add-product', [ProductController::class, 'addProduct'])->name('create');
    Route::get('edit-product/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('update-product', [ProductController::class, 'update'])->name('update');
});

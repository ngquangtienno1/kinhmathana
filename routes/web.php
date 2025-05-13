<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PromotionController;

Route::get('/', function () {
    return view('admin.index');
});

Route::get('/products', function () {
    return view('admin.products.index');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Promotion management routes
    Route::get('/promotions/generate-code', [PromotionController::class, 'generateCode'])->name('promotions.generate-code');
    Route::resource('promotions', PromotionController::class);
});

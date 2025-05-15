<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ProductSupportController;

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

Route::get('/admin/products/support', [ProductSupportController::class, 'showForm'])->name('admin.products.support');
Route::post('/admin/products/support', [ProductSupportController::class, 'submitForm']);

Route::get('/admin/products/supports', [ProductSupportController::class, 'index'])->name('admin.products.supports');

Route::get('/admin/products/support-list', [ProductSupportController::class, 'index'])->name('admin.products.support.list');

Route::get('/admin/products/support/{id}', [ProductSupportController::class, 'show'])->name('admin.products.support.show');
Route::get('/admin/products/support/{id}/status', [ProductSupportController::class, 'editStatus'])->name('admin.products.support.editStatus');
Route::post('/admin/products/support/{id}/status', [ProductSupportController::class, 'updateStatus'])->name('admin.products.support.updateStatus');
Route::post('/admin/products/support/{id}/done', [ProductSupportController::class, 'markAsDone'])->name('admin.products.support.done');
Route::delete('/admin/products/support/{id}', [ProductSupportController::class, 'destroy'])->name('admin.products.support.delete');

Route::get('/admin/products/support/{id}/email', [ProductSupportController::class, 'showEmailForm'])->name('admin.products.support.emailForm');
Route::post('/admin/products/support/{id}/email', [ProductSupportController::class, 'sendEmail'])->name('admin.products.support.sendEmail');

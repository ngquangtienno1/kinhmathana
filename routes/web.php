<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ProductSupportController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderStatusHistoryController;

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

    // Order List Route
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Order Status History Routes
    Route::get('/orders/{order}/status-history', [OrderStatusHistoryController::class, 'show'])
        ->name('orders.status.history');
    Route::patch('/orders/{order}/status', [OrderStatusHistoryController::class, 'updateStatus'])
        ->name('orders.status.update');

    // Support routes
    Route::get('/support', [ProductSupportController::class, 'showForm'])->name('support.form');
    Route::post('/support', [ProductSupportController::class, 'submitForm'])->name('support.submit');
    Route::get('/supports', [ProductSupportController::class, 'index'])->name('support.index');
    Route::get('/support-list', [ProductSupportController::class, 'index'])->name('support.list');
    Route::get('/support/{id}', [ProductSupportController::class, 'show'])->name('support.show');
    Route::get('/support/{id}/status', [ProductSupportController::class, 'editStatus'])->name('support.editStatus');
    Route::post('/support/{id}/status', [ProductSupportController::class, 'updateStatus'])->name('support.updateStatus');
    Route::post('/support/{id}/done', [ProductSupportController::class, 'markAsDone'])->name('support.done');
    Route::delete('/support/{id}', [ProductSupportController::class, 'destroy'])->name('support.delete');
    Route::get('/support/{id}/email', [ProductSupportController::class, 'showEmailForm'])->name('support.emailForm');
    Route::post('/support/{id}/email', [ProductSupportController::class, 'sendEmail'])->name('support.sendEmail');
});

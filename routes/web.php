<?php

use App\Http\Controllers\Admin\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PaymentController;


Route::get('/', function () {
    return view('admin.index');
});


Route::get('/products', function () {
    return view('admin.products.index');
});



//Quản lý thanh toán

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('payments', PaymentController::class);
});
Route::patch('admin/payments/{id}/status', [PaymentController::class, 'updateStatus'])->name('admin.payments.updateStatus');
Route::get('admin/payments/{id}/invoice', [PaymentController::class, 'printInvoice'])->name('admin.payments.invoice');


// Quản lý bình luận
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('comments', CommentController::class);
});
Route::patch('admin/comments/toggle-visibility/{id}', [CommentController::class, 'toggleVisibility'])->name('admin.comments.toggleVisibility');

Route::prefix('admin/comments')->name('admin.comments.')->group(function () {
    Route::get('trashed', [CommentController::class, 'trashed'])->name('trashed');
    Route::patch('{id}/restore', [CommentController::class, 'restore'])->name('restore');
    Route::delete('{id}/force-delete', [CommentController::class, 'forceDelete'])->name('forceDelete');
});
Route::patch('admin/comments/{comment}/status', [CommentController::class, 'updateStatus'])->name('admin.comments.updateStatus');


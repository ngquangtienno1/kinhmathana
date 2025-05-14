<?php

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

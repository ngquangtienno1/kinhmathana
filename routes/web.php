<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PaymentController;


Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('postLogin', [AuthenticationController::class, 'postLogin'])->name('postLogin');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('postRegister', [AuthenticationController::class, 'postRegister'])->name('postRegister');

Route::get('/auth/google', [SocialController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [SocialController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);


//Admin
Route::prefix('admin')->name('admin.')->middleware('checkAdmin')->group(function () {

    //User
    Route::get('user', [UserController::class, 'index'])->name('listUser');

    //Product
    Route::get('/products', function () {
        return view('admin.products.index');
    });

    //Slider
    Route::prefix('sliders')->name('sliders.')->group(function () {
        Route::get('/',                [SliderController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [SliderController::class, 'show'])->name('show');
        Route::get('/create',          [SliderController::class, 'create'])->name('create');
        Route::post('/store',          [SliderController::class, 'store'])->name('store');
        Route::get('/{id}/edit',       [SliderController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',     [SliderController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [SliderController::class, 'destroy'])->name('destroy');
        Route::get('/bin',             [SliderController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [SliderController::class, 'restore'])->name('restore');
        Route::delete('/{id}/forceDelete',   [SliderController::class, 'forceDelete'])->name('forceDelete');
        Route::delete('/bulk-delete', [SliderController::class, 'bulkDelete'])->name('bulk-delete');
    });

    //News
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [NewsController::class, 'show'])->name('show');
        Route::get('/create',          [NewsController::class, 'create'])->name('create');
        Route::post('/store',          [NewsController::class, 'store'])->name('store');
        Route::get('/{id}/edit',       [NewsController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',     [NewsController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [NewsController::class, 'destroy'])->name('destroy');
        Route::get('/bin',             [NewsController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [NewsController::class, 'restore'])->name('restore');
        Route::delete('/{id}/forceDelete',   [NewsController::class, 'forceDelete'])->name('forceDelete');
    });

    //Brands
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [BrandController::class, 'show'])->name('show');
        Route::get('/create',          [BrandController::class, 'create'])->name('create');
        Route::post('/store',          [BrandController::class, 'store'])->name('store');
        Route::get('/{id}/edit',       [BrandController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',     [BrandController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [BrandController::class, 'destroy'])->name('destroy');
        Route::get('/bin',             [BrandController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [BrandController::class, 'restore'])->name('restore');
        Route::delete('/{id}/forceDelete',   [BrandController::class, 'forceDelete'])->name('forceDelete');
    });

    // Orders
    Route::resource('orders', OrderController::class);
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/{order}/show', [OrderController::class, 'show'])->name('show');
        Route::put('{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
        Route::put('{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('update-payment-status');
    });

    // Settings - Cao Quốc An
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Quản lý đơn vị vận chuyển
    Route::prefix('shipping')->name('shipping.')->group(function () {
        Route::get('/providers', [App\Http\Controllers\Admin\ShippingProviderController::class, 'index'])->name('providers.index');
        Route::post('/providers', [App\Http\Controllers\Admin\ShippingProviderController::class, 'store'])->name('providers.store');
        Route::put('/providers/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'update'])->name('providers.update');
        Route::delete('/providers/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroy'])->name('providers.destroy');
        Route::post('/providers/{provider}/status', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateStatus'])->name('providers.status');

        // Quản lý phí vận chuyển
        Route::get('/providers/{provider}/fees', [App\Http\Controllers\Admin\ShippingProviderController::class, 'fees'])->name('fees');
        Route::post('/providers/{provider}/fees', [App\Http\Controllers\Admin\ShippingProviderController::class, 'storeFee'])->name('fees.store');
        Route::put('/providers/{provider}/fees/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateFee'])->name('fees.update');
        Route::delete('/providers/{provider}/fees/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroyFee'])->name('fees.destroy');
    });

    // FAQ Routes
    Route::prefix('faqs')->name('faqs.')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('index');
        Route::get('/create', [FaqController::class, 'create'])->name('create');
        Route::post('/store', [FaqController::class, 'store'])->name('store');
        Route::get('/{faq}/edit', [FaqController::class, 'edit'])->name('edit');
        Route::put('/{faq}', [FaqController::class, 'update'])->name('update');
        Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('destroy');
        Route::post('/{faq}/status', [FaqController::class, 'updateStatus'])->name('status');
    });

    //Quản lý thanh toán

    Route::resource('payments', PaymentController::class);
    Route::patch('/payments/{id}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');
    Route::get('/payments/{id}/invoice', [PaymentController::class, 'printInvoice'])->name('payments.invoice');


    // Quản lý bình luận
    Route::resource('comments', CommentController::class);
    Route::patch('/comments/toggle-visibility/{id}', [CommentController::class, 'toggleVisibility'])->name('comments.toggleVisibility');

    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('trashed', [CommentController::class, 'trashed'])->name('trashed');
        Route::patch('{id}/restore', [CommentController::class, 'restore'])->name('restore');
        Route::delete('{id}/force-delete', [CommentController::class, 'forceDelete'])->name('forceDelete');
    });
    Route::patch('/comments/{comment}/status', [CommentController::class, 'updateStatus'])->name('comments.updateStatus');
});
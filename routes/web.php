<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\FaqController;


//Admin
Route::prefix('admin')->name('admin.')->group(function () {


    Route::get('/products', function () {
        return view('admin.products.index');
    });

    //Slider
    Route::prefix('sliders')->name('sliders.')->group(function () {
        Route::resource('/', SliderController::class)->parameters(['' => 'id']);
        Route::get('/bin', [SliderController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore', [SliderController::class, 'restore'])->name('restore');
        Route::delete('/{id}/forceDelete', [SliderController::class, 'forceDelete'])->name('forceDelete');
        Route::delete('/bulk-delete', [SliderController::class, 'bulkDelete'])->name('bulk-delete');
    });

    //News
    Route::prefix('news')->name('news.')->group(function () {
        Route::resource('/', NewsController::class)->parameters(['' => 'id']);
        Route::get('/bin', [NewsController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore', [NewsController::class, 'restore'])->name('restore');
        Route::delete('/{id}/forceDelete', [NewsController::class, 'forceDelete'])->name('forceDelete');
    });

    //Brands
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::resource('/', BrandController::class)->parameters(['' => 'id']);
        Route::get('/bin', [BrandController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore', [BrandController::class, 'restore'])->name('restore');
        Route::delete('/{id}/forceDelete', [BrandController::class, 'forceDelete'])->name('forceDelete');
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
});
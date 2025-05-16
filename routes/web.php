<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;



Route::prefix('admin')->group(function () {
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');



    // Quản lý đơn vị vận chuyển
    Route::prefix('shipping')->group(function () {
        Route::get('/providers', [App\Http\Controllers\Admin\ShippingProviderController::class, 'index'])->name('admin.shipping.providers.index');
        Route::post('/providers', [App\Http\Controllers\Admin\ShippingProviderController::class, 'store'])->name('admin.shipping.providers.store');
        Route::put('/providers/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'update'])->name('admin.shipping.providers.update');
        Route::delete('/providers/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroy'])->name('admin.shipping.providers.destroy');
        Route::post('/providers/{provider}/status', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateStatus'])->name('admin.shipping.providers.status');

        // Quản lý phí vận chuyển
        Route::get('/providers/{provider}/fees', [App\Http\Controllers\Admin\ShippingProviderController::class, 'fees'])->name('admin.shipping.fees');
        Route::post('/providers/{provider}/fees', [App\Http\Controllers\Admin\ShippingProviderController::class, 'storeFee'])->name('admin.shipping.fees.store');
        Route::put('/providers/{provider}/fees/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateFee'])->name('admin.shipping.fees.update');
        Route::delete('/providers/{provider}/fees/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroyFee'])->name('admin.shipping.fees.destroy');
    });

    // FAQ Routes
    Route::get('/faqs', [FaqController::class, 'index'])->name('admin.faqs.index');
    Route::get('/faqs/create', [FaqController::class, 'create'])->name('admin.faqs.create');
    Route::post('/faqs', [FaqController::class, 'store'])->name('admin.faqs.store');
    Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->name('admin.faqs.edit');
    Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('admin.faqs.update');
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('admin.faqs.destroy');
    Route::post('/faqs/{faq}/status', [FaqController::class, 'updateStatus'])->name('admin.faqs.status');
});

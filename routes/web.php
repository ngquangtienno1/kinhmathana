<?php

use Illuminate\Support\Facades\Route;



Route::prefix('admin')->group(function () {
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

    // Upload files
    Route::post('/upload', [App\Http\Controllers\Admin\UploadController::class, 'upload'])->name('admin.upload');
    Route::delete('/upload/{file}', [App\Http\Controllers\Admin\UploadController::class, 'delete'])->name('admin.upload.delete');

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
});

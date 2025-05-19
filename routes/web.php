<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Models\User;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Admin\HomeController;



Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('postLogin', [AuthenticationController::class, 'postLogin'])->name('postLogin');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('postRegister', [AuthenticationController::class, 'postRegister'])->name('postRegister');

Route::get('/auth/google', [SocialController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [SocialController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);




// Admin routes group
Route::prefix('admin')->name('admin.')->middleware(['auth', 'checkAdmin'])->group(function () {
    // Settings routes
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])
        ->name('settings.index')
        ->middleware(['permission:xem-cai-dat']);
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])
        ->name('settings.update')
        ->middleware(['permission:cap-nhat-cai-dat']);

    // Shipping routes
    Route::prefix('shipping')->middleware(['permission:xem-don-vi-van-chuyen'])->group(function () {
        Route::get('/providers', [App\Http\Controllers\Admin\ShippingProviderController::class, 'index'])
            ->name('shipping.providers.index');
        Route::post('/providers', [App\Http\Controllers\Admin\ShippingProviderController::class, 'store'])
            ->name('shipping.providers.store')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::put('/providers/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'update'])
            ->name('shipping.providers.update')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::delete('/providers/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroy'])
            ->name('shipping.providers.destroy')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::post('/providers/{provider}/status', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateStatus'])
            ->name('shipping.providers.status')
            ->middleware(['permission:sua-don-vi-van-chuyen']);

        // Shipping fees routes
        Route::get('/providers/{provider}/fees', [App\Http\Controllers\Admin\ShippingProviderController::class, 'fees'])
            ->name('shipping.fees');
        Route::post('/providers/{provider}/fees', [App\Http\Controllers\Admin\ShippingProviderController::class, 'storeFee'])
            ->name('shipping.fees.store')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::put('/providers/{provider}/fees/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateFee'])
            ->name('shipping.fees.update')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::delete('/providers/{provider}/fees/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroyFee'])
            ->name('shipping.fees.destroy')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
    });

    // FAQ routes
    Route::prefix('faqs')->middleware(['permission:xem-danh-sach-faq'])->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('faqs.index');
        Route::get('/create', [FaqController::class, 'create'])->name('faqs.create')
            ->middleware(['permission:them-faq']);
        Route::post('/', [FaqController::class, 'store'])->name('faqs.store')
            ->middleware(['permission:them-faq']);
        Route::get('/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit')
            ->middleware(['permission:sua-faq']);
        Route::put('/{faq}', [FaqController::class, 'update'])->name('faqs.update')
            ->middleware(['permission:sua-faq']);
        Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy')
            ->middleware(['permission:xoa-faq']);
        Route::post('/{faq}/status', [FaqController::class, 'updateStatus'])->name('faqs.status')
            ->middleware(['permission:sua-faq']);
    });

    // Role Management Routes
    Route::prefix('roles')->middleware(['permission:xem-danh-sach-nguoi-dung'])->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create')
            ->middleware(['permission:sua-nguoi-dung']);
        Route::post('/', [RoleController::class, 'store'])->name('roles.store')
            ->middleware(['permission:sua-nguoi-dung']);
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')
            ->middleware(['permission:sua-nguoi-dung']);
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update')
            ->middleware(['permission:sua-nguoi-dung']);
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')
            ->middleware(['permission:sua-nguoi-dung']);
    });

    // Permission Management Routes
    Route::middleware(['permission:sua-quyen'])->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });


    //User
    Route::get('user', [UserController::class, 'index'])
        ->name('listUser')
        ->middleware(['permission:xem-danh-sach-nguoi-dung']);

    //Product
    Route::get('/products', function () {
        return view('admin.products.index');
    })->middleware(['permission:xem-danh-sach-san-pham']);

    //Slider
    Route::prefix('sliders')->name('sliders.')->middleware(['permission:xem-danh-sach-slider'])->group(function () {
        Route::get('/',                [SliderController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [SliderController::class, 'show'])->name('show');
        Route::get('/create',          [SliderController::class, 'create'])->name('create')
            ->middleware(['permission:them-slider']);
        Route::post('/store',          [SliderController::class, 'store'])->name('store')
            ->middleware(['permission:them-slider']);
        Route::get('/{id}/edit',       [SliderController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-slider']);
        Route::put('/{id}/update',     [SliderController::class, 'update'])->name('update')
            ->middleware(['permission:sua-slider']);
        Route::delete('/{id}/destroy', [SliderController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-slider']);
        Route::get('/bin',             [SliderController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [SliderController::class, 'restore'])->name('restore')
            ->middleware(['permission:sua-slider']);
        Route::delete('/{id}/forceDelete',   [SliderController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-slider']);
        Route::delete('/bulk-delete', [SliderController::class, 'bulkDelete'])->name('bulk-delete')
            ->middleware(['permission:xoa-slider']);
    });

    //News
    Route::prefix('news')->name('news.')->middleware(['permission:xem-news'])->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [NewsController::class, 'show'])->name('show');
        Route::get('/create',          [NewsController::class, 'create'])->name('create')
            ->middleware(['permission:them-news']);
        Route::post('/store',          [NewsController::class, 'store'])->name('store')
            ->middleware(['permission:them-news']);
        Route::get('/{id}/edit',       [NewsController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-news']);
        Route::put('/{id}/update',     [NewsController::class, 'update'])->name('update')
            ->middleware(['permission:sua-news']);
        Route::delete('/{id}/destroy', [NewsController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-news']);
        Route::get('/bin',             [NewsController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [NewsController::class, 'restore'])->name('restore')
            ->middleware(['permission:sua-news']);
        Route::delete('/{id}/forceDelete',   [NewsController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-news']);
    });

    //Brands
    Route::prefix('brands')->name('brands.')->middleware(['permission:xem-danh-sach-thuong-hieu'])->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [BrandController::class, 'show'])->name('show');
        Route::get('/create',          [BrandController::class, 'create'])->name('create')
            ->middleware(['permission:them-thuong-hieu']);
        Route::post('/store',          [BrandController::class, 'store'])->name('store')
            ->middleware(['permission:them-thuong-hieu']);
        Route::get('/{id}/edit',       [BrandController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-thuong-hieu']);
        Route::put('/{id}/update',     [BrandController::class, 'update'])->name('update')
            ->middleware(['permission:sua-thuong-hieu']);
        Route::delete('/{id}/destroy', [BrandController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-thuong-hieu']);
        Route::get('/bin',             [BrandController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [BrandController::class, 'restore'])->name('restore')
            ->middleware(['permission:sua-thuong-hieu']);
        Route::delete('/{id}/forceDelete',   [BrandController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-thuong-hieu']);
    });

    // Orders
    Route::resource('orders', OrderController::class)->middleware(['permission:xem-danh-sach-don-hang']);
    Route::prefix('orders')->name('orders.')->middleware(['permission:xem-danh-sach-don-hang'])->group(function () {
        Route::get('/{order}/show', [OrderController::class, 'show'])->name('show');
        Route::put('{order}/status', [OrderController::class, 'updateStatus'])->name('update-status')
            ->middleware(['permission:cap-nhat-trang-thai-don-hang']);
        Route::put('{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('update-payment-status')
            ->middleware(['permission:cap-nhat-trang-thai-don-hang']);
    });
});

<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Admin\PermissionController;



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
        ->middleware(['permission:view-settings']);
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])
        ->name('settings.update')
        ->middleware(['permission:update-settings']);

    // Shipping routes
    Route::prefix('shipping')->middleware(['permission:view-shipping'])->group(function () {
        Route::get('/providers', [App\Http\Controllers\Admin\ShippingProviderController::class, 'index'])
            ->name('shipping.providers.index');
        Route::post('/providers', [App\Http\Controllers\Admin\ShippingProviderController::class, 'store'])
            ->name('shipping.providers.store')
            ->middleware(['permission:edit-shipping']);
        Route::put('/providers/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'update'])
            ->name('shipping.providers.update')
            ->middleware(['permission:edit-shipping']);
        Route::delete('/providers/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroy'])
            ->name('shipping.providers.destroy')
            ->middleware(['permission:edit-shipping']);
        Route::post('/providers/{provider}/status', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateStatus'])
            ->name('shipping.providers.status')
            ->middleware(['permission:edit-shipping']);

        // Shipping fees routes
        Route::get('/providers/{provider}/fees', [App\Http\Controllers\Admin\ShippingProviderController::class, 'fees'])
            ->name('shipping.fees');
        Route::post('/providers/{provider}/fees', [App\Http\Controllers\Admin\ShippingProviderController::class, 'storeFee'])
            ->name('shipping.fees.store')
            ->middleware(['permission:edit-shipping']);
        Route::put('/providers/{provider}/fees/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateFee'])
            ->name('shipping.fees.update')
            ->middleware(['permission:edit-shipping']);
        Route::delete('/providers/{provider}/fees/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroyFee'])
            ->name('shipping.fees.destroy')
            ->middleware(['permission:edit-shipping']);
    });

    // FAQ routes
    Route::prefix('faqs')->middleware(['permission:view-faqs'])->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('faqs.index');
        Route::get('/create', [FaqController::class, 'create'])->name('faqs.create')
            ->middleware(['permission:create-faqs']);
        Route::post('/', [FaqController::class, 'store'])->name('faqs.store')
            ->middleware(['permission:create-faqs']);
        Route::get('/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit')
            ->middleware(['permission:edit-faqs']);
        Route::put('/{faq}', [FaqController::class, 'update'])->name('faqs.update')
            ->middleware(['permission:edit-faqs']);
        Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy')
            ->middleware(['permission:delete-faqs']);
        Route::post('/{faq}/status', [FaqController::class, 'updateStatus'])->name('faqs.status')
            ->middleware(['permission:edit-faqs']);
    });

    // Role Management Routes
    Route::prefix('roles')->middleware(['permission:view-users'])->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create')
            ->middleware(['permission:edit-users']);
        Route::post('/', [RoleController::class, 'store'])->name('roles.store')
            ->middleware(['permission:edit-users']);
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')
            ->middleware(['permission:edit-users']);
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update')
            ->middleware(['permission:edit-users']);
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')
            ->middleware(['permission:edit-users']);
    });

    // Permission Management Routes
    Route::middleware(['permission:edit-permissions'])->group(function () {
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
        ->middleware(['permission:view-users']);

    //Product
    Route::get('/products', function () {
        return view('admin.products.index');
    })->middleware(['permission:view-products']);

    //Slider
    Route::prefix('sliders')->name('sliders.')->middleware(['permission:view-sliders'])->group(function () {
        Route::get('/',                [SliderController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [SliderController::class, 'show'])->name('show');
        Route::get('/create',          [SliderController::class, 'create'])->name('create')
            ->middleware(['permission:create-sliders']);
        Route::post('/store',          [SliderController::class, 'store'])->name('store')
            ->middleware(['permission:create-sliders']);
        Route::get('/{id}/edit',       [SliderController::class, 'edit'])->name('edit')
            ->middleware(['permission:edit-sliders']);
        Route::put('/{id}/update',     [SliderController::class, 'update'])->name('update')
            ->middleware(['permission:edit-sliders']);
        Route::delete('/{id}/destroy', [SliderController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:delete-sliders']);
        Route::get('/bin',             [SliderController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [SliderController::class, 'restore'])->name('restore')
            ->middleware(['permission:edit-sliders']);
        Route::delete('/{id}/forceDelete',   [SliderController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:delete-sliders']);
        Route::delete('/bulk-delete', [SliderController::class, 'bulkDelete'])->name('bulk-delete')
            ->middleware(['permission:delete-sliders']);
    });

    //News
    Route::prefix('news')->name('news.')->middleware(['permission:view-news'])->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [NewsController::class, 'show'])->name('show');
        Route::get('/create',          [NewsController::class, 'create'])->name('create')
            ->middleware(['permission:create-news']);
        Route::post('/store',          [NewsController::class, 'store'])->name('store')
            ->middleware(['permission:create-news']);
        Route::get('/{id}/edit',       [NewsController::class, 'edit'])->name('edit')
            ->middleware(['permission:edit-news']);
        Route::put('/{id}/update',     [NewsController::class, 'update'])->name('update')
            ->middleware(['permission:edit-news']);
        Route::delete('/{id}/destroy', [NewsController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:delete-news']);
        Route::get('/bin',             [NewsController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [NewsController::class, 'restore'])->name('restore')
            ->middleware(['permission:edit-news']);
        Route::delete('/{id}/forceDelete',   [NewsController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:delete-news']);
    });

    //Brands
    Route::prefix('brands')->name('brands.')->middleware(['permission:view-brands'])->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [BrandController::class, 'show'])->name('show');
        Route::get('/create',          [BrandController::class, 'create'])->name('create')
            ->middleware(['permission:create-brands']);
        Route::post('/store',          [BrandController::class, 'store'])->name('store')
            ->middleware(['permission:create-brands']);
        Route::get('/{id}/edit',       [BrandController::class, 'edit'])->name('edit')
            ->middleware(['permission:edit-brands']);
        Route::put('/{id}/update',     [BrandController::class, 'update'])->name('update')
            ->middleware(['permission:edit-brands']);
        Route::delete('/{id}/destroy', [BrandController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:delete-brands']);
        Route::get('/bin',             [BrandController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [BrandController::class, 'restore'])->name('restore')
            ->middleware(['permission:edit-brands']);
        Route::delete('/{id}/forceDelete',   [BrandController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:delete-brands']);
    });

    // Orders
    Route::resource('orders', OrderController::class)->middleware(['permission:view-orders']);
    Route::prefix('orders')->name('orders.')->middleware(['permission:view-orders'])->group(function () {
        Route::get('/{order}/show', [OrderController::class, 'show'])->name('show');
        Route::put('{order}/status', [OrderController::class, 'updateStatus'])->name('update-status')
            ->middleware(['permission:edit-orders']);
        Route::put('{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('update-payment-status')
            ->middleware(['permission:edit-orders']);
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
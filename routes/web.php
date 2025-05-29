<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ProductSupportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\VariationImageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VariationController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CancellationReasonController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderStatusHistoryController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\NewsCategoryController;

// Redirect login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.home');
    }
    return redirect()->route('login');
});

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

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])
        ->name('settings.index')
        ->middleware(['permission:xem-cai-dat']);
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])
        ->name('settings.update')
        ->middleware(['permission:cap-nhat-cai-dat']);

    // FAQ routes
    Route::prefix('faqs')->middleware(['permission:xem-danh-sach-faq'])->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('faqs.index');
        Route::get('/create', [FaqController::class, 'create'])->name('faqs.create')
            ->middleware(['permission:them-faq']);
        Route::post('/', [FaqController::class, 'store'])->name('faqs.store')
            ->middleware(['permission:them-faq']);
        Route::delete('bulk-destroy', [FaqController::class, 'bulkDestroy'])->name('faqs.bulkDestroy')
            ->middleware(['permission:xoa-nhieu-faq']);
        Route::get('/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit')
            ->middleware(['permission:sua-faq']);
        Route::get('/{faq}/show', [FaqController::class, 'show'])->name('faqs.show')
            ->middleware(['permission:xem-danh-sach-faq']);
        Route::put('/{faq}', [FaqController::class, 'update'])->name('faqs.update')
            ->middleware(['permission:sua-faq']);
        Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy')
            ->middleware(['permission:xoa-faq']);
        Route::post('/{faq}/status', [FaqController::class, 'updateStatus'])->name('faqs.status')
            ->middleware(['permission:sua-faq']);
    });

    // Role Management Routes
    Route::prefix('roles')->middleware(['permission:xem-danh-sach-vai-tro'])->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create')
            ->middleware(['permission:them-vai-tro']);
        Route::post('/', [RoleController::class, 'store'])->name('roles.store')
            ->middleware(['permission:them-vai-tro']);
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')
            ->middleware(['permission:sua-vai-tro']);
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update')
            ->middleware(['permission:sua-vai-tro']);
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')
            ->middleware(['permission:xoa-vai-tro']);
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

    // User Management
    Route::prefix('users')->name('users.')->middleware(['permission:xem-danh-sach-nguoi-dung'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}/show', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-nguoi-dung']);
        Route::put('/{id}/update', [UserController::class, 'update'])->name('update')
            ->middleware(['permission:sua-nguoi-dung']);
        Route::delete('/{id}/destroy', [UserController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-nguoi-dung']);
    });

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

        // Shipping fees routess
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

    // Product Management
    Route::prefix('products')->name('products.')->middleware(['permission:xem-danh-sach-san-pham'])->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('list');
        Route::get('/{id}/show', [ProductController::class, 'show'])->name('show');
        Route::get('/create', [ProductController::class, 'create'])->name('create')
            ->middleware(['permission:them-san-pham']);
        Route::post('store', [ProductController::class, 'store'])->name('store')
            ->middleware(['permission:them-san-pham']);
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-san-pham']);
        Route::put('update/{id}', [ProductController::class, 'update'])->name('update')
            ->middleware(['permission:sua-san-pham']);
        Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-san-pham']);
        Route::get('bin', [ProductController::class, 'bin'])->name('bin');
        Route::put('restore/{id}', [ProductController::class, 'restore'])->name('restore')
            ->middleware(['permission:khoi-phuc-san-pham']);
        Route::delete('forceDelete/{id}', [ProductController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-vinh-vien-san-pham']);
        Route::delete('bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete')
            ->middleware(['permission:xoa-nhieu-san-pham']);
        Route::delete('/bulk-delete', [App\Http\Controllers\Admin\ProductController::class, 'bulkDestroy'])->name('bulkDestroy');
        Route::post('/bulk-restore', [App\Http\Controllers\Admin\ProductController::class, 'bulkRestore'])->name('bulkRestore');
        Route::delete('/bulk-force-delete', [App\Http\Controllers\Admin\ProductController::class, 'bulkForceDelete'])->name('bulkForceDelete');
    });

    // Product Images
    Route::prefix('product_images')->name('product_images.')->middleware(['permission:xem-anh-san-pham'])->group(function () {
        Route::get('/{product}', [ProductImageController::class, 'index'])->name('index');
        Route::get('/{product}/create', [ProductImageController::class, 'create'])->name('create')
            ->middleware(['permission:them-anh-san-pham']);
        Route::post('/{product}', [ProductImageController::class, 'store'])->name('store')
            ->middleware(['permission:them-anh-san-pham']);
        Route::get('/{product}/{id}/edit', [ProductImageController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-anh-san-pham']);
        Route::put('/{product}/{id}', [ProductImageController::class, 'update'])->name('update')
            ->middleware(['permission:sua-anh-san-pham']);
        Route::delete('/{product}/{id}', [ProductImageController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-anh-san-pham']);
        Route::post('/{product}/{id}/thumbnail', [ProductImageController::class, 'setThumbnail'])->name('setThumbnail')
            ->middleware(['permission:dat-anh-dai-dien']);
    });

    // Variations
    Route::prefix('variations')->name('variations.')->middleware(['permission:xem-bien-the'])->group(function () {
        Route::get('/', [VariationController::class, 'index'])->name('index');
        Route::get('/create', [VariationController::class, 'create'])->name('create')
            ->middleware(['permission:them-bien-the']);
        Route::post('/store', [VariationController::class, 'store'])->name('store')
            ->middleware(['permission:them-bien-the']);
        Route::get('/{variation}/show', [VariationController::class, 'show'])->name('show');
        Route::get('/{variation}/edit', [VariationController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-bien-the']);
        Route::put('/{variation}/update', [VariationController::class, 'update'])->name('update')
            ->middleware(['permission:sua-bien-the']);
        Route::delete('/{variation}/destroy', [VariationController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-bien-the']);
        Route::get('/bin', [VariationController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore', [VariationController::class, 'restore'])->name('restore')
            ->middleware(['permission:khoi-phuc-bien-the']);
        Route::delete('/{id}/forceDelete', [VariationController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-vinh-vien-bien-the']);
    });

    // Variations Images
    Route::prefix('variation_images')->name('variation_images.')->middleware(['permission:xem-anh-bien-the'])->group(function () {
        Route::get('/{variation}', [VariationImageController::class, 'index'])->name('index');
        Route::get('/{variation}/create', [VariationImageController::class, 'create'])->name('create')
            ->middleware(['permission:them-anh-bien-the']);
        Route::post('/{variation}', [VariationImageController::class, 'store'])->name('store')
            ->middleware(['permission:them-anh-bien-the']);
        Route::delete('/{variation}/{id}', [VariationImageController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-anh-bien-the']);
        Route::post('/{variation}/{id}/thumbnail', [VariationImageController::class, 'setThumbnail'])->name('setThumbnail')
            ->middleware(['permission:dat-anh-dai-dien-bien-the']);
    });

    // Color
    Route::prefix('colors')->name('colors.')->middleware(['permission:xem-mau-sac'])->group(function () {
        Route::get('/', [ColorController::class, 'index'])->name('index');
        Route::get('/create', [ColorController::class, 'create'])->name('create')
            ->middleware(['permission:them-mau-sac']);
        Route::post('/', [ColorController::class, 'store'])->name('store')
            ->middleware(['permission:them-mau-sac']);
        Route::get('/{id}/edit', [ColorController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-mau-sac']);
        Route::put('/{id}/update', [ColorController::class, 'update'])->name('update')
            ->middleware(['permission:sua-mau-sac']);
        Route::delete('/{id}/destroy', [ColorController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-mau-sac']);
    });

    // Sizes
    Route::prefix('sizes')->name('sizes.')->middleware(['permission:xem-kich-thuoc'])->group(function () {
        Route::get('/', [SizeController::class, 'index'])->name('index');
        Route::get('/create', [SizeController::class, 'create'])->name('create')
            ->middleware(['permission:them-kich-thuoc']);
        Route::post('/', [SizeController::class, 'store'])->name('store')
            ->middleware(['permission:them-kich-thuoc']);
        Route::get('/{id}/edit', [SizeController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-kich-thuoc']);
        Route::put('/{id}/update', [SizeController::class, 'update'])->name('update')
            ->middleware(['permission:sua-kich-thuoc']);
        Route::delete('/{id}/destroy', [SizeController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-kich-thuoc']);
    });

    // Category
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('bin', [CategoryController::class, 'bin'])->name('bin');
        Route::put('restore/{id}', [CategoryController::class, 'restore'])->name('restore');
        Route::delete('forceDelete/{id}', [CategoryController::class, 'forceDelete'])->name('forceDelete');
    });

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
        Route::delete('/bulk-delete', [SliderController::class, 'bulkDestroy'])->name('bulkDestroy')
            ->middleware(['permission:xoa-nhieu-slider']);
        Route::post('/bulk-restore', [SliderController::class, 'bulkRestore'])->name('bulkRestore');
        Route::delete('/bulk-force-delete', [SliderController::class, 'bulkForceDelete'])->name('bulkForceDelete');
    });

    // News routes
    Route::prefix('news')->name('news.')->middleware(['permission:xem-news'])->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/{news}/show', [NewsController::class, 'show'])->name('show');
        Route::get('/create', [NewsController::class, 'create'])->name('create')
            ->middleware(['permission:them-news']);
        Route::post('/store', [NewsController::class, 'store'])->name('store')
            ->middleware(['permission:them-news']);
        Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-news']);
        Route::put('/{news}/update', [NewsController::class, 'update'])->name('update')
            ->middleware(['permission:sua-news']);
        Route::delete('/{news}/destroy', [NewsController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-news']);
        Route::get('/bin', [NewsController::class, 'bin'])->name('bin');
        Route::put('/{news}/restore', [NewsController::class, 'restore'])->name('restore')
            ->middleware(['permission:sua-news']);
        Route::delete('/{news}/forceDelete', [NewsController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-news']);
        Route::delete('/bulk-delete', [NewsController::class, 'bulkDestroy'])->name('bulkDestroy')
            ->middleware(['permission:xoa-nhieu-news']);
        Route::post('/bulk-restore', [NewsController::class, 'bulkRestore'])->name('bulkRestore');
        Route::delete('/bulk-force-delete', [NewsController::class, 'bulkForceDelete'])->name('bulkForceDelete');
    });

    //News Categories
    Route::prefix('news/categories')->name('news.categories.')->middleware(['permission:xem-danh-muc-tin-tuc'])->group(function () {
        Route::get('/', [NewsCategoryController::class, 'index'])->name('index');
        Route::get('/create', [NewsCategoryController::class, 'create'])->name('create')
            ->middleware(['permission:them-danh-muc-tin-tuc']);
        Route::post('/store', [NewsCategoryController::class, 'store'])->name('store')
            ->middleware(['permission:them-danh-muc-tin-tuc']);
        Route::get('/{category}/edit', [NewsCategoryController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-danh-muc-tin-tuc']);
        Route::put('/{category}/update', [NewsCategoryController::class, 'update'])->name('update')
            ->middleware(['permission:sua-danh-muc-tin-tuc']);
        Route::delete('/{category}/destroy', [NewsCategoryController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-danh-muc-tin-tuc']);
        Route::get('/bin', [NewsCategoryController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore', [NewsCategoryController::class, 'restore'])->name('restore')
            ->middleware(['permission:khoi-phuc-danh-muc-tin-tuc']);
        Route::delete('/{id}/forceDelete', [NewsCategoryController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-vinh-vien-danh-muc-tin-tuc']);
        Route::delete('/bulk-delete', [NewsCategoryController::class, 'bulkDestroy'])->name('bulkDestroy')
            ->middleware(['permission:xoa-nhieu-danh-muc-tin-tuc']);
        Route::post('/bulk-restore', [NewsCategoryController::class, 'bulkRestore'])->name('bulkRestore')
            ->middleware(['permission:khoi-phuc-danh-muc-tin-tuc']);
        Route::delete('/bulk-force-delete', [NewsCategoryController::class, 'bulkForceDelete'])->name('bulkForceDelete')
            ->middleware(['permission:xoa-vinh-vien-danh-muc-tin-tuc']);
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
        Route::delete('/bulk-delete', [BrandController::class, 'bulkDestroy'])->name('bulkDestroy')
            ->middleware(['permission:xoa-nhieu-thuong-hieu']);
        Route::post('/bulk-restore', [BrandController::class, 'bulkRestore'])->name('bulkRestore');
        Route::delete('/bulk-force-delete', [BrandController::class, 'bulkForceDelete'])->name('bulkForceDelete');
    });

    // Lý do huỷ đơn
    Route::prefix('cancellation-reasons')->name('cancellation_reasons.')->middleware(['permission:xem-ly-do-huy-don'])->group(function () {
        Route::get('/', [CancellationReasonController::class, 'index'])->name('index');
        Route::get('/{id}/show', [CancellationReasonController::class, 'show'])->name('show');
        Route::get('/create', [CancellationReasonController::class, 'create'])->name('create')
            ->middleware(['permission:them-ly-do-huy-don']);
        Route::post('/store', [CancellationReasonController::class, 'store'])->name('store')
            ->middleware(['permission:them-ly-do-huy-don']);
        Route::get('/{id}/edit', [CancellationReasonController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-ly-do-huy-don']);
        Route::put('/{id}/update', [CancellationReasonController::class, 'update'])->name('update')
            ->middleware(['permission:sua-ly-do-huy-don']);
        Route::delete('/{id}/destroy', [CancellationReasonController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-ly-do-huy-don']);
        Route::get('/bin', [CancellationReasonController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore', [CancellationReasonController::class, 'restore'])->name('restore')
            ->middleware(['permission:khoi-phuc-ly-do-huy-don']);
        Route::delete('/{id}/forceDelete', [CancellationReasonController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-vinh-vien-ly-do-huy-don']);
        Route::delete('/bulk-delete', [CancellationReasonController::class, 'bulkDestroy'])->name('bulkDestroy')
            ->middleware(['permission:xoa-nhieu-ly-do-huy-don']);
        Route::post('/bulk-restore', [CancellationReasonController::class, 'bulkRestore'])->name('bulkRestore');
        Route::delete('/bulk-force-delete', [CancellationReasonController::class, 'bulkForceDelete'])->name('bulkForceDelete');
    });

    // Order Management
    Route::prefix('orders')->name('orders.')->middleware(['permission:xem-danh-sach-don-hang'])->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}/show', [OrderController::class, 'show'])->name('show');
        Route::put('{order}/status', [OrderController::class, 'updateStatus'])->name('update-status')
            ->middleware(['permission:cap-nhat-trang-thai-don-hang']);
        Route::put('{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('update-payment-status')
            ->middleware(['permission:cap-nhat-trang-thai-don-hang']);

        // Order Status History Routes
        Route::get('status/histories', [OrderStatusHistoryController::class, 'index'])->name('status_histories.index');
    });

    // Reviews
    Route::prefix('reviews')->name('reviews.')->middleware(['permission:xem-danh-sach-danh-gia'])->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::delete('bulk-destroy', [ReviewController::class, 'bulkDestroy'])->name('bulkDestroy')
            ->middleware(['permission:xoa-nhieu-danh-gia']);
        Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-danh-gia']);
    });

    //Quản lý thanh toán
    Route::prefix('payments')->name('payments.')->middleware(['permission:xem-thanh-toan'])->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/{id}', [PaymentController::class, 'show'])->name('show');
        Route::patch('/{id}/status', [PaymentController::class, 'updateStatus'])->name('updateStatus')
            ->middleware(['permission:cap-nhat-trang-thai-thanh-toan']);
        Route::get('/{id}/invoice', [PaymentController::class, 'printInvoice'])->name('invoice')
            ->middleware(['permission:in-hoa-don']);
    });

    // Quản lý bình luận
    Route::prefix('comments')->name('comments.')->middleware(['permission:xem-binh-luan'])->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index');
        Route::post('/', [CommentController::class, 'store'])->name('store')
            ->middleware(['permission:them-binh-luan']);
        Route::get('/{id}/edit', [CommentController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-binh-luan']);
        Route::put('/{id}', [CommentController::class, 'update'])->name('update')
            ->middleware(['permission:sua-binh-luan']);
        Route::delete('/{id}', [CommentController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-binh-luan']);
        Route::get('trashed', [CommentController::class, 'trashed'])->name('trashed');
        Route::patch('{id}/restore', [CommentController::class, 'restore'])->name('restore')
            ->middleware(['permission:khoi-phuc-binh-luan']);
        Route::delete('{id}/force-delete', [CommentController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-vinh-vien-binh-luan']);
        Route::patch('/{comment}/status', [CommentController::class, 'updateStatus'])->name('updateStatus')
            ->middleware(['permission:an-hien-binh-luan']);
        Route::patch('/{id}/toggle-visibility', [CommentController::class, 'toggleVisibility'])
            ->name('toggle-visibility')
            ->middleware(['permission:an-hien-binh-luan']);
    });

    // Khuyến mãi
    Route::prefix('promotions')->name('promotions.')->middleware(['permission:xem-danh-sach-khuyen-mai'])->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('index');
        Route::get('/create', [PromotionController::class, 'create'])->name('create');
        Route::post('/', [PromotionController::class, 'store'])->name('store');
        Route::delete('/bulk-delete', [PromotionController::class, 'bulkDestroy'])->name('bulkDestroy')
            ->middleware(['permission:xoa-nhieu-khuyen-mai']);
        Route::get('/generate-code', [PromotionController::class, 'generateCode'])->name('generate-code');
        Route::get('/{promotion}', [PromotionController::class, 'show'])->name('show');
        Route::get('/{promotion}/edit', [PromotionController::class, 'edit'])->name('edit');
        Route::put('/{promotion}', [PromotionController::class, 'update'])->name('update');
        Route::delete('/{promotion}', [PromotionController::class, 'destroy'])->name('destroy');
    });

    Route::patch('/comments/{comment}/status', [CommentController::class, 'updateStatus'])->name('comments.updateStatus');
    // Quản lý bad words trong CommentController luôn
    Route::get('comments/badwords', [CommentController::class, 'badWordsIndex'])->name('comments.badwords.index');
    Route::post('comments/badwords', [CommentController::class, 'badWordsStore'])->name('comments.badwords.store');
    Route::delete('comments/badwords/{badword}', [CommentController::class, 'badWordsDestroy'])->name('comments.badwords.destroy');
    Route::middleware(['auth'])->group(function () {
        Route::get('comments/scan-badwords', [CommentController::class, 'updateCommentsStatusAndBanUsers'])->name('comments.scan_badwords');
    });

    // Quản lý ticket
    Route::prefix('tickets')->name('tickets.')->middleware(['permission:xem-ticket'])->group(function () {
        // Danh sách và xem chi tiết
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/{id}', [TicketController::class, 'show'])->name('show');
        Route::get('/trashed', [TicketController::class, 'trashed'])
            ->name('trashed')->middleware('permission:xem-thung-rac-ticket');
        Route::get('/{id}/edit', [TicketController::class, 'edit'])
            ->name('edit')->middleware('permission:sua-ticket');
        Route::put('/{id}', [TicketController::class, 'update'])
            ->name('update')->middleware('permission:sua-ticket');
        Route::delete('/{id}', [TicketController::class, 'destroy'])
            ->name('destroy')->middleware('permission:xoa-ticket');
        Route::patch('/{id}/restore', [TicketController::class, 'restore'])
            ->name('restore')->middleware('permission:khoi-phuc-ticket');
        Route::delete('/{id}/force-delete', [TicketController::class, 'forceDelete'])
            ->name('forceDelete')->middleware('permission:xoa-vinh-vien-ticket');
        Route::patch('/{id}/toggle-visibility', [TicketController::class, 'toggleVisibility'])
            ->name('toggleVisibility')->middleware('permission:an-hien-ticket');
        Route::post('ticket-notes', [TicketController::class, 'storeNote'])->name('ticket-notes.store');
        Route::delete('/notes/{id}', [TicketController::class, 'deleteNote'])->name('ticket-notes.delete');

        Route::post('/{ticket}/messages', [TicketController::class, 'storeMessage'])->name('messages.store');
    });

    // Support routes
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [ProductSupportController::class, 'showForm'])->name('index');
        Route::get('/list', [ProductSupportController::class, 'index'])->name('list');
        Route::get('/create', [ProductSupportController::class, 'showForm'])->name('create');
        Route::post('/', [ProductSupportController::class, 'submitForm'])->name('store');
        Route::get('/{support}', [ProductSupportController::class, 'show'])->name('show');
        Route::patch('/{support}/status', [ProductSupportController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/{support}/done', [ProductSupportController::class, 'markAsDone'])->name('done');
        Route::delete('/{support}', [ProductSupportController::class, 'destroy'])->name('destroy');
        Route::get('/{support}/email', [ProductSupportController::class, 'showEmailForm'])->name('emailForm');
        Route::post('/{support}/send-email', [ProductSupportController::class, 'sendEmail'])->name('sendEmail');
        Route::get('/{support}/edit-status', [ProductSupportController::class, 'editStatus'])->name('editStatus');
    });
    // Customer Management
    Route::prefix('customers')->name('customers.')->middleware(['permission:xem-danh-sach-khach-hang'])->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update')
            ->middleware(['permission:cap-nhat-thong-tin-khach-hang']);
        Route::patch('/{customer}/type', [CustomerController::class, 'updateType'])->name('update-type')
            ->middleware(['permission:sua-loai-khach-hang']);
    });

    // Global search route
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/search/results', [SearchController::class, 'searchResults'])->name('search.results');
    // Payment Methods
    Route::prefix('payment-methods')->name('payment_methods.')->middleware(['permission:xem-danh-sach-phuong-thuc-thanh-toan'])->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [\App\Http\Controllers\Admin\PaymentMethodController::class, 'show'])->name('show');
        Route::get('/create',          [\App\Http\Controllers\Admin\PaymentMethodController::class, 'create'])->name('create')->middleware(['permission:them-phuong-thuc-thanh-toan']);
        Route::post('/store',          [\App\Http\Controllers\Admin\PaymentMethodController::class, 'store'])->name('store')->middleware(['permission:them-phuong-thuc-thanh-toan']);
        Route::get('/{id}/edit',       [\App\Http\Controllers\Admin\PaymentMethodController::class, 'edit'])->name('edit')->middleware(['permission:sua-phuong-thuc-thanh-toan']);
        Route::put('/{id}/update',     [\App\Http\Controllers\Admin\PaymentMethodController::class, 'update'])->name('update')->middleware(['permission:sua-phuong-thuc-thanh-toan']);
        Route::delete('/{id}/destroy', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-phuong-thuc-thanh-toan']);
        Route::get('/bin',             [\App\Http\Controllers\Admin\PaymentMethodController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore',    [\App\Http\Controllers\Admin\PaymentMethodController::class, 'restore'])->name('restore')->middleware(['permission:sua-phuong-thuc-thanh-toan']);
        Route::delete('/{id}/forceDelete',   [\App\Http\Controllers\Admin\PaymentMethodController::class, 'forceDelete'])->name('forceDelete')->middleware(['permission:xoa-phuong-thuc-thanh-toan']);
        Route::delete('/bulk-delete', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'bulkDestroy'])->name('bulkDestroy')->middleware(['permission:xoa-nhieu-phuong-thuc-thanh-toan']);
        Route::post('/bulk-restore', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'bulkRestore'])->name('bulkRestore')->middleware(['permission:sua-phuong-thuc-thanh-toan']);
        Route::delete('/bulk-force-delete', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'bulkForceDelete'])->name('bulkForceDelete')->middleware(['permission:xoa-phuong-thuc-thanh-toan']);
    });

    // User profile routes
    Route::get('/profile/{id?}', [UserController::class, 'profile'])->name('users.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('users.updateProfile');
});
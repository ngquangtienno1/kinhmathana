<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\VariationImageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
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

// Redirect login
Route::get('/', function () {
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
    Route::get('user', [UserController::class, 'index'])
        ->name('listUser')
        ->middleware(['permission:xem-danh-sach-nguoi-dung']);

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

    //Product
    Route::get('/products', function () {
        return view('admin.products.index');
    })->middleware(['permission:xem-danh-sach-san-pham']);
    // Product
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
    });
});

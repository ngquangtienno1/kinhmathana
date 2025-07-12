<?php

// ================== Client Controllers ==================
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Client\VoucherController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\FaqClientController;
use App\Http\Controllers\Client\HomeController as ClientHomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\ContactController as ClientContactController;

// ================== Admin Controllers ===================
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\SphericalController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CylindricalController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\CustomerSupportController;
use App\Http\Controllers\Admin\ShippingProviderController;

// Authentication

use App\Http\Controllers\Admin\CancellationReasonController;
use App\Http\Controllers\Admin\OrderStatusHistoryController;

// Authentication
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AuthenticationClientController;

// Redirect login
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if (in_array($user->role_id, [1, 2])) {
            return redirect()->route('admin.home');
        } else if ($user->role_id == 3) {
            return redirect()->route('client.home');
        }
    }
    return redirect()->route('client.login');
});


// Authentication routes
Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('postLogin', [AuthenticationController::class, 'postLogin'])->name('postLogin');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('postRegister', [AuthenticationController::class, 'postRegister'])->name('postRegister');


// Social login routes
Route::get('/auth/google', [SocialController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [SocialController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

// Client routes group
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/', [ClientHomeController::class, 'index'])->name('home');

    Route::get('login', [AuthenticationClientController::class, 'login'])->name('login');
    Route::post('postLogin', [AuthenticationClientController::class, 'postLogin'])->name('postLogin');
    Route::get('logout', [AuthenticationClientController::class, 'logout'])->name('logout');
    Route::get('register', [AuthenticationClientController::class, 'register'])->name('register');
    Route::post('postRegister', [AuthenticationClientController::class, 'postRegister'])->name('postRegister');

    //Users routes 
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('index');
        Route::get('information',[ UserController::class, 'profile'])->name('information'); // Dạng lưới
        Route::post('information', [UserController::class, 'update'])->name('information.update');
    // Route lấy chi tiết đơn hàng cho client (AJAX popup)
    Route::get('order-detail/{id}', [\App\Http\Controllers\Client\OrderDetailController::class, 'show'])->name('order-detail.show');
    Route::patch('/orders/{id}/cancel', [\App\Http\Controllers\Client\OrderController::class, 'cancel'])->name('orders.cancel');
    });
    //Users routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('profile', [UserController::class, 'index'])->name('profile'); // Dạng lưới
    });
    
    Route::get('forgot-password', [AuthenticationClientController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthenticationClientController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [AuthenticationClientController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [AuthenticationClientController::class, 'reset'])->name('password.update');
    // Product routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ClientProductController::class, 'index'])->name('index');
        Route::get('{slug}', [ClientProductController::class, 'show'])->name('show');
        Route::post('add-to-cart', [ClientProductController::class, 'addToCart'])->name('add-to-cart')->middleware('auth');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('add', [CartController::class, 'add'])->name('add');
        Route::post('update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::get('checkout', [CartController::class, 'showCheckoutForm'])->name('checkout.form');
        Route::post('checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('apply-voucher', [CartController::class, 'applyVoucher'])->name('apply-voucher');
    });

    Route::prefix('orders')->name('orders.')->middleware('auth')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::patch('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::patch('/{id}/confirm-received', [OrderController::class, 'confirmReceived'])->name('confirm-received');
        Route::get('/{order}/review/{item}', [OrderController::class, 'reviewForm'])->name('review.form');
        Route::post('/{order}/review/{item}', [OrderController::class, 'submitReview'])->name('review.submit');
    });

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::post('/{slug}/comment', [BlogController::class, 'comment'])->name('comment');
        Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
    });

    Route::prefix('brand')->name('brand.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Client\BrandController::class, 'index'])->name('index');
    });
    Route::prefix('faq')->name('faq.')->group(function () {
        Route::get('/', [FaqClientController::class, 'index'])->name('index');
    });

    Route::prefix('voucher')->name('voucher.')->group(function () {
        Route::get('/', [VoucherController::class, 'index'])->name('index');
    });
    Route::prefix('contact')->name('contact.')->group(function () {
        Route::get('/', [ClientContactController::class, 'index'])->name('index');
        Route::post('/', [ClientContactController::class, 'store'])->name('store');
    });

    // Route lấy danh sách lý do hủy đơn hàng cho client
    Route::get('/order-cancel-reasons', [\App\Http\Controllers\Client\OrderDetailController::class, 'reasons'])->name('client.order-detail.reasons');
});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Admin routes group
Route::prefix('admin')->name('admin.')->middleware(['auth', 'checkAdmin'])->group(function () {
    Route::get('/home', [AdminHomeController::class, 'index'])->name('home');
    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings.index')
        ->middleware(['permission:xem-cai-dat']);
    Route::post('/settings', [SettingController::class, 'update'])
        ->name('settings.update')
        ->middleware(['permission:cap-nhat-cai-dat']);

    Route::get('/product/{slug}', [AdminProductController::class, 'showBySlug'])->name('product.show');

    // Inventory routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index')->middleware(['permission:quan-ly-ton-kho']);
        Route::post('/', [InventoryController::class, 'store'])->name('store')->middleware(['permission:them-giao-dich-kho']);
        Route::post('/store-bulk', [InventoryController::class, 'storeBulk'])->name('store-bulk')->middleware(['permission:them-giao-dich-kho']);
        Route::get('/search-variations', [InventoryController::class, 'searchVariations'])->name('search-variations');
        Route::get('/search-products', [InventoryController::class, 'searchProducts'])->name('search-products');
        Route::get('/get-variations', [InventoryController::class, 'getVariationsByProduct'])->name('get-variations');
        Route::get('/print/{id}', [InventoryController::class, 'print'])->name('inventory-print')->middleware(['permission:in-phieu-kho']);
        Route::get('/{id}/show', [InventoryController::class, 'show'])->name('show')->middleware(['permission:quan-ly-ton-kho']);
    });

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
        Route::get('/providers', [ShippingProviderController::class, 'index'])
            ->name('shipping.providers.index');
        Route::post('/providers', [ShippingProviderController::class, 'store'])
            ->name('shipping.providers.store')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::put('/providers/{provider}', [ShippingProviderController::class, 'update'])
            ->name('shipping.providers.update')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::delete('/providers/{provider}', [ShippingProviderController::class, 'destroy'])
            ->name('shipping.providers.destroy')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::post('/providers/{provider}/status', [ShippingProviderController::class, 'updateStatus'])
            ->name('shipping.providers.status')
            ->middleware(['permission:sua-don-vi-van-chuyen']);

        // Shipping fees routes
        Route::get('/providers/{provider}/fees', [ShippingProviderController::class, 'fees'])
            ->name('shipping.fees');
        Route::post('/providers/{provider}/fees', [ShippingProviderController::class, 'storeFee'])
            ->name('shipping.fees.store')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::put('/providers/{provider}/fees/{fee}', [ShippingProviderController::class, 'updateFee'])
            ->name('shipping.fees.update')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
        Route::delete('/providers/{provider}/fees/{fee}', [ShippingProviderController::class, 'destroyFee'])
            ->name('shipping.fees.destroy')
            ->middleware(['permission:sua-don-vi-van-chuyen']);
    });

    // Product Management
    Route::prefix('products')->name('products.')->middleware(['permission:xem-danh-sach-san-pham'])->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('list');
        Route::get('/{id}/show', [AdminProductController::class, 'show'])->name('show');
        Route::get('/create', [AdminProductController::class, 'create'])->name('create')
            ->middleware(['permission:them-san-pham']);
        Route::post('store', [AdminProductController::class, 'store'])->name('store')
            ->middleware(['permission:them-san-pham']);
        Route::get('edit/{id}', [AdminProductController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-san-pham']);
        Route::put('update/{id}', [AdminProductController::class, 'update'])->name('update')
            ->middleware(['permission:sua-san-pham']);
        Route::delete('destroy/{id}', [AdminProductController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-san-pham']);
        Route::get('trashed', [AdminProductController::class, 'trashed'])->name('trashed');
        Route::put('restore/{id}', [AdminProductController::class, 'restore'])->name('restore')
            ->middleware(['permission:khoi-phuc-san-pham']);
        Route::delete('forceDelete/{id}', [AdminProductController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-vinh-vien-san-pham']);
        Route::delete('bulk-delete', [AdminProductController::class, 'bulkDelete'])->name('bulk-delete')
            ->middleware(['permission:xoa-nhieu-san-pham']);
        Route::delete('/bulk-delete', [AdminProductController::class, 'bulkDestroy'])->name('bulkDestroy');
        Route::post('/bulk-restore', [AdminProductController::class, 'bulkRestore'])->name('bulkRestore');
        Route::delete('/bulk-force-delete', [AdminProductController::class, 'bulkForceDelete'])->name('bulkForceDelete');
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

    // Sphericals
    Route::prefix('sphericals')->name('sphericals.')->middleware(['permission:xem-do-can'])->group(function () {
        Route::get('/', [SphericalController::class, 'index'])->name('index');
        Route::get('/create', [SphericalController::class, 'create'])->name('create')
            ->middleware(['permission:them-do-can']);
        Route::post('/', [SphericalController::class, 'store'])->name('store')
            ->middleware(['permission:them-do-can']);
        Route::get('/edit/{id}', [SphericalController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-do-can']);
        Route::put('/update/{id}', [SphericalController::class, 'update'])->name('update')
            ->middleware(['permission:sua-do-can']);
        Route::delete('/destroy/{id}', [SphericalController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-do-can']);
    });

    // Cylindricals
    Route::prefix('cylindricals')->name('cylindricals.')->middleware(['permission:xem-do-loan'])->group(function () {
        Route::get('/', [CylindricalController::class, 'index'])->name('index');
        Route::get('/create', [CylindricalController::class, 'create'])->name('create')
            ->middleware(['permission:them-do-loan']);
        Route::post('/', [CylindricalController::class, 'store'])->name('store')
            ->middleware(['permission:them-do-loan']);
        Route::get('/edit/{id}', [CylindricalController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-do-loan']);
        Route::put('/update/{id}', [CylindricalController::class, 'update'])->name('update')
            ->middleware(['permission:sua-do-loan']);
        Route::delete('/destroy/{id}', [CylindricalController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-do-loan']);
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
        Route::delete('/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('bulkDestroy');
        Route::post('/bulk-restore', [CategoryController::class, 'bulkRestore'])->name('bulkRestore');
        Route::delete('/bulk-force-delete', [CategoryController::class, 'bulkForceDelete'])->name('bulkForceDelete');
    });

    // Slider
    Route::prefix('sliders')->name('sliders.')->middleware(['permission:xem-danh-sach-slider'])->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        Route::get('/{id}/show', [SliderController::class, 'show'])->name('show');
        Route::get('/create', [SliderController::class, 'create'])->name('create')
            ->middleware(['permission:them-slider']);
        Route::post('/store', [SliderController::class, 'store'])->name('store')
            ->middleware(['permission:them-slider']);
        Route::get('/{id}/edit', [SliderController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-slider']);
        Route::put('/{id}/update', [SliderController::class, 'update'])->name('update')
            ->middleware(['permission:sua-slider']);
        Route::delete('/{id}/destroy', [SliderController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-slider']);
        Route::get('/bin', [SliderController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore', [SliderController::class, 'restore'])->name('restore')
            ->middleware(['permission:sua-slider']);
        Route::delete('/{id}/forceDelete', [SliderController::class, 'forceDelete'])->name('forceDelete')
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

    // News Categories
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

    Route::get('/notifications/dropdown', [NotificationController::class, 'getDropdownNotifications'])
        ->name('notifications.dropdown')
        ->middleware(['auth', 'checkAdmin']);

    // Notifications
    Route::prefix('notifications')->name('notifications.')->middleware(['permission:xem-danh-sach-thong-bao'])->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/{id}/mark-as-unread', [NotificationController::class, 'markAsUnread'])->name('mark-as-unread');
        Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
        Route::get('/dropdown', [NotificationController::class, 'getDropdownNotifications'])->name('dropdown');
        // Test routes - Chỉ nên sử dụng trong môi trường development
        if (app()->environment('local', 'development')) {
            Route::get('/test/new-order', [NotificationController::class, 'testNewOrder'])->name('test.new-order');
            Route::get('/test/order-status', [NotificationController::class, 'testOrderStatus'])->name('test.order-status');
            Route::get('/test/stock-alert', [NotificationController::class, 'testStockAlert'])->name('test.stock-alert');
            Route::get('/test/promotion', [NotificationController::class, 'testPromotion'])->name('test.promotion');
            Route::get('/test/order-cancelled', [NotificationController::class, 'testOrderCancelled'])->name('test.order-cancelled');
            Route::get('/test/monthly-report', [NotificationController::class, 'testMonthlyReport'])->name('test.monthly-report');
        }
    });

    // Brands
    Route::prefix('brands')->name('brands.')->middleware(['permission:xem-danh-sach-thuong-hieu'])->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/{id}/show', [BrandController::class, 'show'])->name('show');
        Route::get('/create', [BrandController::class, 'create'])->name('create')
            ->middleware(['permission:them-thuong-hieu']);
        Route::post('/store', [BrandController::class, 'store'])->name('store')
            ->middleware(['permission:them-thuong-hieu']);
        Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-thuong-hieu']);
        Route::put('/{id}/update', [BrandController::class, 'update'])->name('update')
            ->middleware(['permission:sua-thuong-hieu']);
        Route::delete('/{id}/destroy', [BrandController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-thuong-hieu']);
        Route::get('/bin', [BrandController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore', [BrandController::class, 'restore'])->name('restore')
            ->middleware(['permission:sua-thuong-hieu']);
        Route::delete('/{id}/forceDelete', [BrandController::class, 'forceDelete'])->name('forceDelete')
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
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}/show', [AdminOrderController::class, 'show'])->name('show');
        Route::get('/{order}/print', [AdminOrderController::class, 'print'])->name('print');
        Route::put('{order}/status', [AdminOrderController::class, 'updateStatus'])->name('update-status')
            ->middleware(['permission:cap-nhat-trang-thai-don-hang']);
        Route::put('{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('update-payment-status')
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
        Route::delete('/bulk-delete', [ReviewController::class, 'bulkDelete'])->name('bulk-delete');

        // Add route for admin reply
        Route::put('/{review}/reply', [ReviewController::class, 'reply'])->name('reply');
    });

    // Quản lý thanh toán
    Route::prefix('payments')->name('payments.')->middleware(['permission:xem-thanh-toan'])->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/{id}', [PaymentController::class, 'show'])->name('show');
        Route::patch('/{id}/status', [PaymentController::class, 'updateStatus'])->name('updateStatus')
            ->middleware(['permission:cap-nhat-trang-thai-thanh-toan']);
        Route::delete('/{id}', [PaymentController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-thanh-toan']);
    });

    // Quản lý bình luận
    Route::prefix('comments')->name('comments.')->middleware(['permission:xem-binh-luan'])->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index');
        Route::post('/', [CommentController::class, 'store'])->name('store')
            ->middleware(['permission:them-binh-luan']);

        // Quản lý bad words trong CommentController luôn
        Route::get('badwords', [CommentController::class, 'badWordsIndex'])->name('badwords.index');
        Route::post('badwords', [CommentController::class, 'badWordsStore'])->name('badwords.store');
        Route::delete('badwords/{badword}', [CommentController::class, 'badWordsDestroy'])->name('badwords.destroy');

        Route::middleware(['auth'])->group(function () {
            Route::post('scan-badwords', [CommentController::class, 'updateCommentsStatusAndBanUsers'])->name('scan_badwords');
        });

        Route::get('/{comment}', [CommentController::class, 'show'])->name('show');

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
        Route::post('/{comment}/reply', [CommentController::class, 'reply'])->name('reply');
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

    // Quản lý ticket
    Route::prefix('tickets')->name('tickets.')->middleware(['permission:xem-ticket'])->group(function () {
        // Danh sách và xem chi tiết
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::delete('bulk-destroy', [TicketController::class, 'bulkDestroy'])->name('bulkDestroy');
        Route::patch('bulk-restore', [TicketController::class, 'bulkRestore'])->name('bulkRestore');
        Route::delete('bulk-force-delete', [TicketController::class, 'bulkForceDelete'])->name('bulkForceDelete');
        Route::get('/trashed', [TicketController::class, 'trashed'])
            ->name('trashed')->middleware('permission:xem-thung-rac-ticket');
        Route::get('/{id}', [TicketController::class, 'show'])->name('show');
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
    Route::prefix('support')->name('support.')->middleware(['permission:xem-danh-sach-ho-tro-khach-hang'])->group(function () {
        Route::get('/', [CustomerSupportController::class, 'showForm'])->name('index');
        Route::get('/list', [CustomerSupportController::class, 'index'])->name('list');
        Route::get('/create', [CustomerSupportController::class, 'showForm'])->name('create');
        Route::post('/', [CustomerSupportController::class, 'submitForm'])->name('store');
        Route::get('/{support}', [CustomerSupportController::class, 'show'])->name('show');
        Route::patch('/{support}/status', [CustomerSupportController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/{support}/done', [CustomerSupportController::class, 'markAsDone'])->name('done');
        Route::delete('/{support}', [CustomerSupportController::class, 'destroy'])->name('destroy');
        Route::get('/{support}/email', [CustomerSupportController::class, 'showEmailForm'])->name('emailForm');
        Route::post('/{support}/send-email', [CustomerSupportController::class, 'sendEmail'])->name('sendEmail');
        Route::get('/{support}/edit-status', [CustomerSupportController::class, 'editStatus'])->name('editStatus');
    });

    // Customer Management
    Route::prefix('customers')->name('customers.')->middleware(['permission:xem-danh-sach-khach-hang'])->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('export', [CustomerController::class, 'export'])->name('export');
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
        Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
        Route::get('/{id}/show', [PaymentMethodController::class, 'show'])->name('show');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('create')->middleware(['permission:them-phuong-thuc-thanh-toan']);
        Route::post('/store', [PaymentMethodController::class, 'store'])->name('store')->middleware(['permission:them-phuong-thuc-thanh-toan']);
        Route::get('/{id}/edit', [PaymentMethodController::class, 'edit'])->name('edit')->middleware(['permission:sua-phuong-thuc-thanh-toan']);
        Route::put('/{id}/update', [PaymentMethodController::class, 'update'])->name('update')->middleware(['permission:sua-phuong-thuc-thanh-toan']);
        Route::delete('/{id}/destroy', [PaymentMethodController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-phuong-thuc-thanh-toan']);
        Route::get('/bin', [PaymentMethodController::class, 'bin'])->name('bin');
        Route::put('/{id}/restore', [PaymentMethodController::class, 'restore'])->name('restore')->middleware(['permission:sua-phuong-thuc-thanh-toan']);
        Route::delete('/{id}/forceDelete', [PaymentMethodController::class, 'forceDelete'])->name('forceDelete')->middleware(['permission:xoa-phuong-thuc-thanh-toan']);
        Route::delete('/bulk-delete', [PaymentMethodController::class, 'bulkDestroy'])->name('bulkDestroy')->middleware(['permission:xoa-nhieu-phuong-thuc-thanh-toan']);
        Route::post('/bulk-restore', [PaymentMethodController::class, 'bulkRestore'])->name('bulkRestore')->middleware(['permission:sua-phuong-thuc-thanh-toan']);
        Route::delete('/bulk-force-delete', [PaymentMethodController::class, 'bulkForceDelete'])->name('bulkForceDelete')->middleware(['permission:xoa-nhieu-phuong-thuc-thanh-toan']);
    });

    // User profile routes
    Route::get('/profile/{id?}', [UserController::class, 'profile'])->name('users.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('users.updateProfile');
    Route::post('/verify-password', [UserController::class, 'verifyPassword'])->name('users.verifyPassword');
    Route::put('/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');

    // Contact routes
    Route::prefix('contacts')->name('contacts.')->middleware(['permission:xem-danh-sach-lien-he'])->group(function () {
        Route::post('/bulk-destroy', [ContactController::class, 'bulkDestroy'])->name('bulkDestroy')
            ->middleware(['permission:xoa-nhieu-lien-he']);
        Route::post('/bulk-restore', [ContactController::class, 'bulkRestore'])->name('bulkRestore')
            ->middleware(['permission:khoi-phuc-lien-he']);
        Route::post('/bulk-force-delete', [ContactController::class, 'bulkForceDelete'])->name('bulkForceDelete')
            ->middleware(['permission:xoa-vinh-vien-lien-he']);
        Route::get('/', [ContactController::class, 'index'])->name('index')
            ->middleware(['permission:xem-danh-sach-lien-he']);
        Route::get('/bin', [ContactController::class, 'bin'])->name('bin')
            ->middleware(['permission:xem-thung-rac-lien-he']);
        Route::get('/{contact}', [ContactController::class, 'show'])->name('show')
            ->middleware(['permission:xem-chi-tiet-lien-he']);
        Route::get('/{contact}/edit', [ContactController::class, 'edit'])->name('edit')
            ->middleware(['permission:sua-lien-he']);
        Route::put('/{contact}', [ContactController::class, 'update'])->name('update')
            ->middleware(['permission:sua-lien-he']);
        Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy')
            ->middleware(['permission:xoa-lien-he']);
        Route::post('/{contact}/restore', [ContactController::class, 'restore'])->name('restore')
            ->middleware(['permission:khoi-phuc-lien-he']);
        Route::delete('/{contact}/force', [ContactController::class, 'forceDelete'])->name('forceDelete')
            ->middleware(['permission:xoa-vinh-vien-lien-he']);
        Route::get('/{contact}/reply', [ContactController::class, 'reply'])->name('reply')
            ->middleware(['permission:gui-email-lien-he']);
        Route::post('/{contact}/reply', [ContactController::class, 'sendReply'])->name('sendReply')
            ->middleware(['permission:gui-email-lien-he']);
    });
});

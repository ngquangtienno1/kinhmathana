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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    // Điều hướng về trang login nếu người dùng chưa đăng nhập
    if (Auth::check()) {
        return redirect()->route('admin.home'); // Hoặc route khác sau khi login
    } else {
        return redirect()->route('login');
    }
});

// Authentication Routes
Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('postLogin', [AuthenticationController::class, 'postLogin'])->name('postLogin');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('postRegister', [AuthenticationController::class, 'postRegister'])->name('postRegister');

// Social Authentication Routes
Route::get('/auth/google', [SocialController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [SocialController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

// Admin Routes Group
Route::prefix('admin')->name('admin.')->middleware(['auth', 'checkAdmin'])->group(function () {

    // Dashboard / Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
         Route::get('/', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index')->middleware(['permission:xem-cai-dat']);
         Route::post('/', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update')->middleware(['permission:cap-nhat-cai-dat']);
    });

    // FAQ routes
    Route::prefix('faqs')->name('faqs.')->middleware(['permission:xem-danh-sach-faq'])->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('index');
        Route::get('/create', [FaqController::class, 'create'])->name('create')->middleware(['permission:them-faq']);
        Route::post('/', [FaqController::class, 'store'])->name('store')->middleware(['permission:them-faq']);
        Route::get('/{faq}/edit', [FaqController::class, 'edit'])->name('edit')->middleware(['permission:sua-faq']);
        Route::put('/{faq}', [FaqController::class, 'update'])->name('update')->middleware(['permission:sua-faq']);
        Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-faq']);
        Route::post('/{faq}/status', [FaqController::class, 'updateStatus'])->name('status')->middleware(['permission:sua-faq']);
    });

    // Role Management Routes
    Route::prefix('roles')->name('roles.')->middleware(['permission:xem-danh-sach-vai-tro'])->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create')->middleware(['permission:them-vai-tro']);
        Route::post('/', [RoleController::class, 'store'])->name('store')->middleware(['permission:them-vai-tro']);
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit')->middleware(['permission:sua-vai-tro']);
        Route::put('/{role}', [RoleController::class, 'update'])->name('update')->middleware(['permission:sua-vai-tro']);
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-vai-tro']);
    });

    // Permission Management Routes
    Route::prefix('permissions')->name('permissions.')->middleware(['permission:sua-quyen'])->group(function () {
         Route::get('/', [PermissionController::class, 'index'])->name('index');
         Route::get('/create', [PermissionController::class, 'create'])->name('create');
         Route::post('/', [PermissionController::class, 'store'])->name('store');
         Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
         Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
         Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
    });

       // User Management
       Route::get('user', [UserController::class, 'index'])
       ->name('listUser')
       ->middleware(['permission:xem-danh-sach-nguoi-dung']);

    // Shipping routes
    Route::prefix('shipping')->name('shipping.')->middleware(['permission:xem-don-vi-van-chuyen'])->group(function () {
        // Shipping Providers
        Route::prefix('providers')->name('providers.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\ShippingProviderController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\ShippingProviderController::class, 'store'])->name('store')->middleware(['permission:sua-don-vi-van-chuyen']);
            Route::put('/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'update'])->name('update')->middleware(['permission:sua-don-vi-van-chuyen']);
            Route::delete('/{provider}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroy'])->name('destroy')->middleware(['permission:sua-don-vi-van-chuyen']);
            Route::post('/{provider}/status', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateStatus'])->name('status')->middleware(['permission:sua-don-vi-van-chuyen']);
        });

        // Shipping Fees
        Route::prefix('providers/{provider}/fees')->name('fees.')->group(function () {
             Route::get('/', [App\Http\Controllers\Admin\ShippingProviderController::class, 'fees'])->name('index');
             Route::post('/', [App\Http\Controllers\Admin\ShippingProviderController::class, 'storeFee'])->name('store')->middleware(['permission:sua-don-vi-van-chuyen']);
             Route::put('/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'updateFee'])->name('update')->middleware(['permission:sua-don-vi-van-chuyen']);
             Route::delete('/{fee}', [App\Http\Controllers\Admin\ShippingProviderController::class, 'destroyFee'])->name('destroy')->middleware(['permission:sua-don-vi-van-chuyen']);
        });
    });

    // Product Routes
    Route::prefix('products')->name('products.')->middleware(['permission:xem-danh-sach-san-pham'])->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('list'); // Renamed from list
        Route::get('/create', [ProductController::class, 'create'])->name('create')->middleware(['permission:them-san-pham']);
        Route::post('/', [ProductController::class, 'store'])->name('store')->middleware(['permission:them-san-pham']); // Changed from /store
        Route::get('/{product}', [ProductController::class, 'show'])->name('show'); // Changed from /{id}/show
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit')->middleware(['permission:sua-san-pham']); // Changed from edit/{id}
        Route::put('/{product}', [ProductController::class, 'update'])->name('update')->middleware(['permission:sua-san-pham']); // Changed from update/{id}
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-san-pham']); // Changed from destroy/{id}

        Route::get('/bin', [ProductController::class, 'bin'])->name('bin');
        Route::put('/bin/{product}/restore', [ProductController::class, 'restore'])->name('restore')->middleware(['permission:khoi-phuc-san-pham']); // Changed from restore/{id}
        Route::delete('/bin/{product}/forceDelete', [ProductController::class, 'forceDelete'])->name('forceDelete')->middleware(['permission:xoa-vinh-vien-san-pham']); // Changed from forceDelete/{id}
        Route::delete('/bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete')->middleware(['permission:xoa-nhieu-san-pham']);
    });

    // Product Images Routes
    Route::prefix('products/{product}/images')->name('products.images.')->middleware(['permission:xem-anh-san-pham'])->group(function () {
        Route::get('/', [ProductImageController::class, 'index'])->name('index');
        Route::get('/create', [ProductImageController::class, 'create'])->name('create')->middleware(['permission:them-anh-san-pham']);
        Route::post('/', [ProductImageController::class, 'store'])->name('store')->middleware(['permission:them-anh-san-pham']);
        Route::get('/{image}/edit', [ProductImageController::class, 'edit'])->name('edit')->middleware(['permission:sua-anh-san-pham']); // Changed from /{product}/{id}/edit
        Route::put('/{image}', [ProductImageController::class, 'update'])->name('update')->middleware(['permission:sua-anh-san-pham']); // Changed from /{product}/{id}
        Route::delete('/{image}', [ProductImageController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-anh-san-pham']); // Changed from /{product}/{id}
        Route::post('/{image}/thumbnail', [ProductImageController::class, 'setThumbnail'])->name('setThumbnail')->middleware(['permission:dat-anh-dai-dien']); // Changed from /{product}/{id}/thumbnail
    });

    // Variations Routes
    Route::resource('variations', VariationController::class)->except(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])->middleware(['permission:xem-bien-the']); // Use resource for standard methods
    Route::prefix('variations')->name('variations.')->middleware(['permission:xem-bien-the'])->group(function () {
         Route::get('/', [VariationController::class, 'index'])->name('index');
         Route::get('/create', [VariationController::class, 'create'])->name('create')->middleware(['permission:them-bien-the']);
         Route::post('/', [VariationController::class, 'store'])->name('store')->middleware(['permission:them-bien-the']);
         Route::get('/{variation}', [VariationController::class, 'show'])->name('show');
         Route::get('/{variation}/edit', [VariationController::class, 'edit'])->name('edit')->middleware(['permission:sua-bien-the']);
         Route::put('/{variation}', [VariationController::class, 'update'])->name('update')->middleware(['permission:sua-bien-the']);
         Route::delete('/{variation}', [VariationController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-bien-the']);

         Route::get('/bin', [VariationController::class, 'bin'])->name('bin');
         Route::put('/bin/{variation}/restore', [VariationController::class, 'restore'])->name('restore')->middleware(['permission:khoi-phuc-bien-the']);
         Route::delete('/bin/{variation}/forceDelete', [VariationController::class, 'forceDelete'])->name('forceDelete')->middleware(['permission:xoa-vinh-vien-bien-the']);
    });

    // Variations Images Routes
    Route::prefix('variations/{variation}/images')->name('variations.images.')->middleware(['permission:xem-anh-bien-the'])->group(function () {
        Route::get('/', [VariationImageController::class, 'index'])->name('index');
        Route::get('/create', [VariationImageController::class, 'create'])->name('create')->middleware(['permission:them-anh-bien-the']);
        Route::post('/', [VariationImageController::class, 'store'])->name('store')->middleware(['permission:them-anh-bien-the']);
        Route::delete('/{image}', [VariationImageController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-anh-bien-the']); // Changed from /{variation}/{id}
        Route::post('/{image}/thumbnail', [VariationImageController::class, 'setThumbnail'])->name('setThumbnail')->middleware(['permission:dat-anh-dai-dien-bien-the']); // Changed from /{variation}/{id}/thumbnail
    });

    // Color Routes
    Route::resource('colors', ColorController::class)->except(['index', 'create', 'store', 'edit', 'update', 'destroy'])->middleware(['permission:xem-mau-sac']);
     Route::prefix('colors')->name('colors.')->middleware(['permission:xem-mau-sac'])->group(function () {
         Route::get('/', [ColorController::class, 'index'])->name('index');
         Route::get('/create', [ColorController::class, 'create'])->name('create')->middleware(['permission:them-mau-sac']);
         Route::post('/', [ColorController::class, 'store'])->name('store')->middleware(['permission:them-mau-sac']);
         Route::get('/{color}/edit', [ColorController::class, 'edit'])->name('edit')->middleware(['permission:sua-mau-sac']);
         Route::put('/{color}', [ColorController::class, 'update'])->name('update')->middleware(['permission:sua-mau-sac']);
         Route::delete('/{color}', [ColorController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-mau-sac']);
     });

    // Sizes Routes
    Route::resource('sizes', SizeController::class)->except(['index', 'create', 'store', 'edit', 'update', 'destroy'])->middleware(['permission:xem-kich-thuoc']);
     Route::prefix('sizes')->name('sizes.')->middleware(['permission:xem-kich-thuoc'])->group(function () {
         Route::get('/', [SizeController::class, 'index'])->name('index');
         Route::get('/create', [SizeController::class, 'create'])->name('create')->middleware(['permission:them-kich-thuoc']);
         Route::post('/', [SizeController::class, 'store'])->name('store')->middleware(['permission:them-kich-thuoc']);
         Route::get('/{size}/edit', [SizeController::class, 'edit'])->name('edit')->middleware(['permission:sua-kich-thuoc']);
         Route::put('/{size}', [SizeController::class, 'update'])->name('update')->middleware(['permission:sua-kich-thuoc']);
         Route::delete('/{size}', [SizeController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-kich-thuoc']);
     });

    // Category Routes
    Route::resource('categories', CategoryController::class)->except(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');

        Route::get('/bin', [CategoryController::class, 'bin'])->name('bin');
        Route::put('/bin/{category}/restore', [CategoryController::class, 'restore'])->name('restore');
        Route::delete('/bin/{category}/forceDelete', [CategoryController::class, 'forceDelete'])->name('forceDelete');
    });

    // Slider Routes
    Route::resource('sliders', SliderController::class)->except(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])->middleware(['permission:xem-danh-sach-slider']);
    Route::prefix('sliders')->name('sliders.')->middleware(['permission:xem-danh-sach-slider'])->group(function () {
        Route::get('/',                [SliderController::class, 'index'])->name('index');
        Route::get('/create',          [SliderController::class, 'create'])->name('create')->middleware(['permission:them-slider']);
        Route::post('/',          [SliderController::class, 'store'])->name('store')->middleware(['permission:them-slider']);
        Route::get('/{slider}',       [SliderController::class, 'show'])->name('show');
        Route::get('/{slider}/edit',       [SliderController::class, 'edit'])->name('edit')->middleware(['permission:sua-slider']);
        Route::put('/{slider}',     [SliderController::class, 'update'])->name('update')->middleware(['permission:sua-slider']);
        Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-slider']);

        Route::get('/bin',             [SliderController::class, 'bin'])->name('bin');
        Route::put('/bin/{slider}/restore',    [SliderController::class, 'restore'])->name('restore')->middleware(['permission:sua-slider']);
        Route::delete('/bin/{slider}/forceDelete',   [SliderController::class, 'forceDelete'])->name('forceDelete')->middleware(['permission:xoa-slider']);
        Route::delete('/bulk-delete', [SliderController::class, 'bulkDelete'])->name('bulk-delete')->middleware(['permission:xoa-slider']);
    });

    // News Routes
    Route::resource('news', NewsController::class)->except(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'])->middleware(['permission:xem-news']);
    Route::prefix('news')->name('news.')->middleware(['permission:xem-news'])->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/create', [NewsController::class, 'create'])->name('create')->middleware(['permission:them-news']);
        Route::post('/', [NewsController::class, 'store'])->name('store')->middleware(['permission:them-news']);
        Route::get('/{news}', [NewsController::class, 'show'])->name('show');
        Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit')->middleware(['permission:sua-news']);
        Route::put('/{news}', [NewsController::class, 'update'])->name('update')->middleware(['permission:sua-news']);
        Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-news']);

        Route::get('/bin', [NewsController::class, 'bin'])->name('bin');
        Route::put('/bin/{news}/restore', [NewsController::class, 'restore'])->name('restore')->middleware(['permission:sua-news']);
        Route::delete('/bin/{news}/forceDelete', [NewsController::class, 'forceDelete'])->name('forceDelete')->middleware(['permission:xoa-news']);
    });

    // Brands Routes
    Route::resource('brands', BrandController::class)->except(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'])->middleware(['permission:xem-danh-sach-thuong-hieu']);
    Route::prefix('brands')->name('brands.')->middleware(['permission:xem-danh-sach-thuong-hieu'])->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create')->middleware(['permission:them-thuong-hieu']);
        Route::post('/', [BrandController::class, 'store'])->name('store')->middleware(['permission:them-thuong-hieu']);
        Route::get('/{brand}', [BrandController::class, 'show'])->name('show');
        Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('edit')->middleware(['permission:sua-thuong-hieu']);
        Route::put('/{brand}', [BrandController::class, 'update'])->name('update')->middleware(['permission:sua-thuong-hieu']);
        Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-thuong-hieu']);

        Route::get('/bin', [BrandController::class, 'bin'])->name('bin');
        Route::put('/bin/{brand}/restore', [BrandController::class, 'restore'])->name('restore')->middleware(['permission:sua-thuong-hieu']);
        Route::delete('/bin/{brand}/forceDelete', [BrandController::class, 'forceDelete'])->name('forceDelete')->middleware(['permission:xoa-thuong-hieu']);
    });

    // Cancellation Reasons Routes
    Route::resource('cancellation-reasons', CancellationReasonController::class)->except(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'])->middleware(['permission:xem-ly-do-huy-don']);
    Route::prefix('cancellation-reasons')->name('cancellation_reasons.')->middleware(['permission:xem-ly-do-huy-don'])->group(function () {
        Route::get('/', [CancellationReasonController::class, 'index'])->name('index');
        Route::get('/create', [CancellationReasonController::class, 'create'])->name('create')->middleware(['permission:them-ly-do-huy-don']);
        Route::post('/', [CancellationReasonController::class, 'store'])->name('store')->middleware(['permission:them-ly-do-huy-don']);
        Route::get('/{cancellationReason}', [CancellationReasonController::class, 'show'])->name('show');
        Route::get('/{cancellationReason}/edit', [CancellationReasonController::class, 'edit'])->name('edit')->middleware(['permission:sua-ly-do-huy-don']);
        Route::put('/{cancellationReason}', [CancellationReasonController::class, 'update'])->name('update')->middleware(['permission:sua-ly-do-huy-don']);
        Route::delete('/{cancellationReason}', [CancellationReasonController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-ly-do-huy-don']);

        Route::get('/bin', [CancellationReasonController::class, 'bin'])->name('bin');
        Route::put('/bin/{cancellationReason}/restore', [CancellationReasonController::class, 'restore'])->name('restore')->middleware(['permission:khoi-phuc-ly-do-huy-don']);
        Route::delete('/bin/{cancellationReason}/forceDelete', [CancellationReasonController::class, 'forceDelete'])->name('forceDelete')->middleware(['permission:xoa-vinh-vien-ly-do-huy-don']);
    });

    // Orders Routes
    Route::resource('orders', OrderController::class)->except(['index', 'show', 'update'])->middleware(['permission:xem-danh-sach-don-hang']);
    Route::prefix('orders')->name('orders.')->middleware(['permission:xem-danh-sach-don-hang'])->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update'); // Standard update route
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status')->middleware(['permission:cap-nhat-trang-thai-don-hang']);
        Route::patch('/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('update-payment-status')->middleware(['permission:cap-nhat-trang-thai-don-hang']);

        // Order Status History Routes (Moved inside admin group)
        Route::get('/{order}/status-history', [OrderStatusHistoryController::class, 'show'])->name('status.history');
        Route::patch('/{order}/status-update', [OrderStatusHistoryController::class, 'updateStatus'])->name('status.update'); // Renamed to avoid conflict with OrderController updateStatus
    });

    // Payment Routes
    Route::prefix('payments')->name('payments.')->middleware(['permission:xem-thanh-toan'])->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
        Route::patch('/{payment}/status', [PaymentController::class, 'updateStatus'])->name('updateStatus')->middleware(['permission:cap-nhat-trang-thai-thanh-toan']);
        Route::get('/{payment}/invoice', [PaymentController::class, 'printInvoice'])->name('invoice')->middleware(['permission:in-hoa-don']);
    });

    // Comment Routes
    Route::resource('comments', CommentController::class)->except(['index', 'store', 'edit', 'update', 'destroy', 'destroy', 'trashed', 'restore', 'forceDelete', 'updateStatus'])->middleware(['permission:xem-binh-luan']);
    Route::prefix('comments')->name('comments.')->middleware(['permission:xem-binh-luan'])->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index');
        Route::post('/', [CommentController::class, 'store'])->name('store')->middleware(['permission:them-binh-luan']);
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit')->middleware(['permission:sua-binh-luan']);
        Route::put('/{comment}', [CommentController::class, 'update'])->name('update')->middleware(['permission:sua-binh-luan']);
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy')->middleware(['permission:xoa-binh-luan']);

        Route::get('/trashed', [CommentController::class, 'trashed'])->name('trashed');
        Route::patch('/trashed/{comment}/restore', [CommentController::class, 'restore'])->name('restore')->middleware(['permission:khoi-phuc-binh-luan']);
        Route::delete('/trashed/{comment}/forceDelete', [CommentController::class, 'forceDelete'])->name('forceDelete')->middleware(['permission:xoa-vinh-vien-binh-luan']);
        Route::patch('/{comment}/status', [CommentController::class, 'updateStatus'])->name('updateStatus')->middleware(['permission:an-hien-binh-luan']);
    });

     // Promotion routes
    Route::resource('promotions', PromotionController::class)->except(['index', 'generateCode', 'store', 'show', 'edit', 'update', 'destroy']);
     Route::prefix('promotions')->name('promotions.')->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('index');
        Route::get('/generate-code', [PromotionController::class, 'generateCode'])->name('generate-code');
        Route::post('/', [PromotionController::class, 'store'])->name('store');
        Route::get('/{promotion}', [PromotionController::class, 'show'])->name('show');
        Route::get('/{promotion}/edit', [PromotionController::class, 'edit'])->name('edit');
        Route::put('/{promotion}', [PromotionController::class, 'update'])->name('update');
        Route::delete('/{promotion}', [PromotionController::class, 'destroy'])->name('destroy');
     });

    // Support routes (Updated to match desired behavior)
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [ProductSupportController::class, 'showForm'])->name('create'); // /admin/support -> showForm (Form)
        Route::post('/', [ProductSupportController::class, 'submitForm'])->name('store'); // POST /admin/support -> submitForm (Store Form Data)
        
        Route::get('/list', [ProductSupportController::class, 'index'])->name('list'); // /admin/support/list -> index (List)

        Route::get('/{support}', [ProductSupportController::class, 'show'])->name('show'); // /admin/support/{support} -> show (Show Detail)
        Route::patch('/{support}/status', [ProductSupportController::class, 'updateStatus'])->name('updateStatus'); // PATCH /admin/support/{support}/status -> updateStatus
        Route::post('/{support}/done', [ProductSupportController::class, 'markAsDone'])->name('done'); // POST /admin/support/{support}/done -> markAsDone
        Route::delete('/{support}', [ProductSupportController::class, 'destroy'])->name('destroy'); // DELETE /admin/support/{support} -> destroy
        Route::get('/{support}/email', [ProductSupportController::class, 'showEmailForm'])->name('emailForm'); // /admin/support/{support}/email -> showEmailForm
        Route::post('/{support}/send-email', [ProductSupportController::class, 'sendEmail'])->name('sendEmail'); // POST /admin/support/{support}/send-email -> sendEmail
    });

});

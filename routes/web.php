<?php
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\VariationImageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VariationController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\CategoryController;

use Illuminate\Support\Facades\Route;
// Admin routes

Route::get('/', function () {
    return view('admin.index');
});
//Admin
Route::prefix('admin')->name('admin.')->group(function () {

    // Product
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('list');
        Route::get('/{id}/show',       [ProductController::class, 'show'])->name('show');
        Route::get('/create',          [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('bin', [ProductController::class, 'bin'])->name('bin');
        Route::put('restore/{id}', [ProductController::class, 'restore'])->name('restore');
        Route::delete('forceDelete/{id}', [ProductController::class, 'forceDelete'])->name('forceDelete');
        Route::delete('bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete');
    });
    // Product Images (quản lý ảnh theo sản phẩm)
    Route::prefix('product_images')->name('product_images.')->group(function () {
    Route::get('/{product}', [ProductImageController::class, 'index'])->name('index');
    Route::get('/{product}/create', [ProductImageController::class, 'create'])->name('create');
    Route::post('/{product}', [ProductImageController::class, 'store'])->name('store');
    Route::get('/{product}/{id}/edit', [ProductImageController::class, 'edit'])->name('edit');
    Route::put('/{product}/{id}', [ProductImageController::class, 'update'])->name('update');
    Route::delete('/{product}/{id}', [ProductImageController::class, 'destroy'])->name('destroy');
    Route::post('/{product}/{id}/thumbnail', [ProductImageController::class, 'setThumbnail'])->name('setThumbnail');
    });
    // Variations
    Route::prefix('variations')->name('variations.')->group(function () {
    Route::get('/',                [VariationController::class, 'index'])->name('index');
    Route::get('/create',          [VariationController::class, 'create'])->name('create');
    Route::post('/store',          [VariationController::class, 'store'])->name('store');
    Route::get('/{variation}/show',       [VariationController::class, 'show'])->name('show');
    Route::get('/{variation}/edit',       [VariationController::class, 'edit'])->name('edit');
    Route::put('/{variation}/update',     [VariationController::class, 'update'])->name('update');
    Route::delete('/{variation}/destroy', [VariationController::class, 'destroy'])->name('destroy');
    Route::get('/bin',             [VariationController::class, 'bin'])->name('bin');
    Route::put('/{id}/restore',    [VariationController::class, 'restore'])->name('restore');
    Route::delete('/{id}/forceDelete', [VariationController::class, 'forceDelete'])->name('forceDelete');
    });
    // Variations Images
    Route::prefix('variation_images')->name('variation_images.')->group(function () {
    Route::get('/{variation}', [VariationImageController::class, 'index'])->name('index');
    Route::get('/{variation}/create', [VariationImageController::class, 'create'])->name('create');
    Route::post('/{variation}', [VariationImageController::class, 'store'])->name('store');
    Route::delete('/{variation}/{id}', [VariationImageController::class, 'destroy'])->name('destroy');
    Route::post('/{variation}/{id}/thumbnail', [VariationImageController::class, 'setThumbnail'])->name('setThumbnail'); // ✅ THÊM DÒNG NÀY
});
    // Color
    Route::prefix('colors')->name('colors.')->group(function () {
    Route::get('/', [ColorController::class, 'index'])->name('index');
    Route::get('/create', [ColorController::class, 'create'])->name('create');
    Route::post('/', [ColorController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ColorController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [ColorController::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [ColorController::class, 'destroy'])->name('destroy');
});
// Sizes
Route::prefix('sizes')->name('sizes.')->group(function () {
    Route::get('/', [SizeController::class, 'index'])->name('index');
    Route::get('/create', [SizeController::class, 'create'])->name('create');
    Route::post('/', [SizeController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [SizeController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [SizeController::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [SizeController::class, 'destroy'])->name('destroy');
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
});

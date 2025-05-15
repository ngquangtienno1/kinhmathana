<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.index');
})->name('admin');


Route::get('/products', function () {
    return view('admin.products.index');
});


Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('postLogin', [AuthenticationController::class, 'postLogin'])->name('postLogin');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('postRegister', [AuthenticationController::class, 'postRegister'])->name('postRegister');
<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;




Route::get('/products', function () {
    return view('admin.products.index');
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

Route::group([
    'middleware' => 'checkAdmin'
], 
function(){
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin');
    Route::get('user', [UserController::class, 'index'])->name('listUser');
});
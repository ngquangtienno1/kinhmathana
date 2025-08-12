<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\UserController;

Route::post('users/send-otp', [UserController::class, 'sendOtp'])->name('client.users.send-otp');
Route::post('users/change-password', [UserController::class, 'changePassword'])->name('client.users.change-password');

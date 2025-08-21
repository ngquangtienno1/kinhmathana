<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\UserController;

// API route for client polling user status
Route::get('/client/user-status', [UserController::class, 'getUserStatus'])->name('client.user-status');

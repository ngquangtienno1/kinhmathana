<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PromotionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Promotion routes (protected by auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/validate-promotion', [PromotionController::class, 'validateCode']);
    Route::get('/available-promotions', [PromotionController::class, 'getAvailablePromotions']);
}); 
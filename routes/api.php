<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'accounts'], function () {
        Route::get('add', [ApiController::class, 'addAccount']);
        Route::post('add', [ApiController::class, 'addAccount']);
    });

    Route::group(['prefix' => 'wheels'], function () {
        Route::get('get', [ApiController::class, 'getWheelAccount']);
        Route::post('add', [ApiController::class, 'addWheelAccountReward']);
    });
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceTypeController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // auth routes

    Route::middleware('auth:sanctum')->group(function () {

        Route::middleware('isAdmin')->group(function () {
            Route::apiResource('service-types', ServiceTypeController::class);
            Route::apiResource('car-services', CarServiceController::class);
        });
    });

    // guest routes
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login')->name('api.auth.login');
    });
});

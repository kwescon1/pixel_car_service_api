<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceTypeController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // auth routes

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('service-types', ServiceTypeController::class);
    });

    // guest routes

});

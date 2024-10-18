<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingDateController;
use App\Http\Controllers\CarServiceController;
use App\Http\Controllers\FilterServiceByTypeController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\SelectAvailableDateController;
use App\Http\Controllers\SelectAvailableMechanicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceTypeController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // auth routes

    Route::prefix('public')->group(function () {
        // Unauthenticated routes
        Route::get('/service-types', [ServiceTypeController::class, 'index']); // Public access to service types
        Route::get('/car-services', FilterServiceByTypeController::class);   // Public access to car services
        Route::get('/available-dates', SelectAvailableDateController::class); // Public access to booking dates
        Route::get('/mechanics', SelectAvailableMechanicController::class); // Public access to mechanics
    });

    Route::middleware('auth:sanctum')->group(function () {

        Route::middleware('isAdmin')->group(function () {
            Route::apiResource('service-types', ServiceTypeController::class);
            Route::apiResource('car-services', CarServiceController::class);
            Route::apiResource('available-dates', BookingDateController::class);
            Route::apiResource('mechanics', MechanicController::class);
        });
    });

    // guest routes
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login')->name('api.auth.login');
    });
});

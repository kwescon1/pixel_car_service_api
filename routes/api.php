<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

// Resolve the routes singleton
$routeNames = App::make('routeNames');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    //  // Accessing the singleton

    // Route::post('/register', [AuthController::class, 'register'])
    //     ->name($routeNames['register']);  // Defining route name dynamically
});

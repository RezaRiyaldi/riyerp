<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('auths', AuthController::class)->names('auth');
// });

Route::prefix('auth')->name('auth.')->group(function () {
    // Public routes
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    // Protected routes
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum')->name('me');
});

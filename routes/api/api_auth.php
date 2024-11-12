<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    // Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::patch('/uuid/{uuid}/change-password', [UserController::class, 'changePassword'])->name('changePassword');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('jwt.auth')->name('refresh');
    Route::get('/me', [AuthController::class, 'me'])->middleware('jwt.auth')->name('me');
});

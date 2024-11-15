<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['api', "jwt.auth"],
], function ($router) {
    Route::prefix("products")->group(function () {
        Route::post('assignment/{id}', [ProductController::class, "assignmentProduct"]);
    });
    Route::resource("products", ProductController::class);
});

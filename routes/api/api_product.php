<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['api', "jwt.auth"],
], function ($router) {
    Route::prefix("products")->group(function () {
        Route::post('{id}/assignment', [ProductController::class, "assignmentProduct"]);
        Route::post('{id}/bulk/assignment', [ProductController::class, "bulkAssignmentProduct"]);
        Route::get('/counts', [ProductController::class, "countProductsByState"]);
        Route::post('{product}/unassignment/{people}', [ProductController::class, "unassignPeople"]);
    });
    Route::resource("products", ProductController::class);
});

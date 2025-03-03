<?php

use App\Http\Controllers\API\AssignmentPeopleController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['api', "jwt.auth"],
], function ($router): void {
    Route::prefix("assignment-peoples")->group(function () {
        Route::get("/all", [AssignmentPeopleController::class, "allPeoples"]);
    });
    Route::resource("assignment-peoples", AssignmentPeopleController::class);
});

<?php

use App\Http\Controllers\API\AssignmentPeopleController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['api', "jwt.auth"],
], function ($router): void {
    Route::resource("assignment-peoples", AssignmentPeopleController::class);
});

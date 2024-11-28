<?php

use App\Http\Controllers\API\UbicationController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['api', "jwt.auth"],
], function ($router) {
    Route::resource("ubications", UbicationController::class);
});

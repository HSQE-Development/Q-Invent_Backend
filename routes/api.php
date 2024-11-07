<?php

use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    require __DIR__ . "/API/api_auth.php";
});

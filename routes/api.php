<?php

use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    require __DIR__ . "/api/api_auth.php";
    require __DIR__ . "/api/api_product.php";
    require __DIR__ . "/api/api_assignment_people.php";
});

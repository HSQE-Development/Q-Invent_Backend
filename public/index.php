<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));
// permite peticiones desde cualquier origen
header('Access-Control-Allow-Origin: *');
// permite peticiones con métodos GET, PUT, POST, DELETE y OPTIONS
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS');
// permite los headers Content-Type y Authorization
header('Access-Control-Allow-Headers: Content-Type, Authorization');
// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/../bootstrap/app.php')
    ->handleRequest(Request::capture());

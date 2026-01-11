<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// MAINTENANCE - FIXED PATH
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// AUTOLOAD - FIXED PATH (REMOVED /..)
require __DIR__.'/vendor/autoload.php';

// BOOTSTRAP - FIXED PATH (REMOVED /..)
/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

$app->handleRequest(Request::capture());

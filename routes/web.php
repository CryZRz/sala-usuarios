<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route("login.show");
})->middleware("guest");

require __DIR__ . "/programs/index.php";
require __DIR__ . "/computer/index.php";
require __DIR__ . "/student/index.php";
require __DIR__ . "/session/index.php";
require __DIR__ . "/incidences/index.php";
require __DIR__ . "/auth/index.php";
require __DIR__ . "/reports/index.php";
require __DIR__ . "/import/index.php";

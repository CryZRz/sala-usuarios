<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;

Route::prefix('api')->middleware('auth')->group(function () {
    Route::get("/permisos/{module}", [PermissionController::class, "getByModuleId"]);
    Route::get("/permiso/{permission}/dependencias", [PermissionController::class, "getPermissionDependencies"]);
});

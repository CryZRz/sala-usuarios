<?php

use App\Http\Controllers\RoleManagerController;
use Illuminate\Support\Facades\Route;

Route::prefix("api")->group(function () {
   Route::delete("rol/{role}/permiso/{permission}", [RoleManagerController::class, "removePermission"])
       ->middleware("hasPermission:edit")
       ->name("roleManager.removePermission");

    Route::post("rol/{role}/permiso/{permission}", [RoleManagerController::class, "addPermission"])
        ->middleware("hasPermission:edit")
        ->name("roleManager.addPermission");

    Route::get("/roles/{user}/faltantes", [RoleManagerController::class, "index"])
        ->name("roleManager.index");

    Route::get("/roles", [RoleManagerController::class, "showApi"])
        ->name("roleManagerApi.show");
});

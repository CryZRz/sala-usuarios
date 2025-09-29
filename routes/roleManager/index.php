<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleManagerController;

Route::middleware("auth")->group(function () {
   Route::get("/roles", [RoleManagerController::class, "show"])
       ->middleware("hasPermission:view")
       ->name("roleManager.show");

   Route::get("/rol", [RoleManagerController::class, "create"])
        ->middleware("hasPermission:create")
        ->name("roleManager.create");

   Route::post("/rol", [RoleManagerController::class, "store"])
       ->name("roleManager.store")
       ->middleware("hasPermission:create");

   Route::middleware("hasPermission:edit")->group(function () {
      Route::get("/rol/{role}/edit", [RoleManagerController::class, "edit"])
        ->name("roleManager.edit");

      Route::put("/rol/{role}", [RoleManagerController::class, "update"])
          ->name("roleManager.update");
   });
});

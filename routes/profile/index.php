<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckProfile;

Route::middleware("auth")->group(function () {

    Route::get("/perfil/{user}", [ProfileController::class, "showOne"])
        ->middleware("hasProfileOrPermission:edit")
        ->name("profile.show");

    Route::get("/perfil/{user}/contraseña", [ProfileController::class, "changePassword"])
        ->middleware("hasProfileOrPermission:changePassword")
        ->name("profile.changePassword");

    Route::get("/perfil/{user}/roles", [ProfileController::class, "editRoles"])
        ->middleware("hasProfileOrPermission:viewRoles")
        ->name("profile.viewRoles");

    Route::put("/perfil/{user}/contraseña", [ProfileController::class, "storePassword"])
        ->middleware("hasProfileOrPermission:changePassword")
        ->name("profile.storeChangePassword");

    Route::put("/perfil/{user}", [ProfileController::class, "update"])
        ->middleware("hasProfileOrPermission:changePassword")
        ->name("profile.update");

    Route::post("/perfil/{user}/roles", [ProfileController::class, "addRoles"])
        ->middleware("hasPermission:addRoles")
        ->name("profile.addRoles");

    Route::delete("/perfil/{user}/role/{role}", [ProfileController::class, "removeRole"])
        ->middleware("hasPermission:removeRoles")
        ->name("profile.removeRole");
});

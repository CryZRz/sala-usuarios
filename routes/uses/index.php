<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComputerUsesController;

Route::middleware("auth")
    ->middleware("moduleActive")
    ->group(function () {
    Route::get("/usos", [ComputerUsesController::class, "show"])
        ->middleware("hasPermission:view")
        ->name("computer.showUses");

    Route::middleware("hasPermission:create")->group(function () {
        Route::get("/uso", [ComputerUsesController::class, "create"])
            ->name("computer.createUse");
        Route::post("/uso", [ComputerUsesController::class, "store"])
            ->name("computer.storeUse");
    });

    Route::middleware("hasPermission:edit")->group(function () {
        Route::get("/uso/{id}", [ComputerUsesController::class, "edit"])
            ->name("computer.editUse");
        Route::post("/uso/actualizar", [ComputerUsesController::class, "update"])
            ->name("computer.updateUse");
    });

    Route::delete("/uso/eliminar/", [ComputerUsesController::class, "destroy"])
        ->middleware("hasPermission:delete")
        ->name("computer.destroyUse");
});

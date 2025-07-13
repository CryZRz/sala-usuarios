<?php

use App\Http\Controllers\ComputerController;
use App\Http\Controllers\UsosController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function(){
    Route::middleware("hasPermission:view")->group(function(){
        Route::get("/equipos", [ComputerController::class, "show"])
            ->name("computer.show");
    });

    Route::middleware("hasPermission:create", "hasPermissionMd:ports.create")
        ->group(function(){
            Route::get("/equipo", [ComputerController::class, "create"])
                ->name("computer.create");
            Route::post("/equipo", [ComputerController::class, "store"])
                ->name("computer.store");
        });

    Route::middleware("hasPermission:update")->group(function(){
        Route::get("/equipo/{computer}", [ComputerController::class, "edit"])
            ->name("computer.edit");
        Route::post("/equipo/{computer}", [ComputerController::class, "update"])
            ->name("computer.update");
    });

    Route::delete("/equipo/{computer}", [ComputerController::class, "destroy"])
        ->middleware("hasPermission:delete")
        ->name("computer.destroy");

    Route::get("/equipo/{computer}/programas", [ComputerController::class, "programsComputer"]);
    Route::delete("/equipo/{id}/programa/", [ComputerController::class, "removePorgram"]);

});

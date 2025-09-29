<?php

use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ComputerController;
use Illuminate\Support\Facades\Route;

Route::prefix("api")
    ->middleware("auth")
    ->group(function () {

        Route::middleware("hasPermission:view")->group(function () {
            Route::get("/programas", [ProgramController::class, "showApi"]);
            Route::get("/programas/{computer}", [ProgramController::class, "getByComputer"]);
            Route::get("/equipo/{computer}/programas-faltantes", [ComputerController::class, "missingPrograms"]);
        });


        Route::post("/equipo/{computer}/agregar-programas", [ComputerController::class, "addPrograms"])
            ->middleware("hasPermission:create");

        Route::delete("/equipo/{computer}/eliminar-programa/{program}", [ComputerController::class, "removeProgram"])
            ->middleware("hasPermission:delete");
    });

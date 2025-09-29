<?php

use App\Http\Controllers\ComputerSessionController;
use App\Http\Controllers\ComputerSessionHistoryController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get("/sesiones", [ComputerSessionController::class, "show"])
        ->middleware("hasPermission:view")
        ->name("session.show");

    Route::get("/sesion", [ComputerSessionController::class, "create"])
        ->middleware("hasPermission:create")
        ->name("session.new");

    Route::post("/sesion", [ComputerSessionController::class, "store"])
        ->middleware("hasPermission:create")
        ->name("session.store");

    Route::middleware("hasPermission:update")->group(function () {
        Route::post("/sesion/reasignarEquipo", [ComputerSessionController::class, "reasignarEquipo"])
            ->name("session.reassign");

        Route::post("/sesion/tiempo", [ComputerSessionController::class, "actualizarTiempo"])
            ->name("session.changeTime");
    });

    Route::middleware("hasPermission:delete")->group(function () {
        Route::delete("/sesion", [ComputerSessionController::class, "terminarSesion"])
            ->name("session.destroy");

        Route::delete("/sesiones", [ComputerSessionController::class, "terminarMultiples"])
            ->name("session.destroyMany");
    });

    //Para el historial
    Route::get("/historial-sesiones", [ComputerSessionHistoryController::class, "show"])
        ->middleware("hasPermission:history")
        ->name("session.history");
});

<?php

use App\Http\Controllers\ComputerSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get("/sesiones", [ComputerSessionController::class, "show"])
        ->middleware("hasPermission:view")
        ->name("session.show");

    Route::get("/sesion", [ComputerSessionController::class, "create"])
        ->middleware("hasPermissionMd:computerUses.view")
        ->middleware("hasPermission:create")
        ->name("session.new");

    Route::post("/sesion", [ComputerSessionController::class, "registrarSesion"])
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

        Route::delete("/session/terminar-num-euipo", [ComputerSessionController::class, "terminarSesionNumEquio"])
            ->name("session.destroy.num.computer");

        Route::delete("/session/terminar-num-control", [ComputerSessionController::class, "terminarSesionNumControl"])
            ->name("session.destroy.num.control");

        Route::delete("/sesiones", [ComputerSessionController::class, "terminarMultiples"])
            ->name("session.destroyMany");
    });

    Route::post("/sesion-estudiante", [ComputerSessionController::class, "createSessionAndStudent"]);
});

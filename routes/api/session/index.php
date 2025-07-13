<?php

use App\Http\Controllers\ComputerSessionController;
use Illuminate\Support\Facades\Route;

Route::prefix("/api")
    ->middleware("auth")
    ->group(function () {
        Route::get("/sesion/{numControl}", [ComputerSessionController::class, "getInfoStudentForSession"])
            ->name("hasPermissionMd:student.view")
            ->name("session.loadStudent");

        Route::get("/cargarEquipos", [ComputerSessionController::class, "cargarEquipos"])
            ->middleware("hasPermissionMd:computer.view")
            ->name("session.loadComputers");

        Route::get("/cargarEquiposUso", [ComputerSessionController::class, "cargarEquiposUso"])
            ->middleware("hasPermissionMd:computerUses.view")
            ->name("session.loadComputersUse");

        Route::get("/sesiones/activas", [ComputerSessionController::class, "checkSessionsActiveUser"])
            ->name("session.active");
    });

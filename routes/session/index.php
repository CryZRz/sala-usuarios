<?php

use App\Http\Controllers\PrestamosController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get("/sesiones", [PrestamosController::class, "mostrarSesiones"])
        ->name("session.show");
    Route::get("/sesion", [PrestamosController::class, "create"])
        ->name("session.new");

    Route::post("/sesion/reasignarEquipo", [PrestamosController::class, "reasignarEquipo"])
        ->name("session.reassign");

    Route::delete("/sesion", [PrestamosController::class, "terminarSesion"])->name("session.destroy");
    Route::delete("/session/terminar-num-euipo", [PrestamosController::class, "terminarSesionNumEquio"])
        ->name("session.destroy.num.computer");
    Route::delete("/session/terminar-num-control", [PrestamosController::class, "terminarSesionNumControl"])
        ->name("session.destroy.num.control");

    Route::delete("/sesiones", [PrestamosController::class, "terminarMultiples"])
        ->name("session.destroyMany");

    //Creación de sesión
    Route::get("/sesion/{numControl}", [PrestamosController::class, "getInfoStudentForSession"])
        ->name("session.loadStudent");
    Route::get("/cargarEquipos", [PrestamosController::class, "cargarEquipos"])
        ->name("session.loadComputers");
    Route::get("/cargarEquiposUso", [PrestamosController::class, "cargarEquiposUso"])
        ->name("session.loadComputersUse");


    Route::post("/sesion", [PrestamosController::class, "registrarSesion"])
        ->name("session.store");
    Route::post("/sesion-estudiante", [PrestamosController::class, "createSessionAndStudent"]);
    Route::post("/sesion/tiempos", [PrestamosController::class, "actualizarTiempos"])
        ->name("session.changeTimes");
    Route::post("/sesion/tiempo", [PrestamosController::class, "actualizarTiempo"])
        ->name("session.changeTime");

    Route::get("/sesiones/activas", [PrestamosController::class, "checkSessionsActiveUser"])
        ->name("session.active");
});

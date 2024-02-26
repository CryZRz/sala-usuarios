<?php

use App\Http\Controllers\PrestamosController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    //Listado de sesiones
    Route::get("/sesiones", [PrestamosController::class, "mostrarSesiones"])->name("session.show");
    Route::get("/sesion", [PrestamosController::class, "mostrarCreacion"])->name("session.new");
    //Reasignar equipo desde la barra de navegación incluye el núm. de sesión en el formulario.
    Route::post("/sesiones/{numSesion?}", [PrestamosController::class, "reasignarEquipo"])->name("session.reassign");
    Route::delete("/sesion/{numSesion?}", [PrestamosController::class, "terminarSesion"])->name("session.destroy");
    Route::delete("/sesiones/{numsSesion?}", [PrestamosController::class, "terminarMultiples"])->name("session.destroyMany");

    //Creación de sesión
    Route::get("/sesion/{numControl}", [PrestamosController::class, "cargarAlumno"])->name("session.loadStudent");
    Route::get("/cargarUsos", [PrestamosController::class, "cargarUsos"])->name("session.loadUses");
    Route::get("/cargarEquipos", [PrestamosController::class, "cargarEquipos"])->name("session.loadComputers");
    Route::get("/cargarEquiposUso", [PrestamosController::class, "cargarEquiposUso"])->name("session.loadComputersUse");
    Route::get("/cargarCarreras", [PrestamosController::class, "cargarCarreras"])->name("session.loadCareers");
    Route::post("/sesion", [PrestamosController::class, "registrarSesion"])->name("session.store");
    Route::post("/sesion/tiempos", [PrestamosController::class, "actualizarTiempos"])->name("session.changeTimes");
    Route::post("/sesion/tiempo", [PrestamosController::class, "actualizarTiempo"])->name("session.changeTime");
});

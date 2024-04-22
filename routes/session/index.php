<?php

use App\Http\Controllers\PrestamosController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    // Muestra de las sesiones
    Route::get("/sesiones", [PrestamosController::class, "mostrarSesiones"])->name("session.show");
    Route::get("/sesion", [PrestamosController::class, "mostrarCreacion"])->name("session.new");
    Route::get("/contarSesiones", [PrestamosController::class, "contarSesiones"])->name("session.count");

    // Reasignar equipo y terminar sesión desde la tabla de préstamos envían de parámetro el núm. sesión;
    // desde la barra de navegación, se incluye este, o el núm. de equipo, en los datos del formulario.
    Route::post("/sesiones/{numSesion?}", [PrestamosController::class, "reasignarEquipo"])->name("session.reassign");
    Route::delete("/sesion/{numSesion?}", [PrestamosController::class, "terminarSesion"])->name("session.destroy");
    
    // La acción del botón terminarMúltiples es esta ruta; sin embargo, los núms. de sesión se recopilan
    // y concatenan a la ruta con js hasta el momento de dar clic al botón. 
    // Para definirla como acción del botón usando el nombre de la ruta, considera que el parámetro sea opcional. 
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

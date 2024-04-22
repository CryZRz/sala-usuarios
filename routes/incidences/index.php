<?php

use App\Http\Controllers\IncidenciasController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    // Muestra de la lista de incidencias
    Route::get("/incidencias", [IncidenciasController::class, "mostrarIncidencias"])->name("incidence.show");
    Route::get("/incidencias/alumno", [IncidenciasController::class, "buscarEstudiante"])->name("incidence.showStudent");
    Route::get("/incidencias/resueltas", [IncidenciasController::class, "mostrarIncidenciasResueltas"])->name("incidence.showSolved");

    // Creación y modificación de incidencias
    Route::post("/incidencia", [IncidenciasController::class, "registrarIncidencia"])->name("incidence.store");
    Route::post("/incidencia/editar", [IncidenciasController::class, "actualizarIncidencia"])->name("incidence.update");
    Route::delete("/incidencia/{id}", [IncidenciasController::class, "terminarIncidencia"])->name("incidence.destroy");
});
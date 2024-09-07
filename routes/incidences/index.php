<?php

use App\Http\Controllers\IncidenciasController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    // Muestra de la lista de incidencias
    Route::get("/incidencia", [IncidenciasController::class, 'create'])->name('incidence.create');
    Route::get("/incidencia/{id}", [IncidenciasController::class, 'showOne'])->name('incidence.showOne');
    Route::get("/incidencias", [IncidenciasController::class, "show"])->name("incidence.show");
    Route::get("/incidencias/alumno", [IncidenciasController::class, "buscarEstudiante"])->name("incidence.showStudent");
    Route::get("/incidencias/resueltas", [IncidenciasController::class, "mostrarIncidenciasResueltas"])->name("incidence.showSolved");

    // Creación y modificación de incidencias
    Route::post("/incidencia", [IncidenciasController::class, "store"])->name("incidence.store");
    Route::put("/incidencia/{incidence}", [IncidenciasController::class, "update"])->name("incidence.update");
    Route::delete("/incidencia/{incidence}", [IncidenciasController::class, "destroy"])->name("incidence.destroy");
});

<?php

use App\Http\Controllers\IncidenciasController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    // Muestra de la lista de incidencias
    Route::middleware("hasPermission:create")->group(function () {
        Route::get("/incidencia", [IncidenciasController::class, 'create'])
            ->name('incidence.create');
        Route::post("/incidencia", [IncidenciasController::class, "store"])
            ->name("incidence.store");
    });

    Route::get("/incidencia/{id}/detalle", [IncidenciasController::class, 'showOne'])
        ->middleware("hasPermission:detail")
        ->name('incidence.showOne');

    Route::get("/incidencias", [IncidenciasController::class, "show"])
        ->middleware("hasPermission:view")
        ->name("incidence.show");

    Route::middleware("hasPermission:edit")->group(function () {
        Route::put("/incidencia/{incidence}", [IncidenciasController::class, "update"])
            ->name("incidence.update");
        Route::get("/incidencia/{incidence}", [IncidenciasController::class, "edit"])
            ->name("incidence.edit");
    });


    Route::delete("/incidencia/{incidence}", [IncidenciasController::class, "destroy"])
        ->middleware("hasPermission:delete")
        ->name("incidence.destroy");
});

<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function (){
    Route::middleware("hasPermission:view")->group(function (){
        Route::get("/estudiantes", [StudentController::class, "showAll"])
            ->name("student.showAll");
        Route::get("/estudiantes/buscar", [StudentController::class, "findAll"])
            ->name("student.findAll");
        //TODO: mover /estudiante/{numControl} a API
        Route::get("/estudiante/{numControl}", [StudentController::class, "findOne"])
            ->name("student.search");
        Route::get("/estudiante/info/{controlNumber}/sesiones", [StudentController::class, "showOneSessions"])
            ->name("student.show.one.sessions");
        Route::get("/estudiante/info/{controlNumber}/incidencias", [StudentController::class, "showOneIncidences"])
            ->name("student.show.one.incidences");
    });

    Route::middleware("hasPermission:create")->group(function (){
        Route::get("/estudiante", [StudentController::class, "show"])
            ->name("student.show");
        Route::post("/estudiante", [StudentController::class, "store"])
            ->name("student.store");
    });

    Route::middleware("hasPermission:update")->group(function (){
        Route::get("/estudiante/edit/{controlNumber}", [StudentController::class, "edit"])
            ->name("student.edit");
        Route::post("/estudiante/{controlNumber}", [StudentController::class, "update"])
            ->name("student.update");
    });
});

<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function (){
    Route::middleware("hasPermission:view")->group(function (){
        Route::get("/estudiantes", [StudentController::class, "showAll"])
            ->middleware("hasPermission:view")
            ->name("student.showAll");

        //TODO: mover /estudiante/{numControl} a API
        Route::get("/estudiante/{numControl}", [StudentController::class, "findOne"])
            ->middleware("hasPermission:consult")
            ->name("student.search");

        //TODO: Refactorizar
        Route::get("/estudiante/info/{controlNumber}/sesiones", [StudentController::class, "showOneSessions"])
            ->name("student.show.one.sessions");
        Route::get("/estudiante/info/{controlNumber}/incidencias", [StudentController::class, "showOneIncidences"])
            ->name("student.show.one.incidences");
    });

    Route::get("/estudiantes/exportarXlsx", [StudentController::class, "exportToExcel"])
        ->name("students.export.xlsx");

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

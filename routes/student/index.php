<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function (){
    Route::get("/estudiantes", [StudentController::class, "showAll"])
        ->name("student.showAll");
    Route::get("/estudiantes/buscar", [StudentController::class, "findAll"])
        ->name("student.findAll");
    Route::get("/estudiante", [StudentController::class, "show"])
        ->name("student.show");
    Route::get("/estudiante/{numControl}", [StudentController::class, "search"])
        ->name("student.search");
    Route::post("/estudiante", [StudentController::class, "store"])
        ->name("student.store");
    Route::get("/estudiante/edit/{controlNumber}", [StudentController::class, "edit"])
        ->name("student.edit");
    Route::get("/estudiante/info/{controlNumber}/sesiones", [StudentController::class, "showOneSessions"])
        ->name("student.show.one.sessions");
    Route::get("/estudiante/info/{controlNumber}/incidencias", [StudentController::class, "showOneIncidences"])
        ->name("student.show.one.incidences");
    Route::post("/estudiante/{controlNumber}", [StudentController::class, "update"])
        ->name("student.update");
});

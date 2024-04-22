<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function (){
    Route::get("/estudiantes", [StudentController::class, "showAll"])->name("student.showAll");
    Route::get("/estudiante", [StudentController::class, "show"])->name("student.show");
    Route::get("/estudiante/{numControl}", [StudentController::class, "search"])->name("student.search");
    Route::post("/estudiante", [StudentController::class, "store"])->name("student.store");
    Route::get("/estudiante/{student}", [StudentController::class, "edit"])->name("student.edit");
    Route::post("/estudiante/{student}", [StudentController::class, "update"])->name("student.update");
    Route::delete("/estudiante/{student}", [StudentController::class, "destroy"])->name("student.destroy");
});

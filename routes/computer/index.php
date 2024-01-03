<?php

use App\Http\Controllers\ComputerController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function(){
    Route::get("/equipos", [ComputerController::class, "show"])->name("computer.show");
    Route::get("/equipo", [ComputerController::class, "create"])->name("computer.create");
    Route::post("/equipo", [ComputerController::class, "store"])->name("computer.store");
    Route::get("/equipo/{computer}", [ComputerController::class, "edit"])->name("computer.edit");
    Route::get("/equipo-programas/{computer}", [ComputerController::class, "programsComputer"]);
    Route::delete("/equipo-programa/{id}", [ComputerController::class, "removePorgram"]);
    Route::post("/equipo-puerto/{id}", [ComputerController::class, "updatePort"]);
    Route::delete("/equipo-puerto/{id}", [ComputerController::class, "removePort"]);
    Route::delete("/equipo/{computer}", [ComputerController::class, "destroy"])->name("computer.destroy");
    Route::post("/equipo/{computer}", [ComputerController::class, "update"])->name("computer.update");
});
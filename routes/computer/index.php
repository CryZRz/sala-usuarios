<?php

use App\Http\Controllers\ComputerController;
use App\Http\Controllers\UsosController;
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

    Route::get("/usos", [UsosController::class, "mostrar"])->name("computer.showUses");
    Route::get("/uso", [UsosController::class, "mostrarCrear"])->name("computer.createUse");
    Route::post("/uso", [UsosController::class, "crear"])->name("computer.storeUse");
    Route::get("/uso/{id}", [UsosController::class, "mostrarEditar"])->name("computer.editUse");
    Route::post("/uso/actualizar", [UsosController::class, "editar"])->name("computer.updateUse");
    Route::delete("/uso/eliminar/{id}", [UsosController::class, "eliminar"])->name("computer.destroyUse");
});
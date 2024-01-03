<?php

use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function(){
    Route::get("/programas", [ProgramController::class, "show"])->name("program.show");
    Route::get("/programa", [ProgramController::class, "create"])->name("program.create");
    Route::post("/programa", [ProgramController::class, "store"])->name("program.store");
    Route::get("/programa/{program}", [ProgramController::class, "edit"])->name("program.edit");
    Route::put("/programa", [ProgramController::class, "update"])->name("program.update");
});
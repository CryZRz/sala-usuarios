<?php

use App\Http\Controllers\Importes\ImporteController;

use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get("/importar", [ImporteController::class, "mostrar"])->name("importe.show");
    Route::post("/importar/subir", [ImporteController::class, "subirRegistros"])->name("importe.upload");
});
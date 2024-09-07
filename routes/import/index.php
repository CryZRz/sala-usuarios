<?php

use App\Http\Controllers\Importes\ImporteController;

use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get("/importar", [ImporteController::class, "show"])->name("import.show");
    Route::post("/importar/subir", [ImporteController::class, "store"])->name("import.upload");
});

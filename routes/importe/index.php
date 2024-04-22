<?php

use App\Http\Controllers\ImporteController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get("/importar", [ImporteController::class, "mostrar"])->name("importe.show");
});
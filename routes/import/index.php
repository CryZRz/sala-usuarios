<?php

use App\Http\Controllers\Importes\ImporteController;

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\PendingImportMd;

Route::middleware("auth")
    ->middleware("hasPermission:import")
    ->group(function () {
    Route::get("/importar", [ImporteController::class, "show"])
        ->name("import.show")
        ->middleware(PendingImportMd::class);

    Route::post("/importar/{id}", [ImporteController::class, "store"])
        ->name("import.upload");

    Route::post("/importar", [ImporteController::class, "importPending"])
        ->name("import.uploadPending");

    Route::get("/importar/pendiente/{id}", [ImporteController::class, "pendingImport"])
        ->name("import.showPending");

    Route::delete("/importar/subir/cancelar/{id}", [ImporteController::class, "destroyPendingImport"])
        ->name("import.destroyPending");
});
